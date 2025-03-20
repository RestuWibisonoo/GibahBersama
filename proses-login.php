<?php
session_start();
include "config/koneksi.php";

$email=$_POST['email'];
$password=$_POST['password'];

$query=mysqli_query($koneksi,"SELECT * FROM users WHERE email='$email' AND password='$password'");

if (mysqli_num_rows($query)>0) {
    $_SESSION['login']='admin' ;
    echo "<script>alert('berhasil login'); location.href='home.php'</script>";
} else {
    echo "<script>alert('login gagal'); location.href='login.php'</script>";
}

?>