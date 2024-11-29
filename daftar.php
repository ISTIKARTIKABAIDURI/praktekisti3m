<?php 
include 'db_koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan input dari form
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jk = $_POST['jk'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jurusan = $_POST['jurusan'];
    $minat = implode(", ", $_POST['minat']);
    
    // Penanganan upload gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($gambar);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file gambar
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $maxSize = 5 * 1024 * 1024; // 5 MB

    if (in_array($imageFileType, $allowedTypes) && $_FILES['gambar']['size'] <= $maxSize) {
        // Memindahkan file gambar ke folder tujuan
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Query dengan prepared statement
            $sql = "INSERT INTO tbmahasiswa (nama, alamat, jk, tgl_lahir, jurusan, minat, gambar)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            // Menyiapkan statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $nama, $alamat, $jk, $tgl_lahir, $jurusan, $minat, $gambar);

            // Menjalankan query
            if ($stmt->execute()) {
                echo "Pendaftaran berhasil!";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Menutup statement
            $stmt->close();
        } else {
            echo "Gagal mengunggah file.";
        }
    } else {
        echo "File tidak valid atau terlalu besar. Pastikan file berupa JPG, JPEG, PNG, atau GIF dan ukuran tidak lebih dari 5MB.";
    }
}

$conn->close();
?>
