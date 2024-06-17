<?php
include "koneksi.php";

$sql=mysqli_query($koneksi,"SELECT * FROM berita WHERE id='$_GET[id]'");
$ambil=mysqli_fetch_assoc($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
</head>
<body>

<!--list berita-->

 
<div class=" mt-7 ml-12">
    <h1 class=" font-bold text-4xl max-w-5xl"><?php echo "$ambil[judul]"?></h1>
    <div class=" h-2 w-11/12 bg-red-700 rounded-lg mt-2"></div>
</div>
<div class="ml-12 mt-5">
    <p class=" text-xl font-semibold"><?php echo "$ambil[pembuat_berita]"?></p>
    <p class=" text-xl font-semibold"><?php echo "$ambil[tanggal_pembuatan]"?></p>
    <img class=" w-8/12 object-cover object-center mt-5" src="img/<?php echo "$ambil[Gambar]"?>" alt="">
    <p class=" text-lg mt-5 w-10/12"><?php echo "$ambil[deskripsi]"?></p></p>
    <button><a href="index.php">Kembali</a></button>
</div>

<footer>
    <p>Made By Jovan Aditya</p>
</footer>
</body>
</html>