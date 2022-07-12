<?php
 
include('koneksi.php');
 
$merk_model       = $_POST['merk_model']; 
$jenis    = $_POST['jenis']; 
$tahun     = $_POST['tahun'];
$jumlah      = $_POST['jumlah'];
$id_buku    = $_POST['id_buku']; 

 
if(!empty($merk_model) && !empty($jenis) && !empty($tahun) && !empty($jumlah) && !empty($id_buku)){
 
    $sql = "UPDATE tb_buku set merk_model='$merk_model', jenis='$jenis', tahun='$tahun', jumlah='$jumlah' WHERE id_buku='$id_buku'";
 
    $query = mysqli_query($conn,$sql);
 
    if(mysqli_affected_rows($conn) > 0){
        $data['status'] = true;
        $data['result'] = "Berhasil";
    }else{
        $data['status'] = false;
        $data['result'] = "Gagal";
    }
 
}else{
    $data['status'] = false;
    $data['result'] = "Gagal, Data Tidak Boleh Kosong!";
}
 
 
print_r(json_encode($data));
 
 
 
 
?>