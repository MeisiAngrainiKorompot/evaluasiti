<?php 
class LppmModel extends CI_Model {

	public function insertAdmin($nim, $angkatan, $nama_admin, $pembimbing, $hak_akses) {
        $data = array(
        	'nim' => $nim,
        	'angkatan' => $angkatan,
            'nama_admin' => $nama_admin,
            'pembimbing' => $pembimbing,
            'username' => $nim,
            'password' => md5($nim),
            'hak_akses' => $hak_akses
        );

        $this->db->insert('admin', $data);
    }

    public function getLastAdminId() {
        $this->db->select_max('id_admin');
        $query = $this->db->get('admin');

        $result = $query->row();
        return $result->id_admin;
    }

    public function insertMahasiswa($id_admin, $id_semester) {
        $data = array( // Ganti dengan nilai ID Mahasiswa yang sesuai
            'id_admin' => $id_admin,
            'id_semester' => $id_semester
        );

        $this->db->insert('mahasiswa', $data);
    }
	
	public function get_data($table) {
		return $this->db->get($table);
	}

	public function get_data_where($table, $where) {
        return $this->db->get_where($table, $where);
    }

	public function insert_data($data, $table){
		$this->db->insert($table, $data);
		return $this->db->affected_rows();
	}

	public function update_data($table, $data, $where) {
		$this->db->where($where);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}

	public function delete_data($where, $table) {
		$this->db->where($where);
		$this->db->delete($table);
		return $this->db->affected_rows();
	}

	public function empty_table($table) {
		$this->db->truncate($table);
		return $this->db->affected_rows();
	}
	

	public function cek_login()
	{
		$username	= set_value ('username');
		$password	= set_value ('password');

		$result 	= $this->db->where('username', $username)
							   ->where('password', md5($password))
							   ->limit(1)
							   ->get('admin');

		if($result->num_rows()>0){
			return $result->row();
		}else{
			return FALSE;
		}

	}

	public function count_data($table) {
		return $this->db->count_all($table);
	}

	public function update_evaluasi($id_evaluasi, $ulasan) {
		$data = array(
			'ulasan' => $ulasan
		);
		$this->db->where('id_evaluasi', $id_evaluasi);
		$this->db->update('evaluasi', $data);
		return $this->db->affected_rows();
	}

	public function update_cleaning($id_cleaning, $ulasan) {
		$data = array(
			'ulasan' => $ulasan
		);
		$this->db->where('id_cleaning', $id_cleaning);
		$this->db->update('cleaning', $data);
		return $this->db->affected_rows();
	}

    public function getDosenData() {
        $query = $this->db->query("SELECT nama_dosen, COUNT(*) as jumlah FROM evaluasi GROUP BY nama_dosen ORDER BY jumlah DESC LIMIT 5");
        $data = [];
        foreach ($query->result() as $row) {
            $data[] = $row->jumlah;
        }
        return $data;
    }

    public function getDosenLabels() {
        $query = $this->db->query("SELECT nama_dosen, COUNT(*) as jumlah FROM evaluasi GROUP BY nama_dosen ORDER BY jumlah DESC LIMIT 5");
        $labels = [];
        foreach ($query->result() as $row) {
            $labels[] = $row->nama_dosen;
        }
        return $labels;
    }

	public function getMatkulData() {
		$query = $this->db->query("SELECT a.mata_kuliah, COUNT(*) as jumlah FROM evaluasi a LEFT JOIN mata_kuliah b ON a.mata_kuliah = b.id_mata_kuliah GROUP BY a.mata_kuliah ORDER BY jumlah DESC LIMIT 5");
		$data = [];
		foreach ($query->result() as $row) {
			$data[] = $row->jumlah;
		}
		return $data;
	}
	
	public function getMatkulLabels() {
		$query = $this->db->query("SELECT b.nama_mata_kuliah, COUNT(*) as jumlah FROM evaluasi a LEFT JOIN mata_kuliah b ON a.mata_kuliah = b.id_mata_kuliah GROUP BY b.nama_mata_kuliah ORDER BY jumlah DESC LIMIT 5");
		$labels = [];
		foreach ($query->result() as $row) {
			$labels[] = $row->nama_mata_kuliah;
		}
		return $labels;
	}
	

	
	
}
?>
