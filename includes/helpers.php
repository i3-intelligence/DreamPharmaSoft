<?php
function esc($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>