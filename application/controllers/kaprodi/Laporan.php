<?php 

class Laporan extends CI_Controller
{ 
	
	

	public function index ()

{
	$data['title'] = "Data Testing";
	$data['barang'] = $this->LppmModel->get_data('barang')->result();
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/laporan', $data);
	$this->load->view('templates_admin/footer');
}








}
?>
