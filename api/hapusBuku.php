<?php
include('koneksi.php');
 
$id_buku = $_POST['id_buku']; 
 
if(!empty($id_buku)){
    $sql = "DELETE FROM tb_buku WHERE id_buku='$id_buku' ";
 
    $query = mysqli_query($conn,$sql);
 
    $data['status'] = true;
    $data['result'] = 'Berhasil';
}else{
    $data['status'] = false;
    $data['result'] = 'Gagal';
}
 
print_r(json_encode($data));
 
 
?>