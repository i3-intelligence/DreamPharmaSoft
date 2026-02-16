<?php
//test telegram bot
$telegram_apiToken = "7958922851:AAGjE8lqbYQm1Nime_AsdUON22-1PIdSVD8";
$telegram_chatID = "-5108002623";
$telegram_message = "This is a test message from Telegram Bot.";
$telegram_url = "https://api.telegram.org/bot$telegram_apiToken/sendMessage?chat_id=$telegram_chatID&text=".urlencode($telegram_message);
$telegram_ch = curl_init();
curl_setopt($telegram_ch, CURLOPT_URL, $telegram_url);
curl_setopt($telegram_ch, CURLOPT_RETURNTRANSFER, true);
$telegram_response = curl_exec($telegram_ch);
// curl_close($telegram_ch);
print_r($telegram_response);
?>