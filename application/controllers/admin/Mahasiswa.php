  <?php 
require 'vendor/autoload.php';
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Dictionary\ArrayDictionary;
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\Tokenizer\TokenizerFactory;
class mahasiswa extends CI_Controller
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

	$data['title'] = "Mahasiswa";
	$data['admin'] = $this->db->query("SELECT a.*, b.id_semester, c.* FROM admin a LEFT JOIN mahasiswa b ON a.id_admin = b.id_admin left JOIN semester c ON b.id_semester = c.id_semester WHERE a.hak_akses='3'")->result();
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/mahasiswa', $data);
	$this->load->view('templates_admin/footer');
}

public function upload()
{
	$config['upload_path']          = './uploads/';
	$config['allowed_types']        = 'xls|xlsx|csv';
	$config['max_size']             = 1024;

	$this->load->library('upload', $config);

	if (!$this->upload->do_upload('file_upload')) {
		$this->session->set_flashdata('pesan', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
		redirect('admin/mahasiswa');
	} else {
		$data = array('upload_data' => $this->upload->data());

		$inputFileName = $data['upload_data']['full_path'];
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
		$worksheet = $spreadsheet->getActiveSheet();
		$highestRow = $worksheet->getHighestRow();

		for ($row = 2; $row <= $highestRow; $row++) {
			$nim = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
			$angkatan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
			$nama_admin = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
			$pembimbing = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
			$hak_akses = '3';
			$id_semester = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
	
			// Panggil model dan simpan data ke database
			$this->LppmModel->insertAdmin($nim, $angkatan, $nama_admin, $pembimbing, $hak_akses);
	
			// Ambil ID admin terbaru untuk digunakan pada tabel mahasiswa
			$id_admin = $this->LppmModel->getLastAdminId();
	
			// Panggil model dan simpan data ke tabel mahasiswa
			$this->LppmModel->insertMahasiswa($id_admin, $id_semester);
		}
	
		$this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil diupload</div>');
		redirect('admin/mahasiswa');
	}
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

	$data['title'] = "Tambah mahasiswa";
	$data['dosen']= $this->LppmModel->get_data('admin')->result();
	$data['semester'] = $this->db->get('semester')->result();
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/tambah_mahasiswa', $data);
	$this->load->view('templates_admin/footer');
}

public function kosongkan_tabel() {
		$table_name = 'mahasiswa';
		$this->LppmModel->empty_table($table_name);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil dikosongkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/mahasiswa');
	}

public function tambah_data_aksi()
{

	$this->_rules();

	if($this->form_validation->run() == FALSE) {
		$this->tambah_data();
	} else {
		
		$nama_admin		= $this->input->post('nama_admin');
		$username		= $this->input->post('username');
		$password		= md5($this->input->post ('password'));
		$hak_akses		= "3";
		

		$data = array(
			
			'nama_admin' => $nama_admin,
			'username' => $username,
			'password' => $password,
			'hak_akses' => $hak_akses,
			
		);

		$this->LppmModel->insert_data($data, 'admin');
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
 		<strong>Data berhasil ditambahkan!</strong>
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button></div>');

		redirect('admin/mahasiswa');
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
			redirect('admin/mahasiswa');
		} else {
			$data = array('upload_data' => $this->upload->data());

			$inputFileName = $data['upload_data']['full_path'];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
			$worksheet = $spreadsheet->getActiveSheet();
			$highestRow = $worksheet->getHighestRow();

			$data = array();
			for ($row = 2; $row <= $highestRow; ++$row) {
				$nama_admin = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$username = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$password= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$hak_akses= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				
		
				$data[] = array(
					'nama_admin' => $nama_admin,
					'username' => $username,
					'password' => $password,
					'hak_akses' => $hak_akses,
					
				);
			}
		
			$this->db->insert_batch('admin', $data);
		
			$this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil diupload</div>');
			redirect('admin/mahasiswa');
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

	$where = array ('id_admin' => $id);
	$data['admin'] = $this->db->query("SELECT * FROM admin WHERE id_admin= '$id'")->result();
	$data['semester'] = $this->db->get('semester')->result();
	$data['title'] = "Update Mahasiswa";
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/update_mahasiswa', $data);
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

		redirect('admin/Mahasiswa');
	} else {


		$id 	= $this->input->post('id_admin');
		$nama_admin		= $this->input->post('nama_admin');
		$username		= $this->input->post('username');
		$password		= md5($this->input->post ('password'));
		$hak_akses		= "3";
		$id_semester = $this->input->post('id_semester');
		

		$data = array(
			
			'nama_admin' => $nama_admin,
			'username' => $username,
			'password' => $password,
			'hak_akses' => $hak_akses,



		);

		$semester = array(
            'id_admin' => $id,
            'id_semester' => $id_semester
        );

		$where = array (

			'id_admin' => $id
		);

		$this->db->insert('mahasiswa', $semester);
		$this->LppmModel->update_data('admin', $data, $where);
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Data berhasil diupdate!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/mahasiswa');
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

		redirect('admin/Mahasiswa');
}






}
?>



