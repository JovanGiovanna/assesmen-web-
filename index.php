
<!DOCTYPE html>
<html lang="en" dir="ltr">
  
  <head>
  <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="utf-8">
    <title>Data</title>
  </head>
  <body>
    <nav class="w-full h-28 bg-gray-900" >
    <a href="login.php" class="text-white"><svg xmlns="http://www.w3.org/2000/svg" width="3.5em" height="3.5em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2"/><path d="M4.271 18.346S6.5 15.5 12 15.5s7.73 2.846 7.73 2.846M12 12a3 3 0 1 0 0-6a3 3 0 0 0 0 6"/></g></svg></a>
    <a href="admin.php" class="text-white">Upload Dan Atur Berita</a>
    <a href="logout.php" class="text-white">logout</a>
    </nav>
    <br>
    <?php
require 'koneksi.php';
$ambil = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
while ($tampil = mysqli_fetch_array($ambil)) {
?>
<div class=" ml-12 mt-6 relative">
<h1 class=" absolute ml-96 mt-5 font-bold text-3xl  max-h-20 max-w-2xl overflow-hidden"><?php echo "$tampil[judul]" ?></h1>
<h1><?php echo "$tampil[pembuat_berita]" ?></h1>
<p><?php echo "$tampil[tanggal_pembuatan]" ?></p>
<img class=" h-56 w-80 object-cover object-center rounded-sm" src="img/<?php echo "$tampil[Gambar]"?>" alt="">
<p><?php echo "$tampil[deskripsi]" ?></p>
<button><a href="detail.php?id=<?= $tampil['id'] ?>">Read More</a></button><br>
</div>
<?php } ?>
<footer>
    <p>Made By Jovan Aditya</p>
</footer>
  </body>
</html>