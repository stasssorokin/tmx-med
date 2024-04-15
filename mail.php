<?php
// Подключение библиотеки
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Получение данных
$json = file_get_contents('php://input'); // Получение json строки
$data = json_decode($json, true); // Преобразование json

// Данные
$fio = $data['fio'];
$phone = $data['phone'];

// Контент письма
$title = 'Заявка с сайта'; // Название письма
$body = '<p>Имя: '.$fio.'</p>'.
        '<p>Телефон: '.$phone.'</p>';

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();

try {
  $mail->isSMTP();
  $mail->CharSet = 'UTF-8';
  $mail->SMTPAuth = true;
  $mail->setLanguage('ru', 'phpmailer/language/');


  // Настройки почты отправителя
  $mail->Host       = 'smtp.google.com'; // SMTP сервера вашей почты
  $mail->Username   = 'tmxtechninfo@gmail.com'; // Логин на почте
  $mail->Password   = 'password'; // Пароль на почте
  $mail->SMTPSecure = 'ssl';
  $mail->Port       = 465;

  $mail->setFrom('tmxtechninfo@gmail.com', 'Заявка с сайта'); // Адрес самой почты и имя отправителя

  // Получатель письма
  $mail->addAddress('s.sorokin.121@gmail.com');

  // Отправка сообщения
  $mail->isHTML(true);
  $mail->Subject = $title;
  $mail->Body = $body;

  // $mail->send('d');

  // Сообщение об успешной отправке
  echo ('Сообщение отправлено успешно!');

} catch (Exception $e) {
  header('HTTP/1.1 400 Bad Request');
  echo("Сообщение не было отправлено! Причина ошибки: {$mail->ErrorInfo}");
}
