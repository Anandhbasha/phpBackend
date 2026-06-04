<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
try {

    $input = json_decode(file_get_contents("php://input"), true);

    $formData = $input['formData'];
    $cartItem = $input['cartItem'];
    $total = $input['total'];
    $paymentType = $input['paymentType'];

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = $_ENV['EMAIL_USER'];
    $mail->Password = $_ENV['EMAIL_PASS'];

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom(
        $_ENV['EMAIL_USER'],
        'Lakshmi Law House'
    );

    $mail->addAddress($formData['mail']);
    $mail->addCC($_ENV['EMAIL_USER']);

    $mail->isHTML(true);
    $mail->Subject = "Lakshmi Law House - Order Confirmation";

    $mail->Body = "
        <h2>Order Confirmed ✅</h2>
        <p>Hello {$formData['firstname']}</p>
        <p>Total Amount : ₹{$total}</p>
        <p>Payment Type : {$paymentType}</p>
    ";

    $mail->send();

    echo json_encode([
        "success" => true
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}



