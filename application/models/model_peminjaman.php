<?php 

class Model_peminjaman extends CI_Model{
	public function detail_peminjaman($where,$table){
		if ($table == 'tb_peminjaman') {
			$this->db->order_by("tgl_pinjam", "desc");
		}
		return $this->db->get_where($table,$where);
	}
	public function buku_detail_peminjaman($id_peminjaman){
		return $this->db->get_where('tb_peminjaman_buku', array('id_peminjaman' => $id_peminjaman));

	}
	public function tampil_peminjaman(){
		$this->db->order_by("tgl_pinjam", "desc");
		return $this->db->get('tb_peminjaman');
	}
	public function tampil_peminjaman_berjenis($jenis){
		$this->db->order_by("tgl_pinjam", "desc");
		return $this->db->get_where('tb_peminjaman',array('jenis_peminjaman' => $jenis));
	}
	public function kategori($kategori){
		return $this->db->get_where('tb_buku',array('jenis' => $kategori));
	}
	public function tampil_peminjaman_buku(){
		return $this->db->get('tb_peminjaman_buku');
	}
	public function tampil_peminjaman_buku_aktif(){
		return $this->db->get_where('tb_peminjaman_buku', array('stts_kembali' => 0));
	}
	public function proses_pinjam(){
		date_default_timezone_get('Asia/Makassar');
		$jenis_peminjaman = $this->input->post('jenis_peminjaman');
		$tgl_pinjam = $this->input->post('tgl_pinjam');
		$nama_peminjam = $this->input->post('nama_peminjam');
		$lp = $this->input->post('lp');
		$kelas = $this->input->post('kelas');

		if ($jenis_peminjaman == '1') {
			$peminjaman = array(
				'jenis_peminjaman' => $jenis_peminjaman,
				'nama_peminjam' => $nama_peminjam,
				'lp' => $lp,
				'kelas' => $kelas,
				'tgl_pinjam' => date('Y-m-d H:i:s'),
				'tgl_kembali' => date("Y-m-d H:i:s", mktime(23, 59, 59, date('m'), date('d'), date('Y')))
			);
		}elseif ($jenis_peminjaman == '2') {
			$tgl_kembali = $this->input->post('tgl_kembali');

			$peminjaman = array(
				'jenis_peminjaman' => $jenis_peminjaman,
				'nama_peminjam' => $nama_peminjam,
				'lp' => $lp,
				'kelas' => $kelas,
				'tgl_pinjam' => date('Y-m-d H:i:s'),
				'tgl_kembali' => date("Y-m-d H:i:s", mktime(23, 59, 59, date('m'), date('d')+7, date('Y')))
			);
		}
		
		$this->db->insert('tb_peminjaman', $peminjaman);
		$id_peminjaman = $this->db->insert_id();

		foreach($this->cart->contents() as $item){
			$buku_pinjaman = array(
				'id_peminjaman'		=> $id_peminjaman,
				'id_buku'			=> $item['id'],
				'jumlah'			=> $item['qty'],
				'stts_kembali'		=> 0,
			);
			$this->db->insert('tb_peminjaman_buku', $buku_pinjaman);
		}
		return TRUE;
	}
	public function konfirm_kembali($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}
}