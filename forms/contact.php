<?php
// =========================================================================
// Simple PHP Email Form Processor - For Free BootstrapMade Templates
// This version uses standard PHP mail() function and does NOT require the Pro Library
// =========================================================================

// 1. RECEIVING EMAIL ADDRESS (THIS IS THE ONLY LINE YOU MUST CHANGE)
// -------------------------------------------------------------------------
$receiving_email_address = 'hiranvbandara@gmail.com'; 
// -------------------------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if all required fields are present
    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['subject']) || !isset($_POST['message'])) {
        http_response_code(400);
        die("400 Bad Request: Missing fields.");
    }

    $name = strip_tags(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST['subject']));
    $message = trim($_POST['message']);

    // Check for valid email and non-empty fields
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        die("400 Bad Request: Invalid input.");
    }

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    
    // Optional Phone field (as seen in your original structure)
    if (isset($_POST['phone']) && !empty($_POST['phone'])) {
        $phone = strip_tags(trim($_POST['phone']));
        $email_content .= "Phone: $phone\n";
    }

    $email_content .= "Message:\n$message\n";

    // Build the email headers
    $email_headers = "From: " . $name . " <" . $email . ">\r\n";
    $email_headers .= "Reply-To: " . $email . "\r\n";
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-Type: text/plain; charset=utf-8\r\n";


    // Send the email
    if (mail($receiving_email_address, "Portfolio Contact: " . $subject, $email_content, $email_headers)) {
        // Success
        echo "OK";
    } else {
        // Failure
        http_response_code(500);
        echo "Something went wrong, and we couldn't send your message.";
    }

} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}

?>