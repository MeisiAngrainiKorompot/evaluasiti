<?php

class Setting extends CI_Controller
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

        $data['title'] = "Pengaturan Aplikasi";
        $data['setting'] = $this->db->get('setting')->row();

        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/setting', $data);
        $this->load->view('templates_admin/footer');
    }

    public function change_k()
    {
        $aplikasi = $this->input->post('aplikasi');

        $data = array(
            'value' => $aplikasi
        );

        $this->db->where('nama', 'active');
        $this->db->update('setting', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Pengaturan Disimpan!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');

        redirect('admin/setting');
    }

}