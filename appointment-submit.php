<?php
// Load PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // reCAPTCHA v3 Secret Key
    $secret_key = '6LePvakqAAAAABbJrF4OU9zghlvMOI-7Gj-ERda_';
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
    $recaptcha_verify_url = "https://www.google.com/recaptcha/api/siteverify";

    // Validate reCAPTCHA
    $response = file_get_contents("$recaptcha_verify_url?secret=$secret_key&response=$recaptcha_response");
    $response_data = json_decode($response);

    if (!$response_data->success || $response_data->score < 0.5) {
        error_log("reCAPTCHA failed: " . json_encode($response_data));
        header('Location: failed.php');
        exit;
    }

    // Sanitize and validate form inputs
    $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['location'] ?? '', FILTER_SANITIZE_STRING);
    $date = filter_var($_POST['date'] ?? '', FILTER_SANITIZE_STRING);
    $reason = filter_var($_POST['reasonSelect'] ?? '', FILTER_SANITIZE_STRING);
    $otherReason = filter_var($_POST['other'] ?? '', FILTER_SANITIZE_STRING);

    // Determine the reason text
    if ($reason === '3' && !empty($otherReason)) {
        $reason_text = "Other Specific Reason: $otherReason";
    } elseif ($reason === '1') {
        $reason_text = 'Routine Checkup';
    } elseif ($reason === '2') {
        $reason_text = 'New Patient Visit';
    } else {
        $reason_text = 'Not Specified';
    }

    if (empty($name) || empty($email) || empty($phone) || empty($date)) {
        error_log("Validation failed: Missing required fields.");
        header('Location: failed.php');
        exit;
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'appointment@smilestory.online';
        $mail->Password = 'Smile@appointment25';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email to Admin
        $mail->setFrom('appointment@smilestory.online', 'Smile Story Appointment');
        $mail->addAddress('appointment@smilestory.online');

        $mail->isHTML(true);
        $mail->Subject = 'New Appointment Request';
        $mail->Body = "
            <h3 style='font-family: \"Poppins\", \"DM Sans\", Arial, sans-serif;'>New Appointment Request</h3>
            <p style='font-family: \"Poppins\", \"DM Sans\", Arial, sans-serif;'>Here are the details of the latest appointment request:</p>
            <table style='border: 1px solid #ddd; border-collapse: collapse; width: 100%; font-family: \"Poppins\", \"DM Sans\", Arial, sans-serif;'>
                <tr>
                    <th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Field</th>
                    <th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Details</th>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Name</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>$name</td>
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
                    <td style='border: 1px solid #ddd; padding: 8px;'>Date</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>$date</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Reason</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>$reason_text</td>
                </tr>
            </table>
            <p style='font-family: \"Poppins\", \"DM Sans\", Arial, sans-serif;'>Please review and follow up accordingly.</p>
        ";

        $mail->send();

        // Send confirmation email to user
        $mail->clearAddresses();
        $mail->addAddress($email);

        $mail->Subject = 'Thank You for Booking an Appointment!';
        $mail->Body = "
            <div style='font-family: \"Poppins\", \"DM Sans\", Arial, sans-serif; padding: 20px; background-color: #f9f9f9; max-width: 600px; margin: 0 auto;'>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@400;500;700&display=swap');
                </style>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='https://smilestory.online/images/logo.png' alt='Smile Story Logo' style='max-width: 150px;'>
                </div>
                <h2 style='color: #2d89ef; text-align: center;'>Thank You for Booking an Appointment!</h2>
                <p style='text-align: center;'>Dear $name,</p>
                <p style='text-align: center;'>We are delighted to confirm your appointment at Smile Story Dental Care. Here are the details:</p>
                <table style='border: 1px solid #ddd; border-collapse: collapse; margin: 0 auto; width: 80%;'>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'>Date</td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$date</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'>Reason</td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$reason_text</td>
                    </tr>
                </table>
                <p style='text-align: center;'>If you have any questions or need to reschedule, feel free to contact us.</p>
                <div style='text-align: center; margin: 20px;'>
                    <a href='tel:+919674123910' style='display: inline-block; background-color: #2d89ef; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 16px;'>Call Now: +91-9674123910</a>
                </div>
                <p style='text-align: center;'>We look forward to seeing you soon!</p>
                <p style='text-align: center;'>Warm regards,</p>
                <p style='text-align: center;'><strong>The Smile Story Team</strong></p>
                <footer style='margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; text-align: center; font-size: 12px; color: #666;'>
                    <p>&copy; 2024 Smile Story Dental Care. All rights reserved.</p>
                    <p><a href='https://smilestory.online' style='color: #2d89ef; text-decoration: none;'>www.smilestory.online</a></p>
                </footer>
            </div>
        ";

        $mail->send();

        // Redirect to success page
        header('Location: success.php');
        exit;

    } catch (Exception $e) {
        // Log the error and redirect to failed page
        error_log("PHPMailer Exception: " . $e->getMessage());
        header('Location: failed.php');
        exit;
    }
} else {
    // Invalid request method
    error_log("Invalid request method.");
    header('Location: failed.php');
    exit;
}
?>
