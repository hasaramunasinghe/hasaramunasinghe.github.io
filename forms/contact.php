<?php
/**
 * Requires the "PHP Email Form" library
 * The "PHP Email Form" library is available only in the pro version of the template
 * The library should be uploaded to: vendor/php-email-form/php-email-form.php
 * For more info and help: https://bootstrapmade.com/php-email-form/
 */

// Replace with your actual receiving email address
$receiving_email_address = 'hasaramunasinghe@gmail.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;
$contact->to = $receiving_email_address;

// Input Validation & Sanitization
if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message'])) {
    $contact->from_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $contact->from_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $contact->subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    
    if (!$contact->from_email) {
        die('Invalid email format');
    }
} else {
    die('All fields are required.');
}

// Honeypot Spam Protection
if (!empty($_POST['honeypot'])) {
    die('Spam detected! Submission blocked.');
}

// Optional: Include Phone Number
if (isset($_POST['phone']) && !empty($_POST['phone'])) {
    $contact->add_message(filter_var($_POST['phone'], FILTER_SANITIZE_STRING), 'Phone');
}

// Add Message Content
$contact->add_message($_POST['name'], 'From');
$contact->add_message($_POST['email'], 'Email');
$contact->add_message($_POST['message'], 'Message', 10);

// Enable SMTP (Uncomment and configure)
$contact->smtp = array(
    'host' => 'smtp.example.com', // Your SMTP host
    'username' => 'your_smtp_username',
    'password' => 'your_smtp_password',
    'port' => '587', // Use 465 for SSL, 587 for TLS
    'encryption' => 'tls' // Use 'ssl' if required
);

// Google reCAPTCHA v3 (Uncomment and set keys)
$contact->recaptcha_secret_key = 'your_recaptcha_secret_key';
$recaptcha_response = $_POST['recaptcha-response'] ?? '';

if (!empty($recaptcha_response)) {
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = [
        'secret' => $contact->recaptcha_secret_key,
        'response' => $recaptcha_response,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $recaptcha_options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptcha_data)
        ]
    ];

    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_json = json_decode($recaptcha_result, true);

    if (!$recaptcha_json['success'] || $recaptcha_json['score'] < 0.5) {
        die('reCAPTCHA verification failed. Please try again.');
    }
}

echo $contact->send();
?>
