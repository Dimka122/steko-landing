<?php

// Включаем отображение ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Проверяем наличие autoload.php
if (!file_exists('vendor/autoload.php')) {
    echo json_encode(['status' => 'error', 'message' => 'vendor/autoload.php не найден']);
    exit;
}

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $name = htmlspecialchars($data['name']);
    $phone = htmlspecialchars($data['phone']);
    $message = htmlspecialchars($data['message']);
    
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dima7dimka@gmail.com'; // Ваш Gmail
        $mail->Password = 'sygzkkcognyehlef';    // Пароль приложения
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('dima7dimka@gmail.com', 'steko-landing');
        $mail->addAddress('dima7dimka@gmail.com'); // Получатель

        $mail->isHTML(true);
        $mail->Subject = 'Заявка на изготовление от Steko';
        $mail->Body = "Имя: $name<br>Телефон: $phone<br>Сообщение: $message";
        $mail->AltBody = "Имя: $name\nТелефон: $phone\nСообщение: $message";

        $mail->send();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Неверный метод']);
}
?>