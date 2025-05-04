<?php
$host = 'localhost';
$user = 'root'; // or your DB username
$pass = '';     // or your DB password
$dbName = 'pharmacy';

$backupDir = 'backups';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$timestamp = date('d-m-y__h-i-A'); // Format: 05-12-25__02-30-PM
$backupFile = $backupDir . '/' . $timestamp . '.sql';
$mysqldump = 'D:\Server\\mysql\\bin\\mysqldump.exe';

$command = "\"$mysqldump\" --user=$user --password=$pass --host=$host $dbName > \"$backupFile\"";

exec($command, $output, $result);

if ($result === 0) {
    echo json_encode(['status' => 'success', 'message' => 'Backup created successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Backup failed.']);
}
?>
