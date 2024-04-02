<?php 

class Dashboard extends CI_Controller {

 	
public function index ()
{
	$data ['title'] = "Dashboard Kaprodi";
	$data['num_training_data'] = $this->LppmModel->count_data('data_training');
	$data['num_testing_data'] = $this->LppmModel->count_data('data_testing');
	$data['dosenData'] = $this->LppmModel->getDosenData(); // Mengambil data jumlah dosen
	$data['dosenLabels'] = $this->LppmModel->getDosenLabels(); // Mengambil label nama dosen
	$data['matkulData'] = $this->LppmModel->getMatkulData(); // Mengambil data jumlah mata kuliah
	$data['matkulLabels'] = $this->LppmModel->getMatkulLabels(); // Mengambil label mata kuliah
	$data['dosen'] = $this->LppmModel->count_data('nama_dosen');
	$data['matkul'] = $this->LppmModel->count_data('mata_kuliah');
	$this->load->view('templates_kaprodi/header', $data);
	$this->load->view('templates_kaprodi/sidebar');
	$this->load->view('kaprodi/dashboard', $data);
	$this->load->view('templates_kaprodi/footer');
}
}


?>