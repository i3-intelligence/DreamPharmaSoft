<?php
class Translate {
    private static $translations = [];
    private static $language = 'en';

    /**
     * Initialize the translation system
     * @param PDO $conn Database connection
     */
    public static function init($conn) {
        // Ensure session is started for language persistence
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Identify logged in user and target table
        $userId = null;
        $userTable = null;

        if (isset($_SESSION['DPS_ADMIN_SSN_ID'])) {
            $userId = $_SESSION['DPS_ADMIN_SSN_ID'];
            $userTable = 'controller_information';
        } elseif (isset($_SESSION['DPS_SHOP_SSN_ID'])) {
            $userId = $_SESSION['DPS_SHOP_SSN_ID'];
            $userTable = 'user_information';
        }

        // Handle language switching
        if (isset($_GET['lang'])) {
            $new_lang = $_GET['lang'] === 'bn' ? 'bn' : 'en';
            $_SESSION['app_lang'] = $new_lang;
            
            // If user is logged in, persist to database
            if ($userId && $userTable) {
                try {
                    $stmt = $conn->prepare("UPDATE `$userTable` SET `lang` = ? WHERE `Id` = ?");
                    $stmt->execute([$new_lang, $userId]);
                } catch (PDOException $e) {
                    // Silently fail
                }
            }
            
            // Redirect to the same page without the lang parameter to clean URL
            if (isset($_SERVER['PHP_SELF'])) {
                $url = strtok($_SERVER['REQUEST_URI'], '?');
                $params = $_GET;
                unset($params['lang']);
                if (!empty($params)) {
                    $url .= '?' . http_build_query($params);
                }
                header("Location: $url");
                exit();
            }
        }
        
        // If language not in session but user is logged in, load from DB
        if (!isset($_SESSION['app_lang']) && $userId && $userTable) {
            try {
                $stmt = $conn->prepare("SELECT `lang` FROM `$userTable` WHERE `Id` = ?");
                $stmt->execute([$userId]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user && !empty($user['lang'])) {
                    $_SESSION['app_lang'] = $user['lang'];
                }
            } catch (PDOException $e) {
                // Silently fail
            }
        }

        self::$language = $_SESSION['app_lang'] ?? 'en';

        // Fetch all translations globally
        try {
            $stmt = $conn->prepare("SELECT translation_key, en, bn FROM `app_translations`");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                self::$translations[$row['translation_key']] = $row[self::$language];
            }
        } catch (PDOException $e) {
            // Silently fail
        }
    }


    /**
     * Translate a key
     * @param string $key The key to translate
     * @return string Translated string or key if not found
     */
    public static function __($key) {
        return self::$translations[$key] ?? $key;
    }

    /**
     * Get current language
     * @return string 'en' or 'bn'
     */
    public static function getLang() {
        return self::$language;
    }
}

/**
 * Global shortcut for translation
 */
function __($key) {
    return Translate::__($key);
}
?>
