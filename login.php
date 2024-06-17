<?php
include "koneksi.php";
if(isset($_POST["submit"])){
    $usernameemail= $_POST["usernameemail"];
    $password= $_POST["password"];
    $hasil= mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username= '$usernameemail' OR email= '$usernameemail'");
    $row = mysqli_fetch_assoc($hasil);
    if(mysqli_num_rows($hasil)>0){
        if($password== $row["password"]){
            $_SESSION["Login"]= true;
            $_SESSION["username"] = $usernameemail;
            $_SESSION["user_id"]= $row["id"];
            header("location: admin.php");
        }
        else{
            echo "
            <script>
                alert('Kata Sandi Salah');        
            </script>
        ";
        }
    }
    else{
        echo "
        <script>
            alert('Pengguna tidak terdaftar');        
        </script>
        ";
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
    <div class="container">
    <form class="form" action=""method="post" autocomplete="off">
    <h1>Masuk</h1>
        <label for="usernameemail">Nama atau Email:</label><br>
        <input type="text" name="usernameemail" id="usernameemail" required value=""><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required value=""><br>
        <button type="submit" name="submit">Masuk</button>
        <br>
        <br>
        <a>Sudah memiliki akun?</a>
        <a href="signin.php">Daftar</a>
    </form>
    </div>
</body>
</html>