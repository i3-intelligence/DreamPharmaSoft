<?php
$mysqldump = "E:/Server/mysql/bin/mysqldump.exe";  // Use forward slashes or double backslashes
$host = '127.0.0.1';       // Use IP instead of localhost
$port = 3307;              // Your custom MySQL port
$user = 'root';
$pass = '';                // your DB password (empty if none)
$db = 'pharmacy';

// Create a temporary filename for test backup
$tempFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test_backup.sql';

// Compose the command
// Note: No space between -p and password, include port with -P
$cmd = "\"$mysqldump\" -h $host -P $port -u $user " . ($pass === '' ? '' : "-p$pass ") . "$db > " . escapeshellarg($tempFile) . " 2>&1";

// Execute the command
exec($cmd, $output, $return_var);

// Output results
if ($return_var === 0) {
    echo "mysqldump executed successfully.<br>";
    echo "Backup file created at: $tempFile<br>";
    echo "First 500 chars of backup file:<br>";
    echo nl2br(htmlspecialchars(substr(file_get_contents($tempFile), 0, 500)));
    // Clean up test backup file
    unlink($tempFile);
} else {
    echo "mysqldump failed to execute.<br>";
    echo "Command output:<br>";
    echo nl2br(htmlspecialchars(implode("\n", $output)));
}

// Optional: list current directory contents for debugging
exec('dir', $dirOutput, $dirReturnVar);
echo "<pre>" . htmlspecialchars(implode("\n", $dirOutput)) . "</pre>";
