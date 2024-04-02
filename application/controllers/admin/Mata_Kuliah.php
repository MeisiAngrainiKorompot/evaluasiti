  <?php 
require 'vendor/autoload.php';
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Dictionary\ArrayDictionary;
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\Tokenizer\TokenizerFactory;
class Mata_Kuliah extends CI_Controller
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

    	$data['title'] = "Mata Kuliah";
    	//$data['kuliah'] = $this->LppmModel->get_data('mata_kuliah')->result();
    	$data['kuliah'] = $this->db->query("SELECT a.*, b.*, c.* FROM mata_kuliah a LEFT JOIN semester b ON a.id_semester = b.id_semester LEFT JOIN nama_dosen c ON a.id_dosen = c.id_dosen")->result();
    	$this->load->view('templates_admin/header', $data);
    	$this->load->view('templates_admin/sidebar');
    	$this->load->view('admin/kuliah', $data);
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

    	$data['title'] = "Tambah Mata Kuliah";
    	$data['semester']= $this->LppmModel->get_data('semester')->result();
    	$data['dosen']= $this->LppmModel->get_data('nama_dosen')->result();
    	$this->load->view('templates_admin/header', $data);
    	$this->load->view('templates_admin/sidebar');
    	$this->load->view('admin/tambah_kuliah', $data);
    	$this->load->view('templates_admin/footer');
    }
    
    public function kosongkan_tabel() {
		$table_name = 'mata_kuliah';
		$this->LppmModel->empty_table($table_name);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil dikosongkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/mata_kuliah');
	}
    public function tambah_data_aksi()
    {

	$this->_rules();

	if($this->form_validation->run() == FALSE) {
		$this->tambah_data();
	} else {
		
		$nama_mata_kuliah	= $this->input->post('nama_mata_kuliah');
		$semester		= $this->input->post('semester');
		$dosen		= $this->input->post('dosen');

		$data = array(
			
			'nama_mata_kuliah' => $nama_mata_kuliah,
			'id_semester' => $semester,
			'dosen' => $dosen,
			
		);

		$this->LppmModel->insert_data($data, 'mata_kuliah');
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
 		<strong>Data berhasil ditambahkan!</strong>
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button></div>');

		redirect('admin/Mata_Kuliah');
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

	$where = array ('id_mata_kuliah' => $id);
	$data['kuliah'] = $this->db->query("SELECT * FROM mata_kuliah WHERE id_mata_kuliah= '$id'")->result();
	$data['title'] = "Update Mata Kuliah";
	$this->load->view('templates_admin/header', $data);
	$this->load->view('templates_admin/sidebar');
	$this->load->view('admin/update_kuliah', $data);
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

		redirect('admin/Mata_Kuliah');
	} else {


		$id 	= $this->input->post('id_mata_kuliah');
		$nama_mata_kuliah 	= $this->input->post('nama_mata_kuliah');
		$semester 	= $this->input->post('semester');



		$data = array(
			
			'nama_mata_kuliah' => $nama_mata_kuliah,
			'semester' => $semester,


		);

		$where = array (

			'id_mata_kuliah' => $id
		);

		$this->LppmModel->update_data('mata_kuliah', $data, $where);
		$this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Data berhasil diupdate!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/mata_kuliah');
	}
}


public function _rules()
{

	$this->form_validation->set_rules('nama_mata_kuliah', 'nama_mata_kuliah', 'required');
	

	
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
	$this->load->view('admin/tambah_filemk', $data);
	$this->load->view('templates_admin/footer');
}


public function upload_data()
	{
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'xls|xlsx|csv';
		$config['max_size']             = 1024;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_upload')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
			redirect('admin/mata_kuliah');
		} else {
			$data = array('upload_data' => $this->upload->data());

			$inputFileName = $data['upload_data']['full_path'];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
			$worksheet = $spreadsheet->getActiveSheet();
			$highestRow = $worksheet->getHighestRow();

			$data = array();
			for ($row = 6; $row <= $highestRow; ++$row) {
				$hari = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$semester = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$kode_mk = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$nama_mata_kuliah = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				$sks = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$durasi = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
				$jam_masuk = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
				$jam_keluar = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
				$gedung = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
				$ruang = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
				$dosen = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
		
				$data[] = array(
					'hari' => $hari,
					'semester' => $semester,
					'kode_mk' => $kode_mk,
					'nama_mata_kuliah' => $nama_mata_kuliah,
					'sks' => $sks,
					'durasi' => $durasi,
					'jam_masuk' => $jam_masuk,
					'jam_selesai' => $jam_keluar,
					'gedung' => $gedung,
					'ruang' => $ruang,
					'dosen' => $dosen,
					'id_semester' => $semester,
					'id_dosen' => '2',
				);
			}
		
			$this->db->insert_batch('mata_kuliah', $data); 
		
			$this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil diupload</div>');
			redirect('admin/Mata_Kuliah');
		}
	}



public function delete_data ($id)

{

	$where = array ('id_mata_kuliah' => $id);
	$this->LppmModel->delete_data($where, 'mata_kuliah');
	$this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Data berhasil dihapus!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

		redirect('admin/Mata_Kuliah');
}






}
?>



