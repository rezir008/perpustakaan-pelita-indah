<!DOCTYPE html>
<html><head>
	<style>
	@media print {
	    .pagebreak {
	        clear: both;
	        page-break-after: always;
	    }
	}
	h1, h2, h3, h4, h5, h6, strong{
		font-family: Arial, Helvetica;
	}

	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
		font-family: Arial, Helvetica;
	}
	</style>
</head><body>

	<h3 style="text-align:center;">Laporan Peminjaman 
		<?php if ($jenis == 1) { echo 'Harian'; }elseif ($jenis == 2) { echo 'Mingguan'; } ?>
		<br><?php echo date("F", mktime(0, 0, 0, $bulan, 1)).' '.$tahun; ?>
	</h3>

	<hr>
	<h3 style="text-align:center;">Daftar Peminjaman</h3>
	<table style="width:100%; text-align:center;" border="1">
		<tr> 
			<th rowspan="2">NO</th>
			<th rowspan="2">Peminjam</th>	
			<th colspan="3">Data Peminjaman</th> 
			<th colspan="3">Data Buku Yang Dipinjam</th>

		</tr>
		<tr>
			<th>Jenis Peminjaman</th>
			<th>Waktu Pinjam</th>
			<th>Batas Waktu</th>
			<th>Judul Buku</th>
			<th>Jumlah</th>
			<th>Status Pengembalian Buku</th>
		</tr>
		<?php $no = 1; foreach ($peminjaman as $terpinjam ) { ?>
			<?php $row_num = 1; foreach ($peminjaman_buku as $rent_books) { 
				if ($terpinjam->id_peminjaman == $rent_books->id_peminjaman){
					$row_num++;
				}
			} ?>
			

			<?php
				$telat = 0; $belum_selesai = 0;
				foreach($peminjaman_buku as $hitung) { 
					//cek status
					if($hitung->id_peminjaman == $terpinjam->id_peminjaman && $hitung->stts_kembali == 0) { $belum_selesai++; }
					if($hitung->id_peminjaman == $terpinjam->id_peminjaman && $hitung->waktu_kembali > $terpinjam->tgl_kembali) { $telat++; }
				}
				$new_date_conv = new DateTime($terpinjam->tgl_pinjam); 
				$conv_tgl_pinjam = (string)$new_date_conv->format('d F Y, H:i');
				$new_date_conv = new DateTime($terpinjam->tgl_kembali); 
				$conv_tgl_kembali = (string)$new_date_conv->format('d F Y, H:i');
			?>

			<tr>
				<td rowspan="<?php echo $row_num-1 ?>"><?php echo $no++ ?></td>
				<td rowspan="<?php echo $row_num-1 ?>"><strong><?php echo $terpinjam->nama_peminjam ?></strong><br>
					<?php if ($terpinjam->kelas == 'Guru/Pegawai') { echo 'Jabatan : Guru / Pegawai'; }else{ echo 'kelas : '.$terpinjam->kelas; } ?>
				</td>
				<td rowspan="<?php echo $row_num-1 ?>"><?php 
					if ($terpinjam->jenis_peminjaman == 1) { echo 'Harian'; } 
					if ($terpinjam->jenis_peminjaman == 2) { echo 'Mingguan'; }
				?></td>
				<td rowspan="<?php echo $row_num-1 ?>"><?php echo $conv_tgl_pinjam ?></td>
				<td rowspan="<?php echo $row_num-1 ?>"><?php echo $conv_tgl_kembali ?></td>
				<?php $loop=0; foreach ($peminjaman_buku as $rent_books) { if ($terpinjam->id_peminjaman == $rent_books->id_peminjaman && $loop==0){ $loop++;?>	
					<td> <?php foreach ($buku as $books) {
						if ($books->id_buku == $rent_books->id_buku && $rent_books->id_peminjaman == $terpinjam->id_peminjaman) {
							echo $books->merk_model;
						}
					} ?> </td>

					<td><?php echo $rent_books->jumlah; ?></td>
					
					<td><?php  
						if ($rent_books->stts_kembali == 0) {
							echo 'Belum Selesai';
						}else{
							echo 'Selesai';
						}
						if ($rent_books->waktu_kembali > $terpinjam->tgl_kembali) {
							echo ', Terlambat';
						}
					?></td>
		
				<?php } } ?>  
			</tr>

			<?php $loop=0; foreach ($peminjaman_buku as $rent_books) { if ($terpinjam->id_peminjaman == $rent_books->id_peminjaman){ if ($loop > 0) {
			?>		
				<tr>
					<td> <?php foreach ($buku as $books) {
						if ($books->id_buku == $rent_books->id_buku && $rent_books->id_peminjaman == $terpinjam->id_peminjaman) {
							echo $books->merk_model;
						}
					} ?> </td>

					<td><?php echo $rent_books->jumlah; ?></td>
					
					<td><?php  
						if ($rent_books->stts_kembali == 0) {
							echo 'Belum Selesai';
						}else{
							echo 'Selesai';
						}
						if ($rent_books->waktu_kembali > $terpinjam->tgl_kembali) {
							echo ', Terlambat';
						}
					?></td>
				</tr>
			<?php }else{$loop++;}} } ?>   
			<?php } ?>
												
		</table>

	<p style="page-break-before: always">
	<h3 style="text-align:center;">Rekap Peminjaman</h3>
	<table style="width:100%; text-align:center;" border="1">
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
		<tr>
			<th style="border: 1px solid white;"></th>
			<?php if($jumlah_buku_harian > 0){ echo '<th>Peminjaman Harian</th>';}?>
			<?php if($jumlah_buku_mingguan > 0){ echo '<th>Peminjaman Mingguan</th>';}?>
			<?php if($jumlah_buku_harian > 0 && $jumlah_buku_mingguan > 0){ echo '<th>Keseluruhan</th>';}?>
		</tr>
		<tr>
			<td>Jumlah Peminjaman</td>
			<?php if($jumlah_buku_harian > 0){ echo '<td>'.$jumlah_peminjaman_harian.'</td>';}?>
			<?php if($jumlah_buku_mingguan > 0){ echo '<td>'.$jumlah_peminjaman_mingguan.'</td>';}?>
			<?php if($jumlah_buku_harian > 0 && $jumlah_buku_mingguan > 0){ echo '<td><strong>'.$jumlah_peminjaman.'</strong></td>';}?>
		</tr>
		<tr>
			<td>Jumlah Buku Dipinjam</td>
			<?php if($jumlah_buku_harian > 0){ echo '<td>'.$jumlah_buku_harian.'</td>';}?>
			<?php if($jumlah_buku_mingguan > 0){ echo '<td>'.$jumlah_buku_mingguan.'</td>';}?>
			<?php if($jumlah_buku_harian > 0 && $jumlah_buku_mingguan > 0){ echo '<td><strong>'.$jumlah_buku.'</strong></td>';}?>
		</tr>
	</table>
</body></html>