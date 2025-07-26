<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$filename = basename($data['file']);
$filepath = __DIR__ . "/backups/$filename";

if (!file_exists($filepath)) {
    echo json_encode(['status' => 'error', 'message' => 'SQL file not found.']);
    exit;
}

$host = 'localhost';
$port = 3306;  // Update if needed
$user = 'root';
$pass = '';   // empty password
$db = 'nuralam_pharma';

$mysql = 'E:/Server/mysql/bin/mysql.exe';

// Create temp config file with credentials
$tempCnf = tempnam(sys_get_temp_dir(), 'mycnf');
file_put_contents($tempCnf, "[client]\nuser=$user\npassword=$pass\nhost=$host\nport=$port\n");

$descriptorspec = [
    0 => ['pipe', 'r'], // stdin
    1 => ['pipe', 'w'], // stdout
    2 => ['pipe', 'w']  // stderr
];

// Compose command without redirection
$cmd = "\"$mysql\" --defaults-extra-file=" . escapeshellarg($tempCnf) . " " . escapeshellarg($db);

$process = proc_open($cmd, $descriptorspec, $pipes);

if (is_resource($process)) {
    // Write SQL file content to stdin
    $sqlContent = file_get_contents($filepath);
    fwrite($pipes[0], $sqlContent);
    fclose($pipes[0]);

    // Capture output and errors
    $stdout = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    $return_value = proc_close($process);

    unlink($tempCnf);

    if ($return_value === 0) {
        echo json_encode(['status' => 'success', 'message' => 'Database restored successfully.', 'output' => $stdout]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Restore failed.', 'error' => $stderr]);
    }
} else {
    unlink($tempCnf);
    echo json_encode(['status' => 'error', 'message' => 'Could not start mysql process.']);
}
