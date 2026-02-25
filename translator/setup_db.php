<?php
include '../admin/config/Database.php';

try {
    // Create the translations table
    $sql = "CREATE TABLE IF NOT EXISTS `app_translations` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `page` VARCHAR(100) NOT NULL,
        `translation_key` VARCHAR(255) NOT NULL,
        `en` TEXT NOT NULL,
        `bn` TEXT NOT NULL,
        UNIQUE KEY `unique_translation` (`page`, `translation_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $conn->exec($sql);
    echo "Table `app_translations` created successfully.\n";

    // Initial seed data for Medicine View
    $translations = [
        ['MedicineList', 'SL', 'SL', 'ক্রমিক নং'],
        ['MedicineList', 'Medicine Name', 'Medicine Name', 'ওষুধের নাম'],
        ['MedicineList', 'Purchase Price', 'Purchase Price', 'ক্রয়মূল্য'],
        ['MedicineList', 'Unit Quantity', 'Unit Quantity', 'একক পরিমাণ'],
        ['MedicineList', 'Sales Price', 'Sales Price', 'বিক্রয় মূল্য'],
        ['MedicineList', 'Company', 'Company', 'কোম্পানি'],
        ['MedicineList', 'Generic Name', 'Generic Name', 'জেনেরিক নাম'],
        ['MedicineList', 'Status', 'Status', 'অবস্থা'],
        ['MedicineList', 'Update', 'Update', 'হালনাগাদ'],
        ['Header', 'Home', 'Home', 'হোম'],
        ['Header', 'Added Menu', 'Added Menu', 'সংযুক্ত মেনু'],
        ['Header', 'Medicine View', 'Medicine View', 'ওষুধ প্রদর্শন'],
        ['General', 'Search', 'Search', 'অনুসন্ধান করুন'],
        ['General', 'entries', 'entries', 'এন্ট্রি'],
        ['General', 'Showing', 'Showing', 'দেখানো হচ্ছে'],
        ['General', 'to', 'to', 'থেকে'],
        ['General', 'of', 'of', 'এর'],
        ['General', 'Previous', 'Previous', 'পূর্ববর্তী'],
        ['General', 'Next', 'Next', 'পরবর্তী']
    ];

    $stmt = $conn->prepare("INSERT IGNORE INTO `app_translations` (`page`, `translation_key`, `en`, `bn`) VALUES (?, ?, ?, ?)");
    
    foreach ($translations as $row) {
        $stmt->execute($row);
    }
    
    echo "Initial translations seeded successfully.\n";

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
