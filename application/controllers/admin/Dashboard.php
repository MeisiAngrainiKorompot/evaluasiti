<?php 

class Dashboard extends CI_Controller {

 	
	public function index() {
		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

		$data['title'] = "Dashboard Admin";
		$data['num_training_data'] = $this->LppmModel->count_data('data_training');
		$data['num_testing_data'] = $this->LppmModel->count_data('data_testing');
        $data['dosenData'] = $this->LppmModel->getDosenData(); // Mengambil data jumlah dosen
        $data['dosenLabels'] = $this->LppmModel->getDosenLabels(); // Mengambil label nama dosen
        $data['matkulData'] = $this->LppmModel->getMatkulData(); // Mengambil data jumlah mata kuliah
        $data['matkulLabels'] = $this->LppmModel->getMatkulLabels(); // Mengambil label mata kuliah
		$data['dosen'] = $this->LppmModel->count_data('nama_dosen');
		$data['matkul'] = $this->LppmModel->count_data('mata_kuliah');
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dashboard', $data);
		$this->load->view('templates_admin/footer');
	}
}


?>