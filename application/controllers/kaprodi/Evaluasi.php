   <?php 

class Evaluasi extends CI_Controller
{ 

    public function __construct() {
        parent::__construct();
        $this->load->model('LppmModel');
    }
    

    public function index () 
    {
        $this->load->database();
        
        // Mengambil data laporan dari tabel 'report'
        $report = $this->db->get('report')->row_array();

        if (!empty($report)) {
            $data = [
                'accuracy' => $report['accuracy'],
                'f1_score' => $report['f1_score'],
                'precision' => $report['precision'],
                'recall' => $report['recall'],
            ];
        } else {
            $data = [
                'accuracy' => 0,
                'f1_score' => 0,
                'precision' => 0,
                'recall' => 0,
            ];
        }

        // Mengambil data matrix dari tabel 'matrix'
        $matrix = $this->db->get('matrix')->result();

        // Menyimpan data matrix ke dalam array
        $data['confusion_matrix'] = [];
        foreach ($matrix as $item) {
            $matrix_data = json_decode($item->matrix, true);
            $data['confusion_matrix'][] = $matrix_data;
        }

        // Mengambil data fold dari tabel 'fold'
        $fold = $this->db->get('fold')->result();

        // Menyimpan data fold ke dalam array
        $data['fold'] = [];
        foreach ($fold as $item) {
            $data['fold'][] = [
                'id_fold' => $item->id_fold,
                'fold' => $item->fold,
                'accuracy' => $item->accuracy,
            ];
        }

        // Mengambil data evaluasi dari tabel 'evaluasi'
        $evaluasi = $this->LppmModel->get_data('stemming')->result();
        
        // Menghitung jumlah data evaluasi dengan masing-masing label
        $jumlah_negatif = 0;
        $jumlah_netral = 0;
        $jumlah_positif = 0;
        foreach ($evaluasi as $item) {
            if ($item->sentiment == 'Negatif') {
                $jumlah_negatif++;
            } elseif ($item->sentiment == 'Netral') {
                $jumlah_netral++;
            } elseif ($item->sentiment == 'Positif') {
                $jumlah_positif++;
            }
        }
        
        // Menyimpan jumlah data evaluasi dengan masing-masing label ke dalam array
        $data['jumlah_evaluasi'] = [
            'Negatif' => $jumlah_negatif,
            'Netral' => $jumlah_netral,
            'Positif' => $jumlah_positif
        ];

        $data['test'] = true;
        $data['test_result'] = null;
        $data['title'] = "Hasil Evaluasi";
        $data['evaluasi']= $this->LppmModel->get_data('evaluasi')->result();
        $this->load->view('templates_kaprodi/header', $data);
        $this->load->view('templates_kaprodi/sidebar');
        $this->load->view('kaprodi/evaluasi', $data);
        $this->load->view('templates_kaprodi/footer');
    }

public function tambah_data()

{
    $data['title'] = "Tambah Evaluasi";
    $data['nama_dosen']= $this->LppmModel->get_data('nama_dosen')->result();
    $data['mata_kuliah']= $this->LppmModel->get_data('mata_kuliah')->result();
    $this->load->view('templates_mahasiswa/header', $data);
    $this->load->view('templates_mahasiswa/sidebar');
    $this->load->view('mahasiswa/tambah_evaluasi', $data);
    $this->load->view('templates_mahasiswa/footer');
}

public function tambah_data_aksi()
{

    $this->_rules();

    if($this->form_validation->run() == FALSE) {
        $this->tambah_data();
    } else {
        
        $mata_kuliah        = $this->input->post('mata_kuliah');
        $nama_dosen          = $this->input->post('nama_dosen');
        $ulasan         = $this->input->post('ulasan');
        
        
        

        $data = array(
            
            'mata_kuliah' => $mata_kuliah,
            'nama_dosen' => $nama_dosen,
            'ulasan'     => $ulasan,
            
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



