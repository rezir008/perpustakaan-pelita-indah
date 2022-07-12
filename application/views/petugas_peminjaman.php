<div class="container-fluid">
	<div class="row">
		<div class="col p-1">
			<div class="card bg-primary">
				<div class="card-body">
					<h3 class="text-white text-center" id="judul_halaman">Peminjaman Baru</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col p-1">
			<?php if ($this->cart->contents()) { ?>
			<div class="card">
				<div class="card-header text-center">
					<h6 class="font-weight-bold">Daftar Buku Yang Akan Dipinjam</h6>	
					<a class="btn btn-sm btn-success text-wrap float-right" href="<?php echo base_url('dashboard_petugas/daftar_buku')?>"> Ambil Beberapa Buku </a>								
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col">
							<table class="table table-bordered table-striped table-hover">
								<tr>
									<th>N O</th>
									<th>Judul Buku</th>
									<th>J u m l a h</th>
								</tr>
								<?php 
								$no = 1;
								foreach ($this->cart->contents() as $items) : ?>
									<tr>
										<td><?php echo $no++ ?></td>
										<td class="text-wrap"><?php echo $items['name'] ?></td>
										<td><?php echo $items['qty'] ?></td>
									</tr>			
								<?php endforeach; ?>
								<tr class="font-weight-bold">
									<td colspan="2" class="text-right">Jumlah :</td>
									<td><?php echo $this->cart->total_items(); ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<?php if($this->cart->contents()){ ?>
						<button class="btn btn-sm btn-primary mr-1 mb-1" data-toggle="modal" data-target="#mulai_pinjam"><i class="fas fa-book"></i> Form Peminjaman Harian</button>

						<a class="btn btn-sm btn-danger mr-1 mb-1" data-toggle="modal" data-target="#konfirmasi_hapus"><i class="fas fa-book"></i> Hapus Daftar</a>

					<?php } ?>
				</div>
			</div>
			<?php }

			// else{ echo' <div class="alert alert-secondary alert-dismissible fade show text-center" role="alert"> <h5 class="font-weight-bold">Data Kosong! </h5> <p>Silahkan ambil buku yang ingin anda pinjam di halaman <a  href="'. base_url('dashboard_petugas/daftar_buku'). '">Daftar Buku</a> atau klik  tombol <strong>Tambah Buku</strong> </p> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> '; } 

			?>
			
		</div>
	</div>
</div>


<!-- Modal Hapus -->
<div class="modal fade" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="nama_form_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nama_form_modal">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    		<p>Anda yakin ingin menghapus semua daftar buku yang ingin anda pinjam?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Kembali</button>
        <a href="<?php echo base_url('dashboard_petugas/hapus_keranjang') ?>"> <div class="btn btn-sm btn-danger m-1">Hapus Daftar</div> </a>
      </div>

    </div>
  </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="mulai_pinjam" tabindex="-1" role="dialog" aria-labelledby="nama_form_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nama_form_modal">Form Peminjaman Buku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form method="post" action="<?php echo base_url('dashboard_petugas/proses_peminjaman') ?> ">
  	  <div class="modal-body" id="form_peminjaman">
			<div class="form-group">
      		<label>Jenis Peminjaman</label><br>
      		<select id="jenis_peminjaman" name="jenis_peminjaman" class="form-control">
				    <option value="1">Peminjaman Harian</option>
				    <option value="2">Peminjaman Mingguan</option>
				 </select>
    	</div>
			<div class="form-group">
				<label>Nama Peminjam</label>
				<input type="text" name="nama_peminjam" class="form-control" placeholder="Nama Peminjam">
			</div>
			<div class="form-group">
      		<label>L/P</label><br>
      		<select id="lp" name="lp" class="form-control">
				    <option value="Laki-Laki">Laki-Laki</option>
				    <option value="Perempuan">Perempuan</option>
				 </select>
    	</div>
			<div class="form-group">
        		<label>Kelas</label><br>
        		<select id="kelas" name="kelas" class="form-control">
				    <option value="7A">7A</option>
				    <option value="7B">7B</option>
				    <option value="7C">7C</option>
				    <option value="7D">7D</option>
				    <option value="7E">7E</option>
				    <option value="7F">7F</option>

				    <option value="8A">8A</option>
				    <option value="8B">8B</option>
				    <option value="8C">8C</option>
				    <option value="8D">8D</option>
				    <option value="8E">8E</option>
				    <option value="8F">8F</option>

				    <option value="9A">9A</option>
				    <option value="9B">9B</option>
				    <option value="9C">9C</option>
				    <option value="9D">9D</option>
				    <option value="9E">9E</option>
				    <option value="9F">9F</option>
				    
				    <option value="Guru/Pegawai">Guru/Pegawai</option>
				 </select>
        	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
	        <button type="submit" class="btn btn-primary">Submit</button>
	      </div>
      </form>

    </div>
  </div>
</div>



