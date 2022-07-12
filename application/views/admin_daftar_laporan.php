<div class="container-fluid">
	<div class="row">
		<div class="col p-1">
			<div class="card bg-primary">
				<div class="card-body">
					<h3 class="text-white text-center">Daftar Laporan Peminjaman <?php echo $jenis ?>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col p-1">	
			<div class="card">
				<div class="card-header">
					<div class="dropdown">
	                  <button class="btn btn-sm btn-info dropdown-toggle float-left" type="button" id="jenis_peminjaman" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                    Jenis Peminjaman
	                  </button>
	                  <div class="dropdown-menu" aria-labelledby="jenis_peminjaman">
	                    <a class="dropdown-item text-wrap " href="<?php echo base_url('dashboard_admin')?>">Semua Peminjaman</a>
                        <hr>
                        <a class="dropdown-item text-wrap " href="<?php echo base_url('dashboard_admin/laporan/'.'1')?>">Peminjaman Harian</a>
                        <a class="dropdown-item text-wrap " href="<?php echo base_url('dashboard_admin/laporan/'.'2')?>">Peminjaman Mingguan</a>
	                  </div>
	                </div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-auto mx-auto">
							<table class="table table-bordered table-striped table-hover table-responsive">
								<tr>
									<th>NO</th>
									<th>Bulan</th>
									<th>Jumlah Peminjaman</th>
									<th>Jumlah Buku Yang Dipinjam</th>
									<th>Aksi</th>
								</tr>
								<?php 
								$no = 1; $month = '';
								// rsort($peminjaman);
								
								//mengelompokkan daftar peminjaman dari database berdasarkan bulan
								
								//menampilkan semua daftar peminjaman
								foreach ($peminjaman as $riwayat) {
								$newdate = new DateTime($riwayat->tgl_pinjam); $new_month = (string)$newdate->format('F, Y');

									//memilah daftar peminjaman berdasarkan bulan
									//jika ada peminjaman yang terjadi pada bulan yang sama maka akan dikelompokkan dalam di satu baris yang sama
									if ($new_month != $month) {
									$newdate = new DateTime($riwayat->tgl_pinjam); $month = (string)$newdate->format('F, Y');

									//menentukan jumlah peminjaman pada bulan yang sudah ditentukan
									$jumlah_peminjaman = 0;
									$jumlah_peminjaman_harian = 0;
									$jumlah_peminjaman_mingguan = 0;
									$jumlah_buku = 0;
									$jumlah_buku_harian = 0;
									$jumlah_buku_mingguan = 0;

										//menampilkan ulang semua daftar peminjaman
										foreach ($peminjaman as $hitung_peminjaman) {
											$berdasarkan_bulan = new DateTime($hitung_peminjaman->tgl_pinjam); 
											$terhitung = (string)$berdasarkan_bulan->format('F, Y');

											//memilah menghitung jumlah peminjaman di bulan tersebut
											if ($terhitung == $month) {
												$jumlah_peminjaman++;

												//menghitung jumlah peminjaman harian dan buku yang dipinjam harian di bulan tersebut
												if ($hitung_peminjaman->jenis_peminjaman == 1) {
													$jumlah_peminjaman_harian++;
													foreach ($peminjaman_buku as $hitung_buku) {
														if ($hitung_buku->id_peminjaman == $hitung_peminjaman->id_peminjaman) {
															$jumlah_buku_harian += $hitung_buku->jumlah;
														}
													}
												}

												//menghitung jumlah peminjaman mingguan dan buku yang dipinjam mingguan di bulan tersebut
												if ($hitung_peminjaman->jenis_peminjaman == 2) {
													$jumlah_peminjaman_mingguan++;
													foreach ($peminjaman_buku as $hitung_buku) {
														if ($hitung_buku->id_peminjaman == $hitung_peminjaman->id_peminjaman) {
															$jumlah_buku_mingguan += $hitung_buku->jumlah;
														}
													}
												}

												//menampilkan semua daftar peminjaman buku 
												foreach ($peminjaman_buku as $hitung_buku) {

													//memilah menghitung jumlah peminjaman buku di bulan tersebut
													if ($hitung_buku->id_peminjaman == $hitung_peminjaman->id_peminjaman) {
														$jumlah_buku += $hitung_buku->jumlah;
													}
												}
											}
										}

								//menampilkan daftar peminjaman
								?>
									<tr>							
										<td><?php echo $no++ ?></td>
										<td><?php echo $month; ?></td>
										<td>
											<div class="dropdown">
						                      <button class="btn btn-outline btn-block float-left" type="button" id="peminjaman<?php echo $no ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						                        <?php echo $jumlah_peminjaman; ?>
						                      </button>
						                      <div class="dropdown-menu" aria-labelledby="peminjaman<?php echo $no ?>">
						                      	<div class="dropdown-item text-center"><div class="badge">Detail Jumlah : </div></div>
						                        <?php  
													if ($jumlah_peminjaman_harian > 0) {
														echo '<div class="dropdown-item text-wrap">Harian : '.$jumlah_peminjaman_harian.'</div>';
													}
													if ($jumlah_peminjaman_mingguan > 0) {
														echo '<div class="dropdown-item text-wrap">Mingguan : '.$jumlah_peminjaman_mingguan.'</div>';
													}
												?>
						                      </div>
						                    </div>
										</td>
										<td><div class="text-center">
											<div class="dropdown">
						                      <button class="btn btn-outline btn-block float-left" type="button" id="buku<?php echo $no ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						                        <?php echo $jumlah_buku; ?>
						                      </button>
						                      <div class="dropdown-menu" aria-labelledby="buku<?php echo $no ?>">
						                      	<div class="dropdown-item text-center"><div class="badge">Detail Jumlah : </div></div>
						                        <?php  
													if ($jumlah_buku_harian > 0) {
														echo '<div class="dropdown-item text-wrap">Harian : '.$jumlah_buku_harian.'</div>';
													}
													if ($jumlah_buku_mingguan > 0) {
														echo '<div class="dropdown-item text-wrap">Mingguan : '.$jumlah_buku_mingguan.'</div>';
													}
												?>
						                      </div>
						                    </div>
										</div>

										</td>
										<td><?php  
											$no_bulan = (int)$newdate->format('m'); 
											$no_tahun = (int)$newdate->format('Y');
											echo anchor('dashboard_admin/detail_laporan/' .$no_bulan.'/' .$no_tahun ,'<div class="badge badge-info">Detail</div>');
										?></td>
									</tr>
								<?php }} ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>