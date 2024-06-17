<?php
require("koneksi.php");

if (isset($_POST["submit"])) {
    $judul = $_POST["judul"];
    $deskripsi = $_POST["deskripsi"];
    $tanggal = $_POST["tanggal"];
    $pembuat_berita = $row["username"];

    if ($_FILES["image"]["error"] == 4) {
        echo "<script> alert('Image Does Not Exist'); </script>";
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script> alert('Invalid Image Extension'); </script>";
        } elseif ($fileSize > 100000) {
            echo "<script> alert('Image Size Is Too Large'); </script>";
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;
            move_uploaded_file($tmpName, 'img/' . $newImageName);

            $query = "INSERT INTO berita (judul, Gambar, deskripsi, tanggal_pembuatan, pembuat_berita) VALUES (?, ?, ?, ?, ?)";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("sssss", $judul, $newImageName, $deskripsi, $tanggal, $pembuat_berita);
            if ($stmt->execute()) {
                echo "<script>
                    alert('Successfully Added');
                    document.location.href = 'admin.php';
                </script>";
            } else {
                echo "<script> alert('Failed to add news'); </script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Upload Berita</h1>
    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <label for="judul">Judul : </label><br>
        <input type="text" name="judul" id="judul" required><br>
        <label for="pembuat_berita">Pembuat Berita</label><br>
        <input type="text" name="pembuat_berita" id="pembuat_berita" value="<?php echo htmlspecialchars($row['username']); ?>" readonly><br>
        <label for="image">Image : </label><br>
        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png"><br><br>
        <label for="deskripsi">Deskripsi</label><br>
        <textarea name="deskripsi" id="deskripsi" required></textarea><br>
        <label for="tanggal">Tanggal</label><br>
        <input type="datetime-local" name="tanggal" id="tanggal" required><br><br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>