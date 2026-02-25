<?php
include '../admin/config/Database.php';

echo "Testing Translation System...\n";
echo "Current Language: " . Translate::getLang() . "\n";

$test_keys = ['SL', 'Medicine Name', 'Home', 'Non-existent Key'];

foreach ($test_keys as $key) {
    echo "Key: [$key] => Translation: [" . __($key) . "]\n";
}

echo "\nSwitching to BN (Simulated session)...\n";
$_SESSION['app_lang'] = 'bn';
Translate::init($conn, 'MedicineList');

foreach ($test_keys as $key) {
    echo "Key: [$key] => Translation: [" . __($key) . "]\n";
}
?>
