<?php
 
include('koneksi.php');
 
$username     = $_POST['username']; 
$password    = $_POST['password']; 
 
if(!empty($username) && !empty($password)){
 
    $sqlCheck = "SELECT COUNT(*) FROM tb_user WHERE username='$username' AND password='$password' AND role_id='2'";
    $queryCheck = mysqli_query($conn,$sqlCheck);
    $hasilCheck = mysqli_fetch_array($queryCheck);
    if($hasilCheck[0] == 1){
            $data['status'] = true;
            $data['result'] = "Berhasil";

    }else{
        $data['status'] = false;
        $data['result'] = "Gagal, Login";
    }
}
else{
    $data['status'] = false;
    $data['result'] = "Gagal, Username Atau Password Tidak Boleh Kosong!";
}
 
print_r(json_encode($data));
 
?>