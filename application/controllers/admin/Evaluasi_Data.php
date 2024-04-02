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
		$data['training'] = $this->LppmModel->get_data('evaluasi')->result();
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/evaluasi', $data);
		$this->load->view('templates_admin/footer');
	}

		public function kosongkan_tabel() {
		$table_name = 'evaluasi';
		$this->LppmModel->empty_table($table_name);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil dikosongkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/evaluasi');
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
			for ($row = 2; $row <= $highestRow; ++$row) {
				$mata_kuliah = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$nama_dosen = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$ulasan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$sentiment = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
		
				$data[] = array(
					'mata_kuliah' => $mata_kuliah,
					'nama_dosen' => $nama_dosen,
					'ulasan' => $ulasan,
					'sentiment' => $sentiment,
				);
			}
		
			$this->db->insert_batch('evaluasi_data', $data);
		
			$this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil diupload</div>');
			redirect('admin/evaluasi_data');
		}
	}
	