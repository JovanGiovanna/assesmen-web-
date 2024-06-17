<?php
include("koneksi.php");

// Check if the session username is set
if (!isset($_SESSION['username'])) {
    echo "Session not set. Please log in.";
    exit();
}

// Get the news ID from the GET request
$id = $_GET['update_id'];

// Prepare the SQL query to fetch the news by ID
$sql = "SELECT * FROM berita WHERE id='$id'";
$result = $koneksi->query($sql);

// Check if the query executed successfully and if a row is returned
if (!$result || $result->num_rows == 0) {
    echo "News not found.";
    exit();
}

//edit
$row = $result->fetch_assoc();

if ($_SESSION['username'] !== $row['pembuat_berita']) {
    echo "You do not have permission to edit this news.";
}elseif($_SESSION['username'] == $row['pembuat_berita']){
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $title = $_POST['judul'];
        $description = $_POST['deskripsi'];
        $new_image = $_FILES['image']['name'];
        $update_image = '';
        if ($new_image) {
            $target_dir = "img/";
            $target_file = $target_dir . basename($new_image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
            $update_image = ", Gambar='$new_image'";
        }
        $sql = "UPDATE berita SET judul='$title', deskripsi='$description' $update_image WHERE id='$id'";
        if ($koneksi->query($sql) === TRUE) {
            $_SESSION['success_message'] = "News updated successfully.";
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating news: " . $koneksi->error;
        }
    }
}else{
    echo "Username tidak ditemukan";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News</title>
</head>
<body>
    <div>
        <form class="flex flex-col" action="" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="judul" value="<?php echo htmlspecialchars($row['judul']); ?>" required><br>
            <label for="image" class="text-sm">Image</label>
            <input type="file" name="image" accept="image/*"><br>
            <label for="description">Description</label>
            <textarea style="resize: none;" name="deskripsi" required><?php echo htmlspecialchars($row['deskripsi']); ?></textarea><br>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>