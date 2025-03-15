<?php
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
        $mail->Username = 'your-email@gmail.com'; // Ваш Gmail
        $mail->Password = 'your-app-password';    // Пароль приложения
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your-email@gmail.com', 'Steko Landing');
        $mail->addAddress('info@steko.ru'); // Ваш email для заявок

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