<?php 

class Dashboard_petugas extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('role_id') != '2'){
			$this->session->set_flashdata('pesan','
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  Anda belum login!
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			');
			redirect('auth/login');
		}
	}
	public function index(){
		$data['buku'] = $this->model_buku->tampil_data()->result();
		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku_aktif()->result();

		$this->load->view('petugas_header');
		$this->load->view('petugas_sidebar');
		$this->load->view('petugas_dashboard',$data);
		$this->load->view('sidebar_footer');
	}
	public function daftar_buku(){
		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();
		$data['buku'] = $this->model_buku->tampil_data()->result();
		
		// print_r($data['buku']);

		$this->load->view('petugas_header');
		$this->load->view('petugas_sidebar');
		$this->load->view('petugas_daftar_buku',$data);
		$this->load->view('sidebar_footer');
	}
	public function kategori_buku($no){
		$data['buku'] = $this->model_buku->tampil_data()->result();
		$kategori_dicari = '';

		// mencari urutan keberapa kategori buku yang di pilih
		$anti_dupl = ''; 
		$no_anti_dupl = 0;
        foreach ($this->model_buku->tampil_data()->result() as $kategori) {
            if ($anti_dupl != $kategori->jenis){ 
            	$anti_dupl = $kategori->jenis;
            	$no_anti_dupl++; 
            	if ($no_anti_dupl == $no) {
            		$kategori_dicari = $kategori->jenis;
            	}
        	} 
        }

		$data['buku'] = $this->model_buku->kategori($kategori_dicari)->result();
		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();


		$this->load->view('petugas_header');
		$this->load->view('petugas_sidebar');
		$this->load->view('petugas_daftar_buku',$data);
		$this->load->view('sidebar_footer');
	}
	public function peminjaman(){
		$data['buku'] = $this->model_buku->tampil_data()->result();
		// $data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();


		$this->load->view('petugas_header');
		$this->load->view('petugas_sidebar');
		$this->load->view('petugas_peminjaman',$data);
		$this->load->view('sidebar_footer');
	}
	public function hapus_keranjang(){
		$this->cart->destroy();
		redirect('dashboard_petugas/peminjaman');
	}
	public function bawa_1_buku($id){ 
		// CART merupakan sebuah fungsi library yang disediakan oleh CodeIgniter yang biasanya digunakan untuk keperluan menampung beberapa data item secara sementara oleh browser sebelum disimpan ke database.
		// dalam kasus ini CART digunakan untuk menampung beberapa data buku yang baru diambil secara sementara sebelum buku-buku tersebut dimasukkan ke data peminjaman.


		$buku = $this->model_buku->find($id);


		// menghilangkan karakter asing pada nama buku sehingga hanya menyisakan huruf dan angka agar dapat dimasukkan ke CART. beberapa karakter seperti '/', '!', '-', '*' dan lain-lain tidak dapat diproses untuk dimasukkan ke CART
		
		$buku->merk_model = preg_replace("/[^a-zA-Z0-9]/", " ", $buku->merk_model);

		$data = array(
	        'id'      => $buku->id_buku,
	        'qty'     => 1,
	        'price'   => 00,
	        'name'	  => $buku->merk_model
		);

		//memasukkan data buku dari variable $data seperti 'id_buku' dan nama 'merk_model' buku kedalam CART 
		$this->cart->insert($data);

		redirect('dashboard_petugas/daftar_buku');
	}
	public function proses_peminjaman(){
		$is_processed = $this->model_peminjaman->proses_pinjam();
		if($is_processed){
			$this->cart->destroy();
			redirect('dashboard_petugas/riwayat_peminjaman/'.'0');
			
		}else{
			echo "Maaf, Peminjaman Buku Gagal Diproses!";
		}
	}
	public function pengembalian($id){
		if ($id == '0') { $data['peminjaman'] = $this->model_peminjaman->tampil_peminjaman()->result(); }
		if ($id == '1') { $data['peminjaman'] = $this->model_peminjaman->tampil_peminjaman_berjenis($id)->result(); }
		if ($id == '2') { $data['peminjaman'] = $this->model_peminjaman->tampil_peminjaman_berjenis($id)->result(); }

		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku_aktif()->result();
		
		$this->load->view('petugas_header');
		$this->load->view('petugas_sidebar');
		$this->load->view('petugas_pengembalian',$data);
		$this->load->view('sidebar_footer');
	}
	public function detail_peminjaman($id){
		$where = array('id_peminjaman' => $id);
		$data['peminjaman'] = $this->model_peminjaman->detail_peminjaman($where, 'tb_peminjaman')->result();
		$data['peminjaman_buku'] = $this->model_peminjaman->buku_detail_peminjaman($id)->result();
		$data['buku'] = $this->model_buku->tampil_data()->result();
		
		// print_r($data['peminjaman']);
		$this->load->view('petugas_header');
		$this->load->view('petugas_sidebar');
		$this->load->view('petugas_detail_pengembalian',$data);
		$this->load->view('sidebar_footer');
	}
	public function detail_riwayat($id){
		$where = array('id_peminjaman' => $id);
		$data['peminjaman'] = $this->model_peminjaman->detail_peminjaman($where, 'tb_peminjaman')->result();
		$data['peminjaman_buku'] = $this->model_peminjaman->buku_detail_peminjaman($id)->result();
		$data['buku'] = $this->model_buku->tampil_data()->result();
		
		// print_r($data['peminjaman']);
		$this->load->view('petugas_header');
		$this->load->view('petugas_sidebar');
		$this->load->view('petugas_detail_riwayat',$data);
		$this->load->view('sidebar_footer');
	}
	public function riwayat_peminjaman($id){
		if ($id == '0') { $data['peminjaman'] = $this->model_peminjaman->tampil_peminjaman()->result(); }
		if ($id == '1') { $data['peminjaman'] = $this->model_peminjaman->tampil_peminjaman_berjenis($id)->result(); }
		if ($id == '2') { $data['peminjaman'] = $this->model_peminjaman->tampil_peminjaman_berjenis($id)->result(); }

		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();

		$this->load->view('petugas_header');
		$this->load->view('petugas_sidebar');
		$this->load->view('petugas_riwayat_peminjaman',$data);
		$this->load->view('sidebar_footer');
	}
	public function konfirmasi_kembali($id_peminjaman,$id_buku,$konfirm){
		date_default_timezone_set('Asia/Makassar');
		$now = date('Y-m-d H:i:s');

		$data = array(
			'id_peminjaman'		=> $id_peminjaman,
			'id_buku'			=> $id_buku,
			'stts_kembali'		=> $konfirm,
			'waktu_kembali'		=> $now,
		);

		$where = array(
			'id_peminjaman'		=> $id_peminjaman,
			'id_buku'			=> $id_buku,
		);

		// print_r($where);

		$this->model_peminjaman->konfirm_kembali($where, $data, 'tb_peminjaman_buku');
		redirect('dashboard_petugas/detail_peminjaman/' .$id_peminjaman);
	}
	public function tambah_buku(){
		$buku = array(
			'id_buku' 		=> '',
			'merk_model'	=> $this->input->post('judul_buku'),
			'jenis'			=> $this->input->post('jenis'),
			'tahun'			=> $this->input->post('tahun'),
			'jumlah'		=> $this->input->post('jumlah'),
		);

		$this->model_buku->tambah($buku, 'tb_buku');
		redirect('dashboard_petugas/daftar_buku');
	}
	public function update_buku(){
		$buku = array(
			'merk_model'	=> $this->input->post('merk_model'),
			'jenis'			=> $this->input->post('jenis'),
			'tahun'			=> $this->input->post('tahun'),
			'jumlah'		=> $this->input->post('jumlah'),
		);
		$where = array(
			'id_buku'	=> $this->input->post('id_buku'),
		);

		$this->model_buku->update($where, $buku, 'tb_buku');
		redirect('dashboard_petugas/daftar_buku');
	}
	public function hapus_buku($id){
		$where = array('id_buku' => $id);
		$this->model_buku->hapus($where, 'tb_buku');
		redirect('dashboard_petugas/daftar_buku');
	}

	public function cari_buku()
	{
		$keyword = $this->input->post('keyword');
		$data['buku'] = $this->model_buku->cari_buku($keyword);
		// $data['buku'] = $this->model_buku->cari_buku_dg_jenis($keyword);

		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();
		
		//print_r($data['buku']);echo "<br>";
		// print_r($data['peminjaman_buku']);
		
		$this->load->view('petugas_header');
		$this->load->view('petugas_sidebar');
		$this->load->view('petugas_daftar_buku',$data);
		$this->load->view('sidebar_footer');
	}

}