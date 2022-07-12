<div class="container-fluid">
	<div class="row">
		<div class="col p-1">
			<div class="card bg-primary">
				<div class="card-body">
					<h3 class="text-white text-center" id="judul_halaman">Detail Riwayat Peminjaman</h3>
					<?php foreach ($peminjaman as $peminjam) {
						echo '<h6 class="text-white text-center">Atas Nama : <div class="badge badge-info">'.$peminjam->nama_peminjam.' </div></h6>';
					} ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col p-1">
			<div class="card">
				<div class="card-header">
					<?php foreach ($peminjaman as $pinjam) {
						echo anchor('dashboard_petugas/riwayat_peminjaman/'.'0', '<div class="btn btn-sm btn-secondary float-left">Kembali</div>'); 
						echo anchor('dashboard_petugas/detail_peminjaman/' .$pinjam->id_peminjaman, '<div class="btn btn-sm btn-warning float-right">Edit</div>'); 
					} ?>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-auto mx-auto">
							<table class="table table-bordered table-striped table-hover table-responsive">
								<tr>
									<th>NO</th>
									<th>Nama Buku</th>
									<th>Jumlah</th>
									<th>Status</th>
									<th>Waktu Kembali</th>
								</tr>
								<?php 
								$no = 1;
								foreach ($peminjaman_buku as $books) : 
									$new_date_conv = new DateTime($books->waktu_kembali); 
									$conv_waktu_kembali = (string)$new_date_conv->format('d F Y, H:i');
								?>
									<tr>
										<td><?php echo $no++ ?></td>
										<td><?php foreach ($buku as $new_buku){if($new_buku->id_buku == $books->id_buku){ echo $new_buku->merk_model; }} ?></td>
										<td><?php echo $books->jumlah; ?></td>
										<td><?php   
											foreach($peminjaman as $pinjam){if ($books->waktu_kembali > $pinjam->tgl_kembali) { echo '<div class="m-1 badge badge-danger">Terlambat</div>';
											}}
											if($books->stts_kembali == 0){echo '<div class="m-1 badge badge-warning">Masih<br>Dipinjam</div>';}
											elseif($books->stts_kembali == 1){echo '<div class="m-1 badge badge-success">Dikembalikan</div>';}
										?></td>
										<td><?php echo $conv_waktu_kembali; ?></td>
										
									</tr>			
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>