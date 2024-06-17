<?php
include "koneksi.php";
$_SESSION=[];
session_unset();
session_destroy();
header("location: login.php");
?>