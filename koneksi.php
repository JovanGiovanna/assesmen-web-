<?php
session_start();
$host="localhost";
$username= "root";
$password="123";
$database="tabel_berita";

$koneksi = new mysqli($host,$username,$password,$database);
if(!$koneksi){
    die ("database tidak terkoneksi");
}

?>