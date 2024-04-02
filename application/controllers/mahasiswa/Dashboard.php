<?php 

class Dashboard extends CI_Controller {

 	
public function index ()
{
	$data ['title'] = "Dashboard Mahasiswa";
	$data['num_training_data'] = $this->LppmModel->count_data('data_training');
	$data['num_testing_data'] = $this->LppmModel->count_data('data_testing');
	$data['dosen'] = $this->LppmModel->count_data('nama_dosen');
	$data['matkul'] = $this->LppmModel->count_data('mata_kuliah');
	$this->load->view('templates_mahasiswa/header', $data);
	$this->load->view('templates_mahasiswa/sidebar');
	$this->load->view('mahasiswa/dashboard', $data);
	$this->load->view('templates_mahasiswa/footer');
}
}


?>