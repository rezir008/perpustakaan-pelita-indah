<h3 style="text-align:center;">Laporan Peminjaman 
	<?php if ($jenis == 1) { echo 'Harian'; }elseif ($jenis == 2) { echo 'Mingguan'; } ?>
	<br><?php echo date("F", mktime(0, 0, 0, $bulan, 1)).' '.$tahun; ?>
</h3>
<br>
<div style="text-align:center;"><strong>Daftar Peminjaman</strong></div><hr>

<table style="width:100%; text-align:center;" border="1">
	<?php $no = 1; foreach ($peminjaman as $terpinjam ) { ?>
		<?php $row_num = 1; foreach ($peminjaman_buku as $rent_books) { 
			if ($terpinjam->id_peminjaman == $rent_books->id_peminjaman){
				$row_num++;
			}
		} ?>
		<tr> 
			<th rowspan="<?php echo $row_num+4 ?>"><?php echo $no++ ?></th>
			<th>Peminjam</th>
			<th colspan="3">Data Peminjaman</th> 
		</tr>
		<tr>
			<td rowspan="2"><strong><?php echo $terpinjam->nama_peminjam ?></strong><br>
				<?php if ($terpinjam->kelas == 'Guru/Pegawai') { echo 'Jabatan : Guru / Pegawai'; }else{ echo 'kelas : '.$terpinjam->kelas; } ?>
			</td>
			<th>Jenis Peminjaman</th>
			<th>Waktu Pinjam</th>
			<th>Batas Waktu</th>
		</tr>

		<?php
			$telat = 0; $belum_selesai = 0;
			foreach($peminjaman_buku as $hitung) { 
				//cek status
				if($hitung->id_peminjaman == $terpinjam->id_peminjaman && $hitung->stts_kembali == 0) { $belum_selesai++; }
				if($hitung->id_peminjaman == $terpinjam->id_peminjaman && $hitung->waktu_kembali > $terpinjam->tgl_kembali) { $telat++; }
			}
		?>

		<tr>
			<td><?php 
				if ($terpinjam->jenis_peminjaman == 1) { echo 'Harian'; } 
				if ($terpinjam->jenis_peminjaman == 2) { echo 'Mingguan'; }
			?></td>
			<td><?php echo $terpinjam->tgl_pinjam ?></td>
			<td><?php echo $terpinjam->tgl_kembali ?></td>
		</tr>

		<tr>
			<th colspan="4">Data Buku Yang Dipinjam</th>
		</tr>
		<tr>
			<th>Judul Buku</th>
			<th>Jumlah</th>
			<th>Status Pengembalian Buku</th>
			<th>Waktu kembali</th>
		</tr>
		<?php foreach ($peminjaman_buku as $rent_books) { if ($terpinjam->id_peminjaman == $rent_books->id_peminjaman){ ?>		
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

				<td><?php echo $rent_books->waktu_kembali ?></td>
			</tr>
		<?php } } echo '<tr><td colspan="5"><hr><br></td></tr>'; } ?>
											
	</table>

<br>
<br>
<div style="text-align:center;"><strong>Rekap Peminjaman</strong></div><hr>
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