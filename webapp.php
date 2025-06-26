<?php
// Конфигурация
$botToken = '7475235051:AAHkWf4sW3fP8vJ2pfgOL4tHdy0XRI3CoEI'; // Замените на токен вашего бота
$webAppUrl = 'https://yourdomain.com/path/to/webapp'; // URL вашего WebApp

// Получаем входящее обновление
$update = json_decode(file_get_contents('php://input'), true);

// Обрабатываем команду /start
if (isset($update['message']) && strpos($update['message']['text'], '/start') === 0) {
    $chatId = $update['message']['chat']['id'];

    // Создаем сообщение с кнопкой WebApp
    $response = [
        'chat_id' => $chatId,
        'text' => 'Добро пожаловать! Нажмите кнопку ниже, чтобы открыть WebApp.',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Открыть WebApp',
                        'web_app' => ['url' => $webAppUrl]
                    ]
                ]
            ]
        ])
    ];

    // Отправляем сообщение
    sendMessage($response);
}

// Функция для отправки сообщений
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

// Для вебхука (если используете этот метод)
if (!isset($update)) {
    echo 'Bot is running. Set up webhook to: ' . $_SERVER['PHP_SELF'];
}
