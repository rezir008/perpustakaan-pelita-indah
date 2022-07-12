<?php
 
include('koneksi.php');
 
$merk_model       = $_POST['merk_model']; 
$jenis    = $_POST['jenis']; 
$tahun     = $_POST['tahun'];
$jumlah      = $_POST['jumlah'];
 
if(!empty($merk_model) && !empty($jenis) && !empty($tahun) && !empty($jumlah)){
 
    $sqlCheck = "SELECT COUNT(*) FROM tb_buku WHERE merk_model='$merk_model' AND jenis='$jenis' AND tahun='$tahun'";
    $queryCheck = mysqli_query($conn,$sqlCheck);
    $hasilCheck = mysqli_fetch_array($queryCheck);
    if($hasilCheck[0] == 0){
        $sql = "INSERT INTO tb_buku (merk_model, jenis, tahun, jumlah) VALUES('$merk_model','$jenis','$tahun','$jumlah')";
 
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
        $data['result'] = "Gagal, Data Sudah Ada";
    }
}
else{
    $data['status'] = false;
    $data['result'] = "Gagal, Data Tidak Boleh Kosong!";
}
 
print_r(json_encode($data));
 
?>