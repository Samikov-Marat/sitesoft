<?php

try {
    if (!isset($_POST['name'])) {
        throw new Exception('Не заполнено поле Имя');
    }
    if (!isset($_POST['phone'])) {
        throw new Exception('Не заполнено поле Телефон');
    }

    $message = '';
    $message .= (new DateTime())->format('h:i:s d.m.Y') . "\n";
    $message .= 'Имя ' . $_POST['name'] . "\n";
    $message .= 'Телефон ' . $_POST['phone'] . "\n";
    $message .= 'Форма ' . $_POST['size'] . "\n";

    mail('Samikov.Marat@gmail.com, sipeconom@gmail.com', 'sipeconom: Заявка с сайта', $message, 'From: no-reply@sipeconom.ru');

    header("Location: /index.html");
    //echo "Заявка отправлена";

} catch (Exception $e) {
    header("HTTP/1.0 500 Internal Server Error", true, 500);
}
