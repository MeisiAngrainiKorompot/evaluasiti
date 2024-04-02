<?php

class Semestermahasiswa extends CI_Controller
{
    public function index()
    {
        $data['eval'] = $this->db->query('SELECT * FROM  evaluasi');
		$data['clean'] = $this->db->query('SELECT * FROM  cleaning');
		$data['stop'] = $this->db->query('SELECT * FROM  stopword');
		$data['stem'] = $this->db->query('SELECT * FROM  stemming');
		$data['label'] = $this->db->query('SELECT sentiment FROM  stemming');
		$data['train'] = $this->db->query('SELECT * FROM  data_training');
		$data['tfidf'] = $this->db->query('SELECT tfidf FROM  data_training');

        $data['title'] = "Semester Mahasiswa";
        $data['mahasiswa'] = $this->db->query("SELECT m.*, s.semester, a.nama_admin FROM mahasiswa m INNER JOIN semester s ON m.id_semester = s.id_semester INNER JOIN admin a ON m.id_admin = a.id_admin")->result();
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/semester', $data);
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

        $data['title'] = "Tambah Mahasiswa";
        $this->db->where('hak_akses', 3);
        $data['admin'] = $this->db->get('admin')->result();
        $data['semester'] = $this->db->get('semester')->result();
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/semester_tambah', $data);
        $this->load->view('templates_admin/footer');
    }
    

    public function tambah_data_aksi()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->tambah_data();
        } else {
            $id_admin = $this->input->post('id_admin');
            $id_semester = $this->input->post('id_semester');

            $data = array(
                'id_admin' => $id_admin,
                'id_semester' => $id_semester
            );

            $this->db->insert('mahasiswa', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data berhasil ditambahkan!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');

            redirect('admin/semestermahasiswa');
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

        $where = array('id_maha' => $id);
        $data['mahasiswa'] = $this->db->get_where('mahasiswa', $where)->row();
        $data['title'] = "Update Mahasiswa";
        $this->db->where('hak_akses', 3);
        $data['admin'] = $this->db->get('admin')->result();
        $data['semester'] = $this->db->get('semester')->result();
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/semester_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_data_aksi()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update_data();

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data gagal diupdate! Mohon isi data dengan benar</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');

            redirect('admin/semestermahasiswa');
        } else {
            $id_maha = $this->input->post('id_maha');
            $id_admin = $this->input->post('id_admin');
            $id_semester = $this->input->post('id_semester');

            $data = array(
                'id_admin' => $id_admin,
                'id_semester' => $id_semester
            );

            $where = array('id_maha' => $id_maha);

            $this->db->update('mahasiswa', $data, $where);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data berhasil diupdate!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');

            redirect('admin/semestermahasiswa');
        }
    }

    public function delete_data($id)
    {
        $where = array('id_maha' => $id);
        $this->db->delete('mahasiswa', $where);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Data berhasil dihapus!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button></div>');

        redirect('admin/semestermahasiswa');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_admin', 'Admin', 'required');
        $this->form_validation->set_rules('id_semester', 'Semester', 'required');
    }
}
