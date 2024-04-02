<?php 

class Evaluasi extends CI_Controller
{ 
    public function index ()

{
    $data['title'] = "Evaluasi";
    //$data['evaluasi']= $this->LppmModel->get_data('evaluasi')->result();
    $id = $this->session->userdata('id_admin');
	$data['evaluasi'] = $this->db->query("SELECT * FROM evaluasi where id_mahasiswa='$id'")->result();
    $this->load->view('templates_mahasiswa/header', $data);
    $this->load->view('templates_mahasiswa/sidebar');
    $this->load->view('mahasiswa/evaluasi', $data);
    $this->load->view('templates_mahasiswa/footer');
}

public function tambah_data()
{
    $data['title'] = "Tambah Evaluasi";
    $semester_mahasiswa = $this->session->userdata('id_semester');
    
    $data['nama_dosen'] = $this->LppmModel->get_data('nama_dosen')->result();

    // Mengambil mata kuliah yang sesuai dengan semester mahasiswa yang login
    $data['mata_kuliah'] = $this->db->query("SELECT * FROM mata_kuliah WHERE id_semester = '$semester_mahasiswa'")->result();
    $data['kuliah'] = $this->db->query("SELECT a.*, b.*, c.* FROM mata_kuliah a LEFT JOIN semester b ON a.id_semester = b.id_semester LEFT JOIN nama_dosen c ON a.id_dosen = c.id_dosen")->result();

    $this->load->view('templates_mahasiswa/header', $data);
    $this->load->view('templates_mahasiswa/sidebar');
    $this->load->view('mahasiswa/tambah_evaluasi', $data);
    $this->load->view('templates_mahasiswa/footer');
}

public function get_mata_kuliah_by_dosen()
{
    $dosenId = $this->input->post('dosen_id');

    $mataKuliah = $this->db->query("SELECT * FROM mata_kuliah WHERE id_dosen = '$dosenId'")->result();

    echo json_encode($mataKuliah);
}


public function tambah_data_aksi()
{

    $this->_rules();
    $id = $this->session->userdata('id_admin');
    if($this->form_validation->run() == FALSE) {
        $this->tambah_data();
    } else {
            $semester_mahasiswa = $this->session->userdata('id_semester'); // Mengambil id_semester mahasiswa yang login
        
        $id_mata_kuliah = $this->input->post('mata_kuliah');
        $mk = $this->db->query("SELECT * FROM mata_kuliah WHERE id_mata_kuliah=?", array($id_mata_kuliah))->row();
        $mata_kuliah = $mk->nama_mata_kuliah;
        $id_semester = $mk->id_semester;
        $id_dosen = $this->input->post('nama_dosen');
        $dosen = $this->db->query("SELECT * FROM nama_dosen WHERE id_dosen=?", array($id_dosen))->row();
        $nama_dosen = $dosen->nama;
        $sem = $this->db->query("SELECT * FROM semester where id_semester=?", array($id_semester))->row();
        $semester = $sem->semester;
        $ulasan = $this->input->post('ulasan');
        
        $data = array(
            'semester' => $semester,
            'id_mahasiswa' => $id,
            'mata_kuliah' => $mata_kuliah,
            'nama_dosen' => $nama_dosen,
            'ulasan' => $ulasan,
        );

        $this->LppmModel->insert_data($data, 'evaluasi');
        $this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Tanggapan Anda berhasil disimpan!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button></div>');

        redirect('mahasiswa/Evaluasi');
    }
}


public function update_data($id)

{
    $where = array ('id_barang' => $id);
    $data['barang'] = $this->db->query("SELECT * FROM barang WHERE id_barang= '$id'")->result();
    $data['title'] = "Update Data Barang";
    $data['ruangan']= $this->LppmModel->get_data('barang')->result();
    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/update_barang', $data);
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

        redirect('admin/Inventaris');
    } else {


        $nama_barang    = $this->input->post('nama_barang');
        $merk_tipe      = $this->input->post('merk_tipe');
        $kodefikasi     = $this->input->post('kodefikasi');
        $tahun          = $this->input->post('tahun');
        $ruangan        = $this->input->post('ruangan');
        $jumlah         = $this->input->post('jumlah');
        $keterangan     = $this->input->post('keterangan');

        $data = array(
            
            'nama_barang' => $nama_barang,
            'merk_tipe' => $merk_tipe,
            'kodefikasi' => $kodefikasi,
            'tahun' => $tahun,
            'ruangan' => $ruangan,
            'jumlah' => $jumlah,
            'keterangan' => $keterangan,

        );

        $where = array (

            'id_barang' => $id
        );

        $this->LppmModel->update_data('barang', $data, $where);
        $this->session->set_flashdata ('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Data berhasil diupdate!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

        redirect('admin/Inventaris');
    }
}


public function _rules()
{

    $this->form_validation->set_rules('mata_kuliah', 'mata kuliah', 'required');
    $this->form_validation->set_rules('nama_dosen', 'nama dosen', 'required');
    $this->form_validation->set_rules('ulasan', 'ulasan', 'required');

    
}

public function delete_data ($id)

{

    $where = array ('id_barang' => $id);
    $this->LppmModel->delete_data($where, 'barang');
    $this->session->set_flashdata ('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Data berhasil dihapus!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times; </span> </button>
</div>');

        redirect('admin/Inventaris');
}






}
?>



