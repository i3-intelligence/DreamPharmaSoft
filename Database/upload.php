<?php
$uploadDir = __DIR__ . '/backups/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['sqlFile'])) {
    $file = $_FILES['sqlFile'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if ($ext !== 'sql') {
        die("<script>alert('Only .sql files allowed!'); window.history.back();</script>");
    }

    $targetPath = $uploadDir . basename($file['name']);
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo "<script>alert('Upload successful.'); window.location.href = './';</script>";
    } else {
        echo "<script>alert('Upload failed.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('No file selected.'); window.history.back();</script>";
}
