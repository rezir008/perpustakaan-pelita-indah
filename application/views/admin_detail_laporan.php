<div class="container-fluid">
	<div class="row">
		<div class="col p-1">
			<div class="card">
				<div class="card-header bg-primary">
					<h3 class="text-white text-center">Detail Laporan Peminjaman 
						<?php if ($jenis == 1) { echo 'Harian'; }elseif ($jenis == 2) { echo 'Mingguan'; } ?>
					</h3>
					<h6 class="text-white text-center">Pada <?php echo date("F", mktime(0, 0, 0, $bulan, 1)).' '.$tahun; ?></h6>
				</div><div class="card-footer">
					<div class="row">
						<div class="col-auto">	
							<a class="btn btn-sm btn-secondary text-wrap my-1" href="<?php echo base_url('dashboard_admin')?>">Kembali</a>
						</div>
						<div class="col">
							<div class="dropdown">
			                  <button class="btn btn-sm btn-info dropdown-toggle my-1" type="button" id="jenis_peminjaman" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                    Jenis Peminjaman
			                  </button>
			                  <div class="dropdown-menu" aria-labelledby="jenis_peminjaman">
			                    <a class="dropdown-item text-wrap " href="<?php echo base_url('dashboard_admin/detail_laporan/'.$bulan.'/'.$tahun)?>">Semua Peminjaman</a>
		                        <hr>
		                        <a class="dropdown-item text-wrap " href="<?php echo base_url('dashboard_admin/detail_laporan_jenis/'.$bulan.'/'.$tahun.'/'.'1')?>">Peminjaman Harian</a>
		                        <a class="dropdown-item text-wrap " href="<?php echo base_url('dashboard_admin/detail_laporan_jenis/'.$bulan.'/'.$tahun.'/'.'2')?>">Peminjaman Mingguan</a>
			                  </div>
			                </div>
						</div>
						<div class="col-auto">
		                    <a class="btn btn-sm btn-primary text-wrap my-1" href="<?php echo base_url('dashboard_admin/cetak_pdf/'.$bulan.'/'.$tahun.'/'.$jenis)?>">Cetak <div class="badge badge-danger">PDF</div></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col p-1">	
			<div class="card">
				<div class="card-header text-center">
					<strong>Daftar Peminjaman</strong>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-auto mx-auto">
							<table class="table table-bordered table-responsive table-hover">
								<tr class="table-secondary text-center"> 
									<th rowspan="2">Peminjam</th>
									<th colspan="3">Data Peminjaman</th> 
									<th colspan="3">Data Buku Yang Dipinjam</th>
								</tr>
								<tr class="text-center table-secondary">
									<th>Jenis Peminjaman</th>
									<th>Waktu Pinjam</th>
									<th>Batas Waktu</th>
									<th>Judul Buku</th>
									<th>Jumlah</th>
									<th>Status Pengembalian Buku</th>
								</tr>
								<?php foreach ($peminjaman as $terpinjam ) {  
									$row_num = 1; 
									foreach ($peminjaman_buku as $rent_books) { 
										if ($terpinjam->id_peminjaman == $rent_books->id_peminjaman){
											$row_num++;
										}
									} 
										$telat = 0; $belum_selesai = 0;
										foreach($peminjaman_buku as $hitung) { 
											//cek status
											if($hitung->id_peminjaman == $terpinjam->id_peminjaman && $hitung->stts_kembali == 0) { $belum_selesai++; }
											if($hitung->id_peminjaman == $terpinjam->id_peminjaman && $hitung->waktu_kembali > $terpinjam->tgl_kembali) { $telat++; }
										}

										$new_date_conv = new DateTime($terpinjam->tgl_pinjam); 
										$new_tgl_pinjam = (string)$new_date_conv->format('d F Y, H:i');
										$new_date_conv = new DateTime($terpinjam->tgl_kembali); 
										$new_tgl_kembali = (string)$new_date_conv->format('d F Y, H:i');
									?>

									<tr class="text-center">
										<td rowspan="<?php echo	$row_num ?>"><strong class="h3"><?php echo $terpinjam->nama_peminjam ?></strong><br>
											<div class="badge"><?php if ($terpinjam->kelas == 'Guru/Pegawai') { echo 'Jabatan : Guru / Pegawai'; }else{ echo 'kelas : '.$terpinjam->kelas; } ?></div>
										</td>
										<td rowspan="<?php echo $row_num ?>"><?php 
											if ($terpinjam->jenis_peminjaman == 1) { echo 'Harian'; } 
											if ($terpinjam->jenis_peminjaman == 2) { echo 'Mingguan'; }
										?></td>
										<td rowspan="<?php echo $row_num ?>"><?php echo $new_tgl_pinjam ?></td>
										<td rowspan="<?php echo $row_num ?>"><?php echo $new_tgl_kembali ?></td>
									</tr>

									<?php foreach ($peminjaman_buku as $rent_books) { 
										if ($terpinjam->id_peminjaman == $rent_books->id_peminjaman){
											?>		
										
										<tr>
											<td class="text-nowrap"> <?php foreach ($buku as $books) {
													if ($books->id_buku == $rent_books->id_buku && $rent_books->id_peminjaman == $terpinjam->id_peminjaman) {
														echo $books->merk_model;
													}
											} ?> </td>

											<td class="text-center"><?php echo $rent_books->jumlah; ?></td>
											
											<td class="text-nowrap"><?php  
												if ($rent_books->stts_kembali == 0) {
														echo '<div class="badge badge-warning mr-1">Belum Selesai</div>';
													}else{
														echo '<div class="badge badge-success mr-1">Selesai</div>';
													}
													if ($rent_books->waktu_kembali > $terpinjam->tgl_kembali) {
														echo '<div class="badge badge-danger">Terlambat</div>';
													}
											?></td>

										</tr>										
											<?php 	
											}
										}
									?>
									
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col p-1">	
			<div class="card">
				<div class="card-header text-center">
					<strong>Rekap Peminjaman</strong>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-auto mx-auto">
							<table class="table table-bordered table-responsive text-center table-hover">
								<?php  
									//menentukan jumlah peminjaman pada bulan yang sudah ditentukan
									$jumlah_peminjaman = 0;
									$jumlah_peminjaman_harian = 0;
									$jumlah_peminjaman_mingguan = 0;
									$jumlah_buku = 0;
									$jumlah_buku_harian = 0;
									$jumlah_buku_mingguan = 0;

									foreach ($peminjaman as $pinjam) {
										$jumlah_peminjaman++;
										if ($pinjam->jenis_peminjaman == '1') {
											$jumlah_peminjaman_harian++;
											foreach ($peminjaman_buku as $buku_dipinjam) {
												if ($pinjam->id_peminjaman == $buku_dipinjam->id_peminjaman) {
													 $jumlah_buku_harian += $buku_dipinjam->jumlah;
												}
											}
										}
										if ($pinjam->jenis_peminjaman == '2') {
											$jumlah_peminjaman_mingguan++;
											foreach ($peminjaman_buku as $buku_dipinjam) {
												if ($pinjam->id_peminjaman == $buku_dipinjam->id_peminjaman) {
													 $jumlah_buku_mingguan += $buku_dipinjam->jumlah;
												}
											}
										}
										foreach ($peminjaman_buku as $buku_dipinjam) {
											if ($pinjam->id_peminjaman == $buku_dipinjam->id_peminjaman) {
												 $jumlah_buku += $buku_dipinjam->jumlah;
											}
										}
									}
								?>
								<tr class="table-secondary">
									<th></th>
									<?php if($jumlah_buku_harian > 0){ echo '<th>Peminjaman Harian</th>';}?>
									<?php if($jumlah_buku_mingguan > 0){ echo '<th>Peminjaman Mingguan</th>';}?>
									<?php if($jumlah_buku_harian > 0 && $jumlah_buku_mingguan > 0){ echo '<th>Keseluruhan</th>';}?>
								</tr>
								<tr>
									<td>Jumlah Peminjaman</td>
									<?php if($jumlah_buku_harian > 0){ echo '<td>'.$jumlah_peminjaman_harian.'</td>';}?>
									<?php if($jumlah_buku_mingguan > 0){ echo '<td>'.$jumlah_peminjaman_mingguan.'</td>';}?>
									<?php if($jumlah_buku_harian > 0 && $jumlah_buku_mingguan > 0){ echo '<td>'.$jumlah_peminjaman.'</td>';}?>
								</tr>
								<tr>
									<td>Jumlah Buku Dipinjam</td>
									<?php if($jumlah_buku_harian > 0){ echo '<td>'.$jumlah_buku_harian.'</td>';}?>
									<?php if($jumlah_buku_mingguan > 0){ echo '<td>'.$jumlah_buku_mingguan.'</td>';}?>
									<?php if($jumlah_buku_harian > 0 && $jumlah_buku_mingguan > 0){ echo '<td>'.$jumlah_buku.'</td>';}?>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>