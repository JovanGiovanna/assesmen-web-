<?php
require("koneksi.php");

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

// Debug: print session variables
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

$id = $_SESSION["user_id"];
$hasil = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id = $id");
$row = mysqli_fetch_array($hasil);

// Handle deletion of news
if (isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"];
    $query = "DELETE FROM berita WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil dihapus.');
            document.location.href = 'admin.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data.');
            document.location.href = 'admin.php';
        </script>";
    }
}

// tambah berita
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
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Upload dan Kelola Berita</title>
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
    <br>
    <a href="upload_berita.php">Data</a>

    <h1>Data Berita</h1>
    <?php
    $hasil = mysqli_query($koneksi, "SELECT * FROM berita WHERE pembuat_berita = '" . $_SESSION["username"] . "'");

    echo "<table border='1'>
          <tr>
            <th>Judul</th>
            <th>Gambar</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Penulis</th>
            <th colspan ='2'>Aksi</th>
          </tr>";

    while ($row = mysqli_fetch_array($hasil)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
        echo "<td><img src='img/" . htmlspecialchars($row['Gambar']) . "' width='100'></td>";
        echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tanggal_pembuatan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pembuat_berita']) . "</td>";
        echo "<td><a href='?delete_id=" . $row['id'] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</a></td>";
        echo "<td><a href='edit.php?update_id=" . $row['id'] . "' onclick=\"return confirm('Apakah Anda yakin ingin update data ini?')\">Edit</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <footer>
    <p>Made By Jovan Aditya</p>
</footer>
</body>
</html>