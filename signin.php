<?php
include "koneksi.php";
if(isset($_POST["submit"])){
    $username= $_POST["username"];
    $email= $_POST["email"];
    $password= $_POST["password"];
    $cek= mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username='$username' OR email ='$email'");
    if(mysqli_num_rows($cek)>0){
        echo "
        <script>
            alert('Username atau Email sudah terpakai');        
        </script>
        ";
    }
    else{
       $query =$koneksi->query("INSERT INTO tb_user (username,email,password) VALUES('$username','$email','$password')");
       echo "
        <script>
            alert('Pendaftaran Berhasil');        
        </script>
        ";
        header("location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container2">
    <form class="form" action=""method="post" autocomplete="off">
        <h1>Daftar</h1>
        <label for="username">Nama:</label><br>
        <input type="text" name="username" id="username" required value=""><br>

        <label for="email">Email:</label><br>
        <input type="text" name="email" id="email" required value=""><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required value=""><br>
        <button type="submit" name="submit">Sign In</button>
        <br>
        <br>
        <a>Sudah memiliki akun?</a>
        <a href="login.php">Masuk</a>
    </form>
    </div>
</body>
</html>