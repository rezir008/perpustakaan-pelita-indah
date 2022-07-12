<div class="container-fluid">
	<div class="row">
		<div class="col p-1">
			<div class="card bg-primary">
				<div class="card-body">
					<h3 class="text-white text-center">Daftar Buku</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col p-1">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-auto">
							<div class="dropdown">
							  <button class="btn btn-sm btn-info dropdown-toggle text-wrap my-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Jenis Buku
							  </button>
							  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				                <a class="dropdown-item text-wrap" href="<?php echo base_url('dashboard_petugas/daftar_buku')?>">Semua Buku</a>
								<div class="dropdown-divider"></div>
							    <?php $nama_kategori = ''; $no_kategori = 1;?>
				                <?php foreach ($this->model_buku->tampil_data()->result() as $kategori) : ?>
				                    <?php if ($nama_kategori != $kategori->jenis){ ?>
				                        <a class="dropdown-item text-wrap" 
				                        href="<?php echo base_url('dashboard_petugas/kategori_buku/'.$no_kategori) ?>">
				                            <?php echo $kategori->jenis ?>
				                        </a>
				                    <?php $nama_kategori = $kategori->jenis; $no_kategori++; } ?>
				                <?php endforeach; ?>
							  </div>
							</div>
						</div>
						<div class="col-sm col-auto">
							<form class="form-inline my-1" method="post" action="<?php echo base_url('dashboard_petugas/cari_buku') ?>">
		                        <div class="input-group">
		                            <input type="text" name="keyword" class="form-control bg-light border-0 small" placeholder="Cari Buku"
		                                aria-label="Search" aria-describedby="basic-addon2">
		                            <div class="input-group-append">
		                                <button class="btn btn-info" type="submit">
		                                    <i class="fas fa-search fa-sm"></i>
		                                </button>
		                            </div>
		                        </div>
		                    </form>
						</div>
						<div class="col-auto">
							<button class="btn btn-sm btn-primary text-wrap my-1" data-toggle="modal" data-target="#form_buku_baru"><i class="fas fa-plus"></i> Tambah Buku Baru</button>
							<br>
							<?php $keranjang = $this->cart->total_items(); ?>
							<?php if($this->cart->contents()){ ?>      
								<a class="btn btn-sm btn-success text-wrap my-1" href="<?php echo base_url('dashboard_petugas/peminjaman'); ?>">Buku Yang Akan Dipinjam <div class="badge badge-info"><?php echo $keranjang; ?></div></a>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="card-body">	
					<div class="row">
						<div class="col-auto mx-auto">
							<table class="table table-bordered table-striped table-hover table-responsive">
								<tr>
									<th>NO</th>
									<th>Judul</th>
									<th>Jenis</th>
									<th>Tahun</th>
									<th>Jumlah Tersedia</th>
									<th>Aksi</th>
								</tr>
								<?php 
								$no = 1;
								rsort($buku);
								foreach ($buku as $books) : ?>
									<tr>
										<td><?php echo $no++ ?></td>
										<td class="text-wrap"><?php echo $books->merk_model ?></td>
										<td class="text-wrap"><?php echo $books->jenis ?></td>
										<td><?php echo $books->tahun ?></td>
										<td>
											<!-- menghitung jumlah buku yang tersedia dengan jumlah peminjaman di table peminjaman -->
											<?php 
												$jmlh_terpinjam = 0; $jmlh_terambil = 0;
												foreach ($peminjaman_buku as $terpinjam) {
													if ($books->id_buku == $terpinjam->id_buku && $terpinjam->stts_kembali == 0) {
														$jmlh_terpinjam += $terpinjam->jumlah;
													}
												}
												foreach ($this->cart->contents() as $terambil) {
													if ($books->id_buku == $terambil['id']) {
														$jmlh_terambil += $terambil['qty'];
													}
												}

												$tersedia = $books->jumlah - $jmlh_terpinjam - $jmlh_terambil;
												echo $tersedia ;
											?>				
										</td>
										<td>
											<?php 
												if ($tersedia > 0) { 	 
				            						echo anchor('dashboard_petugas/bawa_1_buku/' .$books->id_buku, '<div class="badge badge-success">Pinjam Buku</div>') ;
				            					}else{ 
				            						echo '<div class="badge badge-secondary text-wrap">Habis Terpinjam!</div>'; 
				            					} 
				            				?>
				            				<a class="badge badge-warning" data-toggle="modal" data-target="#edit<?php echo($books->id_buku) ?>">Edit</a>
				            				<a class="badge badge-danger" data-toggle="modal" data-target="#hapus<?php echo($books->id_buku) ?>">Hapus</a>
											
										</td>
									</tr>	

									<!-- Modal edit Buku -->
									<div class="modal fade" id="edit<?php echo($books->id_buku) ?>" tabindex="-1" role="dialog" aria-labelledby="nama_form_modal" aria-hidden="true">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="nama_form_modal">Edit Data Buku <br><strong><?php echo($books->merk_model) ?></strong></h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <form method="post" action="<?php echo base_url('dashboard_petugas/update_buku') ?> ">
										      <div class="modal-body">
										      	<input type="hidden" name="id_buku" value="<?php echo($books->id_buku) ?>">
									    		<div class="form-group">
													<label>Judul Buku</label>
													<input type="text" name="merk_model" value="<?php echo($books->merk_model) ?>" class="form-control" placeholder="Judul Buku">
												</div><div class="form-group">
													<label>Jenis</label>
													<input type="text" name="jenis" value="<?php echo($books->jenis) ?>" class="form-control" placeholder="Jenis">
												</div><div class="form-group">
													<label>Tahun</label>
													<input type="number" min="1900" value="<?php echo($books->tahun) ?>" name="tahun" class="form-control" placeholder="Tahun">
												</div><div class="form-group">
													<label>Jumlah</label>
													<input type="number" name="jumlah" value="<?php echo($books->jumlah) ?>" class="form-control" placeholder="Jumlah">
												</div>
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Kembali</button>
										        <button type="submit" class="btn btn-sm btn-warning">Simpan</button>
										      </div>
									      </form>
									    </div>
									  </div>
									</div>

									<!-- Modal hapus Buku -->
									<div class="modal fade" id="hapus<?php echo($books->id_buku) ?>" tabindex="-1" role="dialog" aria-labelledby="nama_form_modal" aria-hidden="true">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="nama_form_modal">Konfirmasi Hapus Buku <br><strong><?php echo($books->merk_model) ?></strong></h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <div class="modal-body">
									      	<input type="hidden" name="id_buku" value="<?php echo($books->id_buku) ?>">
								    		<p>Anda yakin ingin hapus buku <strong><?php echo($books->merk_model) ?></strong> ini ?</p>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Kembali</button>
									        <a href="<?php echo base_url('dashboard_petugas/hapus_buku/'.$books->id_buku) ?>" class="btn btn-sm btn-danger">Hapus</a>
									      </div>
									    </div>
									  </div>
									</div>


								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>


<!-- Modal Tambah Buku -->
<div class="modal fade" id="form_buku_baru" tabindex="-1" role="dialog" aria-labelledby="nama_form_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nama_form_modal"><i class="fas fa-plus"></i> Buku Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="<?php echo base_url('dashboard_petugas/tambah_buku') ?> ">
	      <div class="modal-body">
    		<div class="form-group">
				<label>Judul Buku</label>
				<input type="text" name="judul_buku" class="form-control" placeholder="Judul Buku">
			</div><div class="form-group">
				<label>Jenis</label>
				<input type="text" name="jenis" class="form-control" placeholder="Jenis">
			</div><div class="form-group">
				<label>Tahun</label>
				<input type="number" min="1900" value="1900" name="tahun" class="form-control" placeholder="Tahun">
			</div><div class="form-group">
				<label>Jumlah</label>
				<input type="number" name="jumlah" min="1" value="1" class="form-control" placeholder="Jumlah">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Kembali</button>
	        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
	      </div>
      </form>

    </div>
  </div>
</div>

