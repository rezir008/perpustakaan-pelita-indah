<?php 
include('koneksi.php'); //jangan lupa untuk include koneksi.php 
 
$sql = "SELECT b.id_buku, b.merk_model, b.jenis, b.tahun, b.jumlah, 
        COALESCE((SELECT SUM(p.jumlah) 
        FROM tb_peminjaman_buku AS p
        WHERE p.stts_kembali = 0 AND p.id_buku = b.id_buku
        GROUP BY p.id_buku),0) AS terpinjam
        FROM tb_buku AS b
        GROUP BY b.id_buku;";
 
$query = mysqli_query($conn,$sql);
 
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_object($query)){
        $data['status'] = true;
        $data['result'][] = $row;
 
        // $data2 = respond(true, $row);
    }
}else{
    $data['status'] = false;
    $data['result'][] = "Data not Found";
}
 
print_r(json_encode($data));
 
 
?>