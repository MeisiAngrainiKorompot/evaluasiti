  <?php 

require 'vendor/autoload.php';

class dosen extends CI_Controller
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

	$data['title'] = "Nama Nama Dosen";
	$data['dosen'] = $this->LppmModel->get_data('nama_dosen')->result();
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/dosen', $data);
	$this->load->view('templates_admin/footer');
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

	$data['title'] = "Tambah Dosen";
	$data['dosen']= $this->LppmModel->get_data('nama_dosen')->result();
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/tambah_dosen', $data);
	$this->load->view('templates_admin/footer');
}

public function tambah_data_aksi()
{

	$this->_rules();

	if($this->form_validation->run() == FALSE) {
		$this->tambah_data();
	} else {
		
		$nama		= $this->input->post('nama');
		

		$data = array(
			
			'nama' => $nama,
			
		);

		$this->LppmModel->insert_data($data, 'nama_dosen');
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
 		<strong>Data berhasil ditambahkan!</strong>
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button></div>');

		redirect('admin/Dosen');
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

	$where = array ('id_dosen' => $id);
	$data['dosen'] = $this->db->query("SELECT * FROM nama_dosen WHERE id_dosen= '$id'")->result();
	$data['title'] = "Update Data Dosen";
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/update_dosen', $data);
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

		redirect('admin/Dosen');
	} else {


		$id 	= $this->input->post('id_dosen');
		$nama 	= $this->input->post('nama');


		$data = array(
			
			'nama' => $nama,


		);

		$where = array (

			'id_dosen' => $id
		);

		$this->LppmModel->update_data('nama_dosen', $data, $where);
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Data berhasil diupdate!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/Dosen');
	}
}

public function upload_data()
	{
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'xls|xlsx|csv';
		$config['max_size']             = 1024;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_upload')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
			redirect('admin/dosen');
		} else {
			$data = array('upload_data' => $this->upload->data());

			$inputFileName = $data['upload_data']['full_path'];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
			$worksheet = $spreadsheet->getActiveSheet();
			$highestRow = $worksheet->getHighestRow();

			$data = array();
			for ($row = 2; $row <= $highestRow; ++$row) {
				$mata_kuliah = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				
				$data[] = array(
					'nama' => $mata_kuliah,
				);
			}
		
			$this->db->insert_batch('nama_dosen', $data);
		
			$this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil diupload</div>');
			redirect('admin/dosen');
		}
	}


public function _rules()
{

	$this->form_validation->set_rules('nama', 'nama dosen', 'required');
	

	
}

public function tambah()
{
	$data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');
	
	$data['title'] = "Pilih File";
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/tambah_filedosen', $data);
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
		$this->session->set_flashdata('pesan', '<div class="alert alert-danger"><b> Gagal Import</b>'.$this->upload->display_errors().'</div>'); echo (error_log); redirect('admin/nama_dosen');
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
					'nama'	=> $row ['A'],
					
								
				));
			} $numrow++;
		}
		$this->db->insert_batch('nama_dosen', $data);

		unlink(realpath('excel/'.$data_upload['file_name']));

		$this->session->set_flashdata('pesan', '<div class="alert alert-success"><b> Berhasil Import</b></div>'); redirect('admin/dosen');

}}
public function delete_data ($id)

{

	$where = array ('id_dosen' => $id);
	$this->LppmModel->delete_data($where, 'nama_dosen');
	$this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Data berhasil dihapus!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/Dosen');
}






}
?>



