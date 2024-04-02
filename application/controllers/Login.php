<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	

	public function index()
	{
		$this->_rules();
	
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Halaman Login";
			$this->load->view('templates_admin/header', $data);
			$this->load->view('formlogin');
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
	
			$cek = $this->LppmModel->cek_login($username, $password);
	
			if ($cek == FALSE) {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Username atau password salah!</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
						<span aria-hidden="true">&times; </span> </button></div>');
				redirect('Login');
			} else {
				$this->session->set_userdata('hak_akses', $cek->hak_akses);
				$this->session->set_userdata('id_admin', $cek->id_admin);
				$this->session->set_userdata('nama_admin', $cek->nama_admin);
				// Mengambil id_semester berdasarkan id_admin yang login (mahasiswa)
				if ($cek->hak_akses == 3) {
					$mahasiswa = $this->LppmModel->get_data_where('mahasiswa', ['id_admin' => $cek->id_admin])->row();
					$this->session->set_userdata('id_semester', $mahasiswa->id_semester);
				}
	
				switch ($cek->hak_akses) {
					case 1:
						redirect('admin/Dashboard');
						break;
					case 2:
						redirect('kaprodi/Dashboard');
						break;
					case 3:
						$val = $this->db->query("SELECT value FROM setting WHERE id_setting='1'")->row();
						if($val->value == 1){
							redirect('mahasiswa/Dashboard');
							break;
						}else
							$this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Maaf sistem belum dibuka kembali  </strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button></div>');
							redirect('Login');
							break;
					default:
						break;
				}
			}
		}
	}
	

	public function _rules()
	{
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');

	}
	public function logout()
	{
		$this->session->session_destroy();
		redirect('Login');
	}
}
