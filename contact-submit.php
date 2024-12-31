<?php
// Load PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $secret_key = '6LePvakqAAAAABbJrF4OU9zghlvMOI-7Gj-ERda_';
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
    $recaptcha_verify_url = "https://www.google.com/recaptcha/api/siteverify";


    $response = file_get_contents("$recaptcha_verify_url?secret=$secret_key&response=$recaptcha_response");
    $response_data = json_decode($response);

    if (!$response_data->success || $response_data->score < 0.5) {
        error_log("reCAPTCHA failed: " . json_encode($response_data));
        header('Location: failed.php');
        exit;
    }

    $fullname = filter_var($_POST['fullname'] ?? '', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_STRING);

    if (empty($fullname) || empty($email) || empty($phone)) {
        error_log("Validation failed: Missing required fields.");
        header('Location: failed.php');
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@smilestory.online';
        $mail->Password = 'Con@2025Story';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('contact@smilestory.online', 'Smile Story');
        $mail->addAddress('contact@smilestory.online');

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "
            <h3>New Inquiry Received</h3>
            <p>Here are the details of the latest contact form submission:</p>
            <table style='border: 1px solid #ddd; border-collapse: collapse; width: 100%;'>
                <tr>
                    <th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Field</th>
                    <th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Details</th>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Name</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>$fullname</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Email</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>$email</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Phone</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>$phone</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Message</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>$message</td>
                </tr>
            </table>
            <p>Please review and follow up accordingly.</p>
        ";

        $mail->send();

        $mail->clearAddresses();
        $mail->addAddress($email);

        $mail->Subject = 'Thank You for Contacting Smile Story!';
        $mail->Body = "
            <div style='font-family:  \"Poppins\", \"DM Sans\", sans-serif; padding: 20px; background-color: #f9f9f9; max-width: 600px; margin: 0 auto;'>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600&family=Poppins:wght@400;600&display=swap');
                </style>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='https://smilestory.online/images/logo.png' alt='Smile Story Logo' style='max-width: 150px;'>
                </div>
                <h2 style='color: #2d89ef; text-align: center;'>Thank You for Reaching Out to Smile Story!</h2>
                <p style='text-align: center;'>Dear $fullname,</p>
                <p style='text-align: center;'>We are thrilled to receive your inquiry. At Smile Story Dental Care, we are committed to providing exceptional dental services to ensure your satisfaction and well-being. A representative from our team will get in touch with you shortly to assist you with your dental care needs.</p>
                <p style='text-align: center;'>In the meantime, feel free to explore our website or call us directly for any urgent questions.</p>
                <div style='text-align: center; margin: 20px;'>
                    <a href='tel:+919674123910' style='display: inline-block; background-color: #2d89ef; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 20px;'>Call Now</a>
                </div>
                <p style='text-align: center;'>We look forward to helping you achieve a healthy and confident smile!</p>
                <p style='text-align: center;'>Warm regards,</p>
                <p style='text-align: center;'><strong>The Smile Story Team</strong></p>
                <footer style='margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; text-align: center; font-size: 12px; color: #666;'>
                    <p>&copy; 2024 Smile Story Dental Care. All rights reserved.</p>
                    <p><a href='https://smilestory.online' style='color: #2d89ef; text-decoration: none;'>www.smilestory.online</a></p>
                </footer>
            </div>
        ";

        $mail->send();

        header('Location: success.php');
        exit;

    } catch (Exception $e) {
        error_log("PHPMailer Exception: " . $e->getMessage());
        header('Location: failed.php');
        exit;
    }
} else {
    error_log("Invalid request method.");
    header('Location: failed.php');
    exit;
}
?>
