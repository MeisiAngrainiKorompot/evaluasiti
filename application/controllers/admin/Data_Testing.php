  <?php 

class Data_Testing extends CI_Controller
{ 
	
	public function __construct() {
        parent::__construct();
        $this->load->model('LppmModel');
    }

	public function index ()

	{
		$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

		$data['title'] = "Data Testing";
		$data['testing'] = $this->LppmModel->get_data('data_testing')->result();
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/testing', $data);
		$this->load->view('templates_admin/footer');
	}

	public function empty_data_testing() {
		$table_name = 'data_testing';
		$this->LppmModel->empty_table($table_name);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil dikosongkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/data_testing');
	}
	




public function tambah_data()

{
	$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

	$data['title'] = "Tambah Data";
	$data['testing']= $this->LppmModel->get_data('data_testing')->result();
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/tambah_data_testing', $data);
	$this->load->view('templates_admin/footer');
}

public function tambah_data_aksi()
{

	$this->_rules();

	if($this->form_validation->run() == FALSE) {
		$this->tambah_data();
	} else {
		
		$document		= $this->input->post('document');
		$aspek		= $this->input->post('aspek');
		$sentiment		= $this->input->post('sentiment');
		

		$data = array(
			
			'document' => $document,
			'aspek' => $aspek,
			'sentiment' => $sentiment,
			
		);

		$this->LppmModel->insert_data($data, 'data_testing');
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
 		<strong>Data berhasil ditambahkan!</strong>
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button></div>');

		redirect('admin/data_training');
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

	$where = array ('id_data_testing' => $id);
	$data['testing'] = $this->db->query("SELECT * FROM data_testing WHERE id_data_testing= '$id'")->result();
	$data['title'] = "Update Data Testing";
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/update_testing', $data);
	$this->load->view('templates_admin/footer');

}

public function update_data_aksi()
{

	$this->_rules();

	if($this->form_validation->run() == FALSE) {
		$this->update_data();

		$this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Data gagal diupdate! Mohon isi data dengan benar</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/Data_Testing');
	} else {


		$id 	= $this->input->post('id_data_testing');
		$document 	= $this->input->post('document');
		$aspek 	= $this->input->post('aspek');
		$sentiment 	= $this->input->post('sentiment');


		$data = array(
			
			'document' => $document,
			'aspek' => $aspek,
			'sentiment' => $sentiment,
			





		);

		$where = array (

			'id_data_testing' => $id
	
		);

		$this->LppmModel->update_data('data_testing', $data, $where);
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Data berhasil diupdate!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/data_testing');
	}
}


public function _rules()
{

	$this->form_validation->set_rules('document', 'document', 'required');
	$this->form_validation->set_rules('aspek', 'aspek ', 'required');
	$this->form_validation->set_rules('sentiment', 'sentiment ', 'required');
	

	
}

public function delete_data ($id)

{

	$where = array ('id_data_testing' => $id);
	$this->LppmModel->delete_data($where, 'data_testing');
	$this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Data berhasil dihapus!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/data_testing');
}






}
?>



