  <?php 

class Data_Training extends CI_Controller
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

		$data['title'] = "Data Training";
		$data['training'] = $this->LppmModel->get_data('data_training')->result();
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/training', $data);
		$this->load->view('templates_admin/footer');
	}

	public function empty_data_training() {
		$table_name = 'data_training';
		$this->LppmModel->empty_table($table_name);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil dikosongkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/Data_Training');
	}

public function tambah()
{	$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
	$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
	$data['stop'] = $this->db->query('SELECT * FROM  stopword');
	$data['stem'] = $this->db->query('SELECT * FROM  stemming');
	$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
	$data['train'] = $this->db->query('SELECT * FROM  data_training');
	$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

	$data['title'] = "Pilih File";
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/tambah_file', $data);
	$this->load->view('templates_admin/footer');
}


public function upload()
{
	include APPPATH.'third_party/PHPExcel/PHPExcel.php';

	$config['upload_path']= realpath('excel');
	$config['allowed_types']= 'xlsx|xls|csv';
	$config['mx_size']= '10000';
	$config['encrypt_name']=true;

	$this->load->library('upload', $config);

	if(!$this->upload->do_upload()){
		$this->session->set_flashdata('pesan', '<div class="alert alert-danger"><b> Gagal Import</b>'.$this->upload->display_errors().'</div>'); echo (error_log); redirect('admin/data_training');
	} else {
		$data_upload =$this->upload->data();

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/'.$data_upload['file_name']);
		$sheet= $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		$data = array();

		$numrow = 1;
		foreach($sheet as $row){
			if($numrow >1) {
				array_push($data, array(
					'ulasan'		=> $row ['A'],
					'mata_kuliah'	=> $row['B'],
					'nama_dosen'			=> $row ['C'],
					'sentiment'		=>$row ['D'],				
				));
			} $numrow++;
		}
		$this->db->insert_batch('evaluasi', $data);

		unlink(realpath('excel/'.$data_upload['file_name']));

		$this->session->set_flashdata('pesan', '<div class="alert alert-success"><b> Berhasil Import</b></div>'); redirect('admin/data_training');

}
}


public function _rules()
{

	$this->form_validation->set_rules('sentiment', 'sentiment ', 'required');
	

	
}

public function delete_data ($id)

{

	$where = array ('id_evaluasi' => $id);
	$this->LppmModel->delete_data($where, 'data_training');
	$this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Data berhasil dihapus!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/data_training');
}






}
?>



