<div class="container-fluid">
	<div class="row">
		<div class="col p-1">
			<div class="card bg-primary">
				<div class="card-body">
					<h3 class="text-white text-center" id="judul_halaman">Pengembalian</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col p-1">
			<div class="card">
				<div class="card-header">
					<div class="dropdown">
					  <button class="btn btn-sm btn-info dropdown-toggle float-left" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Jenis Pengembalian
					  </button>
					  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		                <a class="dropdown-item" href="<?php echo base_url('dashboard_petugas/pengembalian/'.'1')?>">Pengembalian<br>Harian</a>
                        <a class="dropdown-item" href="<?php echo base_url('dashboard_petugas/pengembalian/'.'2')?>">Pengembalian<br>Mingguan</a>
						<div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url('dashboard_petugas/pengembalian/'.'0')?>">Semua Pengembalian</a>
					  </div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-auto mx-auto">
							<table class="table table-bordered table-striped table-hover table-responsive">
								<tr>
									<th>NO</th>
									<th>Nama Peminjam</th>
									<th>L / P</th>
									<th>Kelas / Jabatan</th>
									<th>Jenis</th>
									<th>Waktu Pinjam</th>
									<th>Batas Waktu</th>
									<th>Aksi</th>
								</tr>
								<?php 
								rsort($peminjaman);
								$no = 1;
								
								// menampilkan peminjaman dengan status buku yang belum dikembalikan
								foreach ($peminjaman as $pinjam) {
									$new_date_conv = new DateTime($pinjam->tgl_pinjam); 
									$conv_tgl_pinjam = (string)$new_date_conv->format('d F Y, H:i');
									$new_date_conv = new DateTime($pinjam->tgl_kembali); 
									$conv_tgl_kembali = (string)$new_date_conv->format('d F Y, H:i');

									$belum_selesai = 0; $sudah_selesai = 0; $telat = 0;
									foreach ($peminjaman_buku as $bukus) {
										if ($bukus->id_peminjaman === $pinjam->id_peminjaman) {
											if ($bukus->waktu_kembali > $pinjam->tgl_kembali) {
												$telat += 1;
											}
											if ($bukus->stts_kembali == '0') {
												$belum_selesai += 1;
												if ($belum_selesai == 1) { ?>
												<tr>
													<td><?php echo $no++ ?></td>
													<td class="text-wrap"><?php echo $pinjam->nama_peminjam ?></td>
													<td><?php echo $pinjam->lp ?></td>
													<td class="text-wrap">
														<?php  
															if ($pinjam->kelas == '0') {
																echo 'Guru / Pegawai';
															}else{
																echo $pinjam->kelas;
															}
														?>
													</td>
													<td class="text-wrap">
														<?php  
															if ($pinjam->jenis_peminjaman == '1') {
																echo ' Harian';
															}elseif ($pinjam->jenis_peminjaman == '2') {
																echo ' Mingguan';
															}
														?>
													</td>
													<td class="text-wrap"><?php echo $conv_tgl_pinjam ?></td>
													<td class="text-wrap"><?php echo $conv_tgl_kembali ?></td>
													
													<td>
											            <?php echo anchor('dashboard_petugas/detail_peminjaman/' .$pinjam->id_peminjaman, '<div class="badge badge-info">Detail</div>') ?>
													</td>
												</tr>			
												<?php } 
											} 
										} 
									} 
								}?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
