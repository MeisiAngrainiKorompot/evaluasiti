<?php 

class profil extends CI_Controller
{


	public function index ()

{
	$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

	$data['title'] = "Profil";
	$data['admin'] = $this->LppmModel->get_data('admin')->result();
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/profiladmin', $data);
	$this->load->view('templates_admin/footer');
}


	public function tambah_admin()
	{
		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');


	$data['title'] = "Tambah admin";
	$data['admin'] = $this->LppmModel->get_data('admin')->result();
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/tambah_admin', $data);
	$this->load->view('templates_admin/footer');
	}

	public function tambah_data_aksi()
{
	$this->_rules();

	if($this->form_validation->run() == FALSE){
		$this->tambah_admin();

	}else{
		$nama_admin					= $this->input->post('nama_admin');
		$username					= $this->input->post('username');
        $password					= md5($this->input->post ('password'));
        $hak_akses					= $this->input->post ('hak_akses');
       
		$data = array(
			
			'nama_admin' 	=> $nama_admin,
			'username' 		=> $username,
			'password' 		=> $password,
			'hak_akses'		=> $hak_akses,
			
			
			
		);

		$this->LppmModel->insert_data($data, 'admin');
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
 		<strong>Data berhasil ditambahkan!</strong>
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button></div>');

		redirect('admin/profil');
}
}

	public function update_data($id)
{
	$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');


	$where = array('id_admin' => $id);
	$data['admin']	= $this->db->query("SELECT * FROM admin WHERE id_admin= '$id'")->result();
	$data ['title']= "Update Data Admin";
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/update_data', $data);
	$this->load->view('templates_admin/footer');

}

	public function update_data_aksi()
{
	$this->_rules();

	if($this->form_validation->run() == FALSE){
		$this->update_data();

	}else{
		$id 						= $this->input->post('id_admin');
		$nama_admin					= $this->input->post('nama_admin');
		$username					= $this->input->post('username');
        $password					= md5($this->input->post ('password'));
        
       
		$data = array(
			
			'nama_admin' 	=> $nama_admin,
			'username' 		=> $username,
			'password' 		=> $password,
			
			
			
		);
		$where = array(
			'id_admin' => $id

		);

		$this->LppmModel->update_data('admin', $data, $where);
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
 		<strong>Data berhasil diupdate!</strong>
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button></div>');

		redirect('admin/profil');
	}
}

public function _rules()
{

	$this->form_validation->set_rules('nama_admin', 'nama admin', 'required');
	$this->form_validation->set_rules('username', 'username', 'required');
	$this->form_validation->set_rules('password', 'password', 'required');
	
	
}
	public function delete_data ($id)
{

	$where = array ('id_admin' => $id);
	$this->LppmModel->delete_data($where, 'admin');
	$this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Data berhasil dihapus!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/profil');
	}
}

?>