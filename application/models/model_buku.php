<?php 
class Model_buku extends CI_Model{
	public function tampil_data(){
		return $this->db->get('tb_buku');
	}
	public function kategori($kategori){
		return $this->db->get_where('tb_buku',array('jenis' => $kategori));
	}
	public function find($id){
		$result = $this->db->where('id_buku', $id)
							->limit(1)
							->get('tb_buku');
		if($result->num_rows() > 0){
			return $result->row();
		}else{
			return array();
		}
	}
	public function tambah($data,$table) {
		$this->db->insert($table,$data);
	}
	public function update($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}
	public function hapus($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
	public function cari_buku($keyword){
		$this->db->select('*');
		$this->db->from('tb_buku');
		if(!empty($keyword)){
			$this->db->like('merk_model',$keyword);
			$this->db->or_like('jenis',$keyword);
			$this->db->or_like('tahun',$keyword);
		}
		return $this->db->get()->result();
	}
}