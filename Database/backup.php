<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Dhaka');
$host = '127.0.0.1'; // Use IP, not 'localhost'
$port = 3306;         // Your new MySQL port
$user = 'root';
$pass = '';           // empty password
$db = 'nuralam_pharma';

$backupDir = __DIR__ . '/backups';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0755, true);
}

// Path to mysqldump.exe (use forward slashes)
$mysqldump = 'E:/Server/mysql/bin/mysqldump.exe';

$filename = $backupDir . '/' . $db . '_backup_' . date('d-m-y--h.iA') . '.sql';

// Include port with -P flag
$cmd = "\"$mysqldump\" -h $host -P $port -u $user " . ($pass === '' ? '' : "-p$pass ") . "$db > " . escapeshellarg($filename);

// Execute backup
exec($cmd, $output, $result);

if ($result === 0) {
    echo json_encode(['status' => 'success', 'message' => 'Backup completed successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Backup failed.', 'output' => $output]);
}
