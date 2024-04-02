<?php 

require 'vendor/autoload.php';
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Dictionary\ArrayDictionary;
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\Tokenizer\TokenizerFactory;

class Evaluasi extends CI_Controller { 
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


		$data['title'] = "Data Evaluasi Mahasiswa";
		//$data['training'] = $this->LppmModel->get_data('evaluasi')->result();
		// $data['training'] = $this->db->query("SELECT a.*, b.*, c.*, d.nama, e.* FROM evaluasi a LEFT JOIN mata_kuliah b ON a.mata_kuliah = b.id_mata_kuliah LEFT JOIN semester c ON b.id_semester = c.id_semester LEFT JOIN nama_dosen d ON a.nama_dosen = d.id_dosen LEFT JOIN semester e ON a.semester = e.id_semester")->result();
		$data['training'] = $this->db->query("SELECT * FROM evaluasi")->result();
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/evaluasi', $data);
		$this->load->view('templates_admin/footer');
	}

	public function cleaning () {
		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

		
		$data['title'] = "Cleaning & Casefolding";
		//$data['training'] = $this->LppmModel->get_data('cleaning')->result();
		$data['training'] = $this->db->query("SELECT a.*, d.ulasan as eval, d.semester, d.nama_dosen, d.mata_kuliah FROM cleaning a LEFT JOIN evaluasi d ON a.id_cleaning=d.id_evaluasi")->result();
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/cleaning', $data);
		$this->load->view('templates_admin/footer');
	}

	public function stopwords () {
		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

		
		$data['title'] = "Stopwords Removal";
		//$data['training'] = $this->LppmModel->get_data('stopword')->result();
		$data['training'] = $this->db->query("SELECT a.*, b.semester, b.nama_dosen, b.mata_kuliah, d.ulasan as clean FROM stopword a LEFT JOIN evaluasi b ON a.id_stopword = b.id_evaluasi LEFT JOIN cleaning d ON a.id_stopword=d.id_cleaning")->result();
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/stopword', $data);
		$this->load->view('templates_admin/footer');
	}

	public function stemmings () {
		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

		
		$data['title'] = "Stemming";
		//$data['training'] = $this->LppmModel->get_data('stemming')->result();
		$data['training'] = $this->db->query("SELECT a.*, b.semester, b.nama_dosen, b.mata_kuliah, d.ulasan as stopw FROM stemming a LEFT JOIN evaluasi b ON a.id_stemming = b.id_evaluasi LEFT JOIN stopword d ON a.id_stemming=d.id_stopword")->result();
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/stemming', $data);
		$this->load->view('templates_admin/footer');
	}

	public function kosongkan_tabel() {
		$table_name = 'evaluasi';
		$this->LppmModel->empty_table($table_name);
		$this->LppmModel->empty_table('evaluasi');
		$this->LppmModel->empty_table('cleaning');
		$this->LppmModel->empty_table('stopword');
		$this->LppmModel->empty_table('stemming');
		$this->LppmModel->empty_table('data_training');
		$this->LppmModel->empty_table('data_testing');
		$this->LppmModel->empty_table('report');
		$this->LppmModel->empty_table('fold');
		$this->LppmModel->empty_table('matrix');
		$this->LppmModel->empty_table('vocab');
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil dikosongkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/evaluasi');
	}

	public function kosongkan_tabel1() {
		$table_name = 'cleaning';
		$this->LppmModel->empty_table($table_name);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil dikosongkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/evaluasi/cleaning ');
	}

	public function kosongkan_tabel2() {
		$table_name = 'stopword';
		$this->LppmModel->empty_table($table_name);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil dikosongkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/evaluasi/stopword ');
	}

	public function kosongkan_tabel3() {
		$table_name = 'stemming';
		$this->LppmModel->empty_table($table_name);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil dikosongkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/evaluasi/stemming ');
	}


	public function upload_data()
	{
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'xls|xlsx|csv';
		$config['max_size']             = 1024;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_upload')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
			redirect('admin/evaluasi');
		} else {
			$data = array('upload_data' => $this->upload->data());

			$inputFileName = $data['upload_data']['full_path'];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
			$worksheet = $spreadsheet->getActiveSheet();
			$highestRow = $worksheet->getHighestRow();

			$data = array();
			for ($row = 3; $row <= $highestRow; ++$row) {
				$semester = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$mata_kuliah = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$nama_dosen = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				$ulasan = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$sentiment = null;
		
				$data[] = array(
					'semester' => $semester,
					'mata_kuliah' => $mata_kuliah,
					'nama_dosen' => $nama_dosen,
					'ulasan' => $ulasan,
					'sentiment' => $sentiment,
				);
			}
		
			$this->db->insert_batch('evaluasi', $data);
		
			$this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil diupload</div>');
			redirect('admin/evaluasi');
		}
	}

	public function preprocessing() {
 	    // Ambil data evaluasi dari database
 	    $this->LppmModel->empty_table('cleaning');
        $data_evaluasi = $this->LppmModel->get_data('evaluasi')->result();
		$result = $this->LppmModel->get_data('cleaning')->result();
        // Lakukan preprocessing pada setiap ulasan
        foreach ($data_evaluasi as $evaluasi) {
            $id = $evaluasi->id_evaluasi;
            $semester = $evaluasi->semester;
			$matkul = $evaluasi->mata_kuliah;
			$dosen = $evaluasi->nama_dosen;
			$ulasan = $evaluasi->ulasan;
			$sentiment = $evaluasi->sentiment;

            // Lakukan preprocessing pada $ulasan
            $ulasan = strtolower($ulasan); // ubah huruf besar menjadi huruf kecil
			$ulasan = preg_replace('/\d/', '', $ulasan);
            $ulasan = preg_replace('/[^a-zA-Z0-9\s]/', '', $ulasan); // hapus karakter selain huruf dan angka
            $ulasan = preg_replace('/\s\s+/', ' ', $ulasan); // hapus spasi berlebih
            $ulasan = trim($ulasan); // hapus spasi di awal dan akhir teks;

			$data = array(
				'id_cleaning' => $id,
				'mata_kuliah' => $matkul,
				'nama_dosen' => $dosen,
				'ulasan' => $ulasan,
				'sentiment' => $sentiment,
			);

			if (!empty($result)) {
				// Update ulasan yang sudah di preprocessing ke database
           		$this->LppmModel->update_cleaning($evaluasi->id_evaluasi, $ulasan);
			} else {
				$this->LppmModel->insert_data($data, 'cleaning');
			}

            
        }

		$this->session->set_flashdata ('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
		<strong>Preprocessing selesai!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
		</div>');
			
		redirect('admin/evaluasi/cleaning');
	}	

	public function stopword() {
	    $this->LppmModel->empty_table('stopword');
		// Ambil data evaluasi dari database
		$data_evaluasi = $this->LppmModel->get_data('cleaning')->result();
		$result = $this->LppmModel->get_data('stopword')->result();
		// Lakukan preprocessing pada setiap ulasan
		foreach ($data_evaluasi as $evaluasi) {
            $id = $evaluasi->id_cleaning;
			$matkul = $evaluasi->mata_kuliah;
			$dosen = $evaluasi->nama_dosen;
			$ulasan = $evaluasi->ulasan;
			$sentiment = $evaluasi->sentiment;

			// Tahap stopwords
			$factory = new StopWordRemoverFactory();
			$stopword = $factory->createStopWordRemover();
			$ulasan = $stopword->remove($ulasan);

			$data = array(
				'id_stopword' => $id,
				'mata_kuliah' => $matkul,
				'nama_dosen' => $dosen,
				'ulasan' => $ulasan,
				'sentiment' => $sentiment,
			);

			if (!empty($result)) {
				// Update ulasan yang sudah di preprocessing ke database
           		$this->LppmModel->update_cleaning($evaluasi->id_cleaning, $ulasan);
			} else {
				$this->LppmModel->insert_data($data, 'stopword');
			}

		}

		$this->session->set_flashdata ('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
		<strong>Preprocessing selesai!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
		</div>');
			
		redirect('admin/evaluasi/stopwords');
	}	

	public function stemming() {
		// Ambil data evaluasi dari database
		$this->LppmModel->empty_table('stemming');
		$data_evaluasi = $this->LppmModel->get_data('stopword')->result();
		$result = $this->LppmModel->get_data('stemming')->result();
		// Lakukan preprocessing pada setiap ulasan
		foreach ($data_evaluasi as $evaluasi) {
            $id = $evaluasi->id_stopword;
			$matkul = $evaluasi->mata_kuliah;
			$dosen = $evaluasi->nama_dosen;
			$ulasan = $evaluasi->ulasan;
			$sentiment = $evaluasi->sentiment;

			// Stemming
			$stemmerFactory = new StemmerFactory();
			$stemmer = $stemmerFactory->createStemmer();
	
			$ulasan   = $stemmer->stem($ulasan);

			$data = array(
				'id_stemming' => $id,
				'mata_kuliah' => $matkul,
				'nama_dosen' => $dosen,
				'ulasan' => $ulasan,
				'sentiment' => $sentiment,
			);

			if (!empty($result)) {
				// Update ulasan yang sudah di preprocessing ke database
           		$this->LppmModel->update_cleaning($evaluasi->id_stopword, $ulasan);
			} else {
				$this->LppmModel->insert_data($data, 'stemming');
			}
		}

		$this->session->set_flashdata ('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
		<strong>Preprocessing selesai!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
		</div>');
			
		redirect('admin/evaluasi/stemmings');
	}	

	public function labeling(){
		//ambil data evaluasi dari database
		$data_evaluasi = $this->LppmModel->get_data('stemming')->result_array();
		
		//load file lexicon
		// $lexicon_file_pos = APPPATH . 'lexicon/positive.tsv';
		// $lexicon_file_neg = APPPATH . 'lexicon/negative.tsv';
		$lexicon_file_new = APPPATH . 'lexicon/new_lexicon.csv';

		// $lexicon_pos = array();
		// $lexicon_neg = array();
		$lexicon_new = array();

		// //load file tsv positif
		// if (($handle = fopen($lexicon_file_pos, "r")) !== FALSE) {
		// 	while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
		// 		$lexicon_pos[$data[0]] = $data[1];
		// 	}
		// 	fclose($handle);
		// }

		// //load file tsv negatif
		// if (($handle = fopen($lexicon_file_neg, "r")) !== FALSE) {
		// 	while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
		// 		$lexicon_neg[$data[0]] = $data[1];
		// 	}
		// 	fclose($handle);
		// }

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

			//lakukan labeling otomatis
			// if($jumlah_kata == -6){
			// 	$label_sentiment = 'Netral'; 
			if($skor_sentiment > -6){
				$label_sentiment = 'Positif';
			}elseif($skor_sentiment < -9){
				$label_sentiment = 'Negatif';
			}else{
				// if($kata_positif > $kata_negatif){
				// 	$label_sentiment = 'Positif';
				// }elseif($kata_positif < $kata_negatif){
				// 	$label_sentiment = 'Negatif';
				// }else{
					$label_sentiment = 'Netral';
				// }
			}

			// //lakukan labeling otomatis
			// if($skor_sentiment > -5){
			// 	$label_sentiment = 'Positif';
			// }elseif($skor_sentiment < -10){
			// 	$label_sentiment = 'Negatif';
			// }else{
			// 	$label_sentiment = 'Netral';
			// }
	
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
			
		redirect('admin/evaluasi');
	}
	

	public function split_data()
	{
	    $this->LppmModel->empty_table('data_training');
	    $this->LppmModel->empty_table('data_testing');
		// Get all evaluation data from database
		$evaluation_data = $this->LppmModel->get_data('stemming')->result_array();
	
		// Split the data into training and testing data with a 80:20 ratio
		$training_data = array();
		$testing_data = array();
		foreach ($evaluation_data as $data) {
			$split_data = array(
				'document' => $data['ulasan'],
				'sentiment' => $data['sentiment']
			);
			if (rand(0, 99) < 80) {
				$training_data[] = $split_data;
			} else {
				$testing_data[] = $split_data;
			}
		}
	
		// Save the training data to the database
		foreach ($training_data as $data) {
			$this->LppmModel->insert_data($data, 'data_training');
		}
	
		// Save the testing data to the database
		foreach ($testing_data as $data) {
			$this->LppmModel->insert_data($data, 'data_testing');
		}
	
		// Display success message
		$this->session->set_flashdata ('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
		<strong>Splitting data selesai!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
		</div>');
			
		redirect('admin/labeling');
	}
	

	public function update_data($id) {
		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

		$where = array ('id_evaluasi' => $id);
		$data['training'] = $this->db->query("SELECT * FROM evaluasi WHERE id_evaluasi= '$id'")->result();
		$data['title'] = "Update Data Sentiment";
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/update_training', $data);
		$this->load->view('templates_admin/footer');
	}

	public function update_data_aksi() {
		$this->_rules();

		if($this->form_validation->run() == FALSE) {
			$this->update_data();

			$this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Data gagal diupdate! Mohon isi data dengan benar</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
			</div>');

			redirect('admin/evaluasi');
		} else {

			$id 	= $this->input->post('id_evaluasi');
			$sentiment 	= $this->input->post('sentiment');
			$data = array(
				'sentiment' => $sentiment,
			);

			$where = array (
				'id_evaluasi' => $id
			);

			$this->LppmModel->update_data('evaluasi', $data, $where);
			$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil diupdate!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
			</div>');

			redirect('admin/evaluasi');
		}
	}


	public function _rules() {
		$this->form_validation->set_rules('sentiment', 'sentiment ', 'required');
	}

	public function delete_data ($id) {
		$where = array ('id_evaluasi' => $id);
		$this->LppmModel->delete_data($where, 'evaluasi');
		$this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<strong>Data berhasil dihapus!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
		</div>');
			
		redirect('admin/evaluasi');
	}

}

?>



