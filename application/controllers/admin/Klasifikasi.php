<?php 

require 'vendor/autoload.php';

//use Phpml\Classification\KNearestNeighbors;
use Phpml\ModelManager;
use Phpml\Metric\ClassificationReport;
//use Phpml\Metric\ConfusionMatrix;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;
use Rubix\ML\CrossValidation\Reports\ContingencyTable;
use Rubix\ML\CrossValidation\Reports\MulticlassReport;
use Rubix\ML\CrossValidation\KFold;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Kernels\Distance\Manhattan;
use Rubix\ML\Kernels\Distance\Euclidean;
use Phpml\CrossValidation\StratifiedKFold;
use Phpml\Dataset\ArrayDataset;
use Rubix\ML\Report;
use Rubix\ML\CrossValidation\Metrics\Accuracy;
use Rubix\ML\CrossValidation\Reports\MulticlassBreakdown;
use Rubix\ML\CrossValidation\Reports\ConfusionMatrix;
use Rubix\ML\PersistentModel;
use Rubix\ML\Serializers\NativeSerializer;
use Rubix\ML\Datasets\Unlabeled;


class Klasifikasi extends CI_Controller
{ 
	public function __construct() {
		parent::__construct();
		$this->load->model('LppmModel');
	}

	public function index()
	{
		$this->load->database();
		
		// Mengambil data laporan dari tabel 'report'
		$report = $this->db->get('report')->row_array();
		
		if (!empty($report)) {
			$data = [
				'accuracy' => $report['accuracy'],
				'f1_score' => $report['f1_score'],
				'precision' => $report['precision'],
				'recall' => $report['recall'],
			];
		} else {
			$data = [
				'accuracy' => 0,
				'f1_score' => 0,
				'precision' => 0,
				'recall' => 0,
			];
		}

		// Mengambil data matrix dari tabel 'matrix'
		$matrix = $this->db->get('matrix')->result();

		// Menyimpan data matrix ke dalam array
		$data['confusion_matrix'] = [];
		foreach ($matrix as $item) {
			$matrix_data = json_decode($item->matrix, true);
			$data['confusion_matrix'][] = $matrix_data;
		}

		// Mengambil data fold dari tabel 'fold'
		$fold = $this->db->get('fold')->result();
		
		// Menyimpan data fold ke dalam array
		$data['fold'] = [];
		foreach ($fold as $item) {
			$data['fold'][] = [
				'id_fold' => $item->id_fold,
				'fold' => $item->fold,
				'accuracy' => $item->accuracy,
			];
		}

		// Mengambil data evaluasi dari tabel 'evaluasi'
		$evaluasi = $this->LppmModel->get_data('stemming')->result();
		
        // Menghitung jumlah data evaluasi dengan masing-masing label
		$jumlah_negatif = 0;
		$jumlah_netral = 0;
		$jumlah_positif = 0;
		foreach ($evaluasi as $item) {
			if ($item->sentiment == 'Negatif') {
				$jumlah_negatif++;
			} elseif ($item->sentiment == 'Netral') {
				$jumlah_netral++;
			} elseif ($item->sentiment == 'Positif') {
				$jumlah_positif++;
			}
		}
		
        // Menyimpan jumlah data evaluasi dengan masing-masing label ke dalam array
		$data['jumlah_evaluasi'] = [
			'Negatif' => $jumlah_negatif,
			'Netral' => $jumlah_netral,
			'Positif' => $jumlah_positif
		];
		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');
		$data['test'] = true;
		$data['test_result'] = null;
		$data['title'] = "Klasifikasi Data Uji";
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/klasifikasi', $data);
		$this->load->view('templates_admin/footer');
	}	

	public function change_k()
	{
		$kValue = $this->input->post('kValue');

		if (!is_numeric($kValue) || $kValue < 1) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Nilai K tidak valid! Nilai K harus berupa angka positif.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		} else {
			$this->klasifikasi($kValue);

			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				Model KNN berhasil dibuat dan disimpan dengan nilai K = ' . $kValue . '!
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		}

