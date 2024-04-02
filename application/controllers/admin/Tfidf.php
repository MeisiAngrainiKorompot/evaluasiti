<?php 

require 'vendor/autoload.php';

use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\Classification\KNearestNeighbors;

class Tfidf extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('LppmModel');
    }

    public function index() {
        $data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
        $data['clean'] = $this->db->query('SELECT * FROM  cleaning');
        $data['stop'] = $this->db->query('SELECT * FROM  stopword');
        $data['stem'] = $this->db->query('SELECT * FROM  stemming');
        $data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
        $data['train'] = $this->db->query('SELECT * FROM  data_training');
        $data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

        $data['title'] = "TF-IDF";
        $data['training'] = $this->LppmModel->get_data('data_training')->result();
        $data['testing'] = $this->LppmModel->get_data('data_testing')->result();
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/tfidf', $data);
        $this->load->view('templates_admin/footer');
    }

    public function process_tfidf() {
       ini_set('memory_limit', '1024M');

        // Mengambil semua data training dan testing
       $documents = array();
       $sentiments = array();
       $data_training = $this->LppmModel->get_data('data_training')->result();
       $data_testing = $this->LppmModel->get_data('data_testing')->result();

        // tambahan kode untuk memfilter data null
       $data_training = array_filter($data_training, function($data) {
        return $data->document !== null;
    });
       $data_testing = array_filter($data_testing, function($data) {
        return $data->document !== null;
    });

       foreach ($data_training as $data) {
        $documents[] = $data->document;
        $sentiments[] = $data->sentiment;
    }
    foreach ($data_testing as $data) {
        $documents[] = $data->document;
        $sentiments[] = $data->sentiment;
    }

        // // Membuat objek WhitespaceTokenizer
        // $vectorizer = new WhitespaceTokenizer();

        // // Tokenisasi setiap dokumen pada array
        // $tokenized_documents = array_map(function($doc) use ($vectorizer) {
        //     return $vectorizer->tokenize($doc);
        // }, $documents);

        // echo count($tokenized_documents);

        // print_r($tokenized_documents);

    $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());

        // Build the dictionary.
    $vectorizer->fit($documents);

        // Transform the provided text samples into a vectorized list.
    $vectorizer->transform($documents);

    $vocab = $vectorizer->getVocabulary();

    

        // Simpan vocab ke database
    $data = array(
        'vocab' => json_encode($vocab)
    );
    $where = array('id' => 1);
    $result = $this->LppmModel->get_data('vocab')->result();
    if (!empty($result)) {
     $this->LppmModel->update_data('vocab', $data, $where);
 } else {
     $this->LppmModel->insert_data($data, 'vocab');
 }


        // Membuat objek TfIdfTransformer
 $tfidf_vectors = new TfIdfTransformer($documents);
 
 $tfidf_vectors->transform($documents);

        // $count = count($documents);
        // echo "Jumlah array pada variabel \$documents: " . $count;

        // Memasukkan hasil perhitungan TF-IDF ke dalam basis data
 foreach ($data_training as $i => $data) {
    if (isset($documents[$i])) {
        $document_tfidf = $documents[$i];
        if (!empty($document_tfidf)) {
            $this->LppmModel->update_data('data_training', array('tfidf' => json_encode($document_tfidf)), array('id_data_training' => $data->id_data_training));
        }
    }
}
foreach ($data_testing as $i => $data) {
    if (isset($documents[$i])) {
        $document_tfidf = $documents[$i];
        if (!empty($document_tfidf)) {
            $this->LppmModel->update_data('data_testing', array('tfidf' => json_encode($document_tfidf)), array('id_data_testing' => $data->id_data_testing));
        }
    }
    $i++;
}      

        // Menampilkan pesan sukses
$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Proses perhitungan TF-IDF berhasil dilakukan!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>');

        // Kembali ke halaman utama
redirect('admin/tfidf');
}

public function create_knn_model() {
        // Mendapatkan data training yang sudah dihitung tf-idf
    $data_training = $this->LppmModel->get_data('data_training')->result();
    $tfidf_training = array();
    $sentiment_training = array();
    foreach ($data_training as $data) {
        if (!empty($data->tfidf)) {
            $tfidf = json_decode($data->tfidf, true);
            $tfidf_training[] = $tfidf;
            $sentiment_training[] = $data->sentiment;
        }
    }

        // Membuat instance KNearestNeighbors dengan parameter k=5
    $classifier = new KNearestNeighbors(5);

        // Melakukan training pada model
    $classifier->train($tfidf_training, $sentiment_training);

        // Menyimpan model pada file
    $model_file = APPPATH . 'models/knn_model.phpml';
    $serialized_model = serialize($classifier);
    file_put_contents($model_file, $serialized_model);

        // Menampilkan pesan sukses
    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Model KNN berhasil dibuat dan disimpan!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');

        // Kembali ke halaman utama
    redirect('admin/tfidf');
}

public function vocab() {
  $result = $this->db->query("SELECT * FROM vocab")->result();
  $vocab = !empty($result) ? json_decode($result[0]->vocab) : array();
  $wordFrequencies = $this->calculateWordFrequencies($vocab);
  $data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
  $data['clean'] = $this->db->query('SELECT * FROM  cleaning');
  $data['stop'] = $this->db->query('SELECT * FROM  stopword');
  $data['stem'] = $this->db->query('SELECT * FROM  stemming');
  $data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
  $data['train'] = $this->db->query('SELECT * FROM  data_training');
  $data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');
		// Menyiapkan data untuk dikirim ke view
  $data['vocab'] = $vocab;
  $data['wordFrequencies'] = $wordFrequencies;
  
		// Mengurutkan frekuensi kata dari yang terbanyak
  arsort($data['wordFrequencies']);
  $data['title'] = "VOCAB";
  $this->load->view('templates_admin/header', $data);
  $this->load->view('templates_admin/sidebar');
  $this->load->view('admin/data_vocab', $data);
  $this->load->view('templates_admin/footer');
}

private function calculateWordFrequencies($vocab) {
		// Mengambil data teks dari database
  $result = $this->db->query("SELECT * FROM stemming")->result();
  $text = '';
  foreach ($result as $row) {
     $text .= $row->ulasan . ' ';
 }
 
		// Memecah teks menjadi kata-kata
 $words = explode(' ', strtolower($text));
 
		// Menginisialisasi array frekuensi kata
 $wordFrequencies = array();
 
		// Menghitung frekuensi kata berdasarkan kamus
 foreach ($vocab as $word) {
     $frequency = 0;
     foreach ($words as $w) {
        if ($w === $word) {
           $frequency++;
       }
   }
   $wordFrequencies[$word] = $frequency;
}

return $wordFrequencies;
}	
}
