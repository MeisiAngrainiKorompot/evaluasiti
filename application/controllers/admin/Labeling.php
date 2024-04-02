<?php 

require 'vendor/autoload.php';
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Dictionary\ArrayDictionary;
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\Tokenizer\TokenizerFactory;

class Labeling extends CI_Controller { 
	public function __construct() {
		parent::__construct();
		$this->load->model('LppmModel');
	}
	

	public function index () {
		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

		$data['title'] = "Hasil Labeling";
		//$data['training'] = $this->LppmModel->get_data('stemming')->result();
		$data['training'] = $this->db->query("SELECT a.*, b.*, c.* FROM stemming a LEFT JOIN mata_kuliah b ON a.mata_kuliah = b.nama_mata_kuliah LEFT JOIN semester c ON b.id_semester = c.id_semester")->result();
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/labeling', $data);
		$this->load->view('templates_admin/footer');
	}
	
	public function labeling(){
		//ambil data evaluasi dari database
		$data_evaluasi = $this->LppmModel->get_data('stemming')->result_array();
		
		$lexicon_file_new = APPPATH . 'lexicon/new_lexicon.csv';

		$lexicon_new = array();

		//load file tsv new
		if (($handle = fopen($lexicon_file_new, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 15000, ",")) !== FALSE) {
				$lexicon_new[$data[0]] = $data[1];
			}
			fclose($handle);
		}

		//menggabungkan kedua array
		$lexicon = array_merge($lexicon_new);
	
		//lakukan labeling otomatis untuk setiap data evaluasi
		foreach ($data_evaluasi as $evaluasi) {
			$ulasan = $evaluasi['ulasan'];

			//lakukan preprocessing pada $ulasan
			$ulasan = strtolower($ulasan); //ubah huruf besar menjadi huruf kecil
			$ulasan = preg_replace('/[^a-zA-Z0-9\s]/', '', $ulasan); //hapus karakter selain huruf dan angka
			$ulasan = preg_replace('/\s\s+/', ' ', $ulasan); //hapus spasi berlebih
			$ulasan = trim($ulasan); //hapus spasi di awal dan akhir teks

			//hitung skor sentiment
			$skor_sentiment = 0;
			$jumlah_kata = 0;
			$kata_positif = 0;
			$kata_negatif = 0;

			$kata = str_word_count($ulasan, 1);
			foreach ($kata as $kata_evaluasi) {
				if (isset($lexicon[$kata_evaluasi])) {
					$skor_sentiment += $lexicon[$kata_evaluasi];
					$jumlah_kata++;

					if ($lexicon[$kata_evaluasi] > 0) {
						$kata_positif++;
					} elseif ($lexicon[$kata_evaluasi] < 0) {
						$kata_negatif++;
					}
				} else {
					$jumlah_kata++;
				}
			}
 
			if($skor_sentiment > -6){
				$label_sentiment = 'Positif';
			}elseif($skor_sentiment < -9){
				$label_sentiment = 'Negatif';
			}else{
				$label_sentiment = 'Netral';
			}
	
			//update label sentiment pada database
			$data_update = array(
				'sentiment' => $label_sentiment
			);
			$where = array(
				'id_stemming' => $evaluasi['id_stemming']
			);
			$this->LppmModel->update_data('stemming', $data_update, $where);
		}
	
		$this->session->set_flashdata ('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
		<strong>Labeling otomatis selesai!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
		</div>');
			
		redirect('admin/labeling');
	}
}

	?>