		redirect('admin/klasifikasi');
	}

	public function klasifikasi($kValue = null)
	{
		ini_set('memory_limit', '1024M');
		
		if ($kValue) {
			$this->load->database();
			
			// Mengosongkan tabel 'fold'
			$this->db->empty_table('fold');
			
			// Mengosongkan tabel 'report'
			$this->db->empty_table('report');
			
			// Mengosongkan tabel 'matrix'
			$this->db->empty_table('matrix');
			
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
			
			// Melakukan proses klasifikasi dan evaluasi menggunakan K-fold cross-validation
			$dataset = new Labeled($tfidf_training, $sentiment_training);
			$estimator = new KNearestNeighbors($kValue, false, new Manhattan());
			
			$validator = new KFold($kValue, true);
			$scores = [];
			$predictions = [];
			$labels = [];
			for ($i = 0; $i < $kValue; $i++) {
				$score = $validator->test($estimator, $dataset, new Accuracy());
				$scores[] = $score;
				$predictions = array_merge($predictions, $estimator->predict($dataset));
				$labels = array_merge($labels, $dataset->labels());
			}
			
			// Menyimpan hasil evaluasi fold ke tabel 'fold'
			foreach ($scores as $fold => $score) {
				$data = array(
					'fold' => $fold + 1,
					'accuracy' => $score,
				);
				$this->db->insert('fold', $data);
			}
			
			// Generate multiclass breakdown report
			$report = new MulticlassBreakdown();
			$results = $report->generate($predictions, $labels);
			
			// Mendapatkan metrik dari laporan multiclass breakdown
			$overallAccuracy = $results['overall']['accuracy'];
			$overallF1Score = $results['overall']['f1 score'];
			$overallPrecision = $results['overall']['precision'];
			$overallRecall = $results['overall']['recall'];
			
			// Menyimpan laporan multiclass breakdown ke tabel 'report'
			$data = array(
				'accuracy' => $overallAccuracy,
				'f1_score' => $overallF1Score,
				'precision' => $overallPrecision,
				'recall' => $overallRecall,
			);
			$this->db->insert('report', $data);
			
			// Generate confusion matrix
			$conf = new ConfusionMatrix();
			$confusionMatrix = $conf->generate($predictions, $labels);
			
			// Menyimpan matriks kebingungan ke tabel 'matrix'
			$data = array(
				'matrix' => json_encode($confusionMatrix),
			);
			$this->db->insert('matrix', $data);

			$model_file = APPPATH . 'models/knn_model.php';

			// Menyimpan model ke file
			file_put_contents($model_file, serialize($estimator));
		}
	}
	
	
	public function test_model() {
		$model_file = APPPATH . 'models/knn_model.php';
		$serialized_model = file_get_contents($model_file);
		$classifier = unserialize($serialized_model);
		
		$data = [];
		$test_result = null;
		
		if ($this->input->post('testData')) {
			$data_test = $this->input->post('testData');
			
			$preprocessed_data = array_map(function($text){
				//lakukan preprocessing pada $text
				$text = strtolower($text); //ubah huruf besar menjadi huruf kecil
				$text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text); //hapus karakter selain huruf dan angka
				$text = preg_replace('/\s\s+/', ' ', $text); //hapus spasi berlebih
				$text = trim($text); //hapus spasi di awal dan akhir teks        
				return $text;
			}, (array) $data_test);
			
			// Mengambil semua data training dan testing
			$documents = array();
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
			}
			foreach ($data_testing as $data) {
				$documents[] = $data->document;
			}
			
			// Menerapkan tokenisasi pada data 
			$vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());

			// Menerapkan tokenisasi pada data 
			$vectorizer->fit($documents);
			$vectorizer->transform($documents);
			$vectorizer->transform($preprocessed_data);
			
			// Membuat objek TfIdfTransformer 
			$tfidf_transformer = new TfIdfTransformer($documents);
			$tfidf_transformer->fit($documents);
			
			// Menerapkan tf-idf pada data uji
			$tfidf_transformer->transform($preprocessed_data);

			// Preprocess the test data
			$preprocessedData = new Unlabeled($preprocessed_data);
			
			// Check if the number of features in the test data matches the number of features in the training data
			if (count($preprocessedData[0]) == count($documents[0])) {
				$prediction = $classifier->predict($preprocessedData);
				$test_result = json_encode($prediction);
			} else {
				$test_result = "Error: Jumlah fitur pada data uji tidak sesuai dengan jumlah fitur pada data latih";
			}
		}
		

		$this->load->database();
		
		// Mengambil data laporan dari tabel 'report'
		$report = $this->db->get('report')->row_array();
		
		if (!empty($report)) {
			$data = [
				'accuracy' => $report['accuracy'],
				'f1_score' => $report['f1_score'],
				'precision' => $report['precision'],
				'recall' => $report['recall'],
			];
		} else {
			$data = [
				'accuracy' => 0,
				'f1_score' => 0,
				'precision' => 0,
				'recall' => 0,
			];
		}

		// Mengambil data matrix dari tabel 'matrix'
		$matrix = $this->db->get('matrix')->result();

		// Menyimpan data matrix ke dalam array
		$data['confusion_matrix'] = [];
		foreach ($matrix as $item) {
			$matrix_data = json_decode($item->matrix, true);
			$data['confusion_matrix'][] = $matrix_data;
		}

		// Mengambil data fold dari tabel 'fold'
		$fold = $this->db->get('fold')->result();
		
		// Menyimpan data fold ke dalam array
		$data['fold'] = [];
		foreach ($fold as $item) {
			$data['fold'][] = [
				'id_fold' => $item->id_fold,
				'fold' => $item->fold,
				'accuracy' => $item->accuracy,
			];
		}

		// Mengambil data evaluasi dari tabel 'evaluasi'
		$evaluasi = $this->LppmModel->get_data('evaluasi')->result();
		
        // Menghitung jumlah data evaluasi dengan masing-masing label
		$jumlah_negatif = 0;
		$jumlah_netral = 0;
		$jumlah_positif = 0;
		foreach ($evaluasi as $item) {
			if ($item->sentiment == 'Negatif') {
				$jumlah_negatif++;
			} elseif ($item->sentiment == 'Netral') {
				$jumlah_netral++;
			} elseif ($item->sentiment == 'Positif') {
				$jumlah_positif++;
			}
		}
		
        // Menyimpan jumlah data evaluasi dengan masing-masing label ke dalam array
		$data['jumlah_evaluasi'] = [
			'Negatif' => $jumlah_negatif,
			'Netral' => $jumlah_netral,
			'Positif' => $jumlah_positif
		];

		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

		
		$data['test'] = true;
		$data['test_result'] = $test_result;
		$data['title'] = "Klasifikasi Data Uji";
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/klasifikasi', $data);
		$this->load->view('templates_admin/footer');
	}
	
}
