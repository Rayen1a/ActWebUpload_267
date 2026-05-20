<?php
if (isset($_GET['name'])) {
    $filename = basename($_GET['name']); 
    $filepath = "uploads/" . $filename;

    if (file_exists($filepath)) {
        if (unlink($filepath)) {
            echo "<script>alert('Berkas berhasil dihapus dari server.'); window.location.href='files.php';</script>";
        } else {
            echo "<script>alert('Gagal mengeksekusi perintah hapus.'); window.location.href='files.php';</script>";
        }
    } else {
        echo "<script>alert('Berkas target tidak ditemukan.'); window.location.href='files.php';</script>";
    }
} else {
    header("Location: files.php");
}
?>