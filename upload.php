<?php
if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 1. VALIDASI: Struktur Foto Asli
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check === false) {
        echo "<script>alert('Maaf, berkas yang Anda pilih bukan foto valid.'); window.location.href='index.html';</script>";
        $uploadOk = 0;
    }

    // 2. VALIDASI: Batasan Ukuran Maksimal 2MB (2.000.000 byte)
    if ($uploadOk == 1 && $_FILES["fileToUpload"]["size"] > 2000000) {
        echo "<script>alert('Maaf, ukuran berkas melebihi batas maksimal 2MB.'); window.location.href='index.html';</script>";
        $uploadOk = 0;
    }

    // 3. VALIDASI: Ekstensi
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    if($uploadOk == 1 && !in_array($imageFileType, $allowed_extensions)) {
        echo "<script>alert('Maaf, hanya format JPG, JPEG, PNG, & GIF yang diizinkan.'); window.location.href='index.html';</script>";
        $uploadOk = 0;
    }

    // 4. VALIDASI: Cek Duplikasi Nama File
    if ($uploadOk == 1 && file_exists($target_file)) {
        echo "<script>alert('Maaf, berkas dengan nama tersebut sudah tersimpan di server.'); window.location.href='index.html';</script>";
        $uploadOk = 0;
    }

    // Eksekusi Pemindahan File
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<script>alert('Berkas berhasil diunggah dengan aman.'); window.location.href='files.php';</script>";
        } else {
            echo "<script>alert('Maaf, terjadi kesalahan sistem saat mengunggah berkas.'); window.location.href='index.html';</script>";
        }
    }
} else {
    header("Location: index.html");
}
?>