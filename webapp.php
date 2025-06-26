<?php
$botToken = '7475235051:AAHkWf4sW3fP8vJ2pfgOL4tHdy0XRI3CoEI';
$webAppUrl = 'https://killueaan.github.io/kleoproject/';

// Получаем последние обновления
$lastUpdateId = 0;
while (true) {
    $updates = json_decode(file_get_contents("https://api.telegram.org/bot{$botToken}/getUpdates?offset=" . ($lastUpdateId + 1)), true);

    if (isset($updates['result']) && count($updates['result']) > 0) {
        foreach ($updates['result'] as $update) {
            $lastUpdateId = $update['update_id'];

            if (isset($update['message']) && strpos($update['message']['text'], '/start') === 0) {
                $chatId = $update['message']['chat']['id'];

                $response = [
                    'chat_id' => $chatId,
                    'text' => 'Добро пожаловать, наши дорогие покупатели! Нажмите кнопку ниже, чтобы узнать информацию о нашем интернет-магазине КЛЕО.',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => 'Открыть больше информации',
                                    'web_app' => ['url' => $webAppUrl]
                                ]
                            ]
                        ]
                    ])
                ];

                sendMessage($response);
            }
        }
    }
    sleep(1);
}

function sendMessage($content)
{
    global $botToken;
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));
    curl_exec($ch);
    curl_close($ch);
}
