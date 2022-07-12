<?php 

class Dashboard_admin extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('role_id') != '1'){
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
		$data['jenis'] = '';
		$data['peminjaman'] = $this->model_peminjaman->tampil_peminjaman()->result(); 
		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();

		// print_r($data);
		$this->load->view('admin_header');
		$this->load->view('admin_sidebar');
		$this->load->view('admin_daftar_laporan',$data);
		$this->load->view('sidebar_footer');
	}

	public function laporan($id){ 
		if ($id == '1') { $data['peminjaman'] = 
			$this->model_peminjaman->tampil_peminjaman_berjenis($id)->result(); $data['jenis'] = 'Harian';}
		if ($id == '2') { $data['peminjaman'] = 
			$this->model_peminjaman->tampil_peminjaman_berjenis($id)->result(); $data['jenis'] = 'Mingguan';}

		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();

		// print_r($data);
		$this->load->view('admin_header');
		$this->load->view('admin_sidebar');
		$this->load->view('admin_daftar_laporan',$data);
		$this->load->view('sidebar_footer');
	}
	public function detail_laporan($bulan, $tahun){
		$data['jenis'] = 0;
		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();
		$data['bulan'] = $bulan; $data['tahun'] = $tahun;
		$data['buku'] = $this->model_buku->tampil_data()->result();
		$where = array(
			'month(tgl_pinjam)' => $bulan,
			'year(tgl_pinjam)' => $tahun
		);

		$data['peminjaman'] = $this->model_peminjaman->detail_peminjaman($where, 'tb_peminjaman')->result();
		
		$this->load->view('admin_header');
		$this->load->view('admin_sidebar');
		$this->load->view('admin_detail_laporan',$data);
		$this->load->view('sidebar_footer');
	}
	public function detail_laporan_jenis($bulan, $tahun, $jenis){
		$data['jenis'] = $jenis;

		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();
		$data['bulan'] = $bulan; $data['tahun'] = $tahun;
		$data['buku'] = $this->model_buku->tampil_data()->result();
		$where = array(
			'month(tgl_pinjam)' => $bulan,
			'year(tgl_pinjam)' => $tahun,
			'jenis_peminjaman' => $jenis
		);

		$data['peminjaman'] = $this->model_peminjaman->detail_peminjaman($where, 'tb_peminjaman')->result();
		
		$this->load->view('admin_header');
		$this->load->view('admin_sidebar');
		$this->load->view('admin_detail_laporan',$data);
		$this->load->view('sidebar_footer');
	}
	public function cetak_pdf($bulan, $tahun, $jenis){
		$this->load->library('dompdf_gen');
		$data['jenis'] = $jenis;
		$data['peminjaman_buku'] = $this->model_peminjaman->tampil_peminjaman_buku()->result();
		$data['bulan'] = $bulan; $data['tahun'] = $tahun;
		$data['buku'] = $this->model_buku->tampil_data()->result();
		if ($jenis > 0) {
			$where = array(
				'month(tgl_pinjam)' => $bulan,
				'year(tgl_pinjam)' => $tahun,
				'jenis_peminjaman' => $jenis,
			);
		}else{
			$where = array(
				'month(tgl_pinjam)' => $bulan,
				'year(tgl_pinjam)' => $tahun,
			);
		}

		$data['peminjaman'] = $this->model_peminjaman->detail_peminjaman($where, 'tb_peminjaman')->result();
		// print_r($data['peminjaman']);
		

		$this->load->view('lembar_laporan_pdf_lndscp',$data);

		$paper_size = 'A4';
		$orientation = 'landscape';
		$html = $this->output->get_output();
		$this->dompdf->set_paper($paper_size, $orientation);

		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream('laporan_bulanan_'.$tahun.$bulan.$jenis.'.pdf', array('attachment' => 0));
	}

}