<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $path = "backups/" . $file;
    if (file_exists($path)) {
        unlink($path);
    }
}
header("Location: Index.php"); // or wherever your template is
