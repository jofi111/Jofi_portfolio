<?php
// Check if the request is coming from an AJAX call
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $name = isset($_POST['name']) ? filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $subject = isset($_POST['subject']) ? filter_var(trim($_POST['subject']), FILTER_SANITIZE_STRING) : '';
    $message = isset($_POST['message']) ? filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING) : '';
    // Validating input data
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Validation failed. Please fill all fields with valid information. / Prosím vyplňte správně všechna požadovaná pole.']);
        exit;
    }
    // Preparing email
    $to = 'jofi1@seznam.cz';
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    // Sending email
    if (!mail($to, $subject, "Name: $name\nEmail: $email\nMessage: $message", $headers)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email. Please send me a message on reach@jofi.wz.cz / Odeslání se nezdařilo. Prosím napište mi zprávu na reach@jofi.wz.cz']);
        exit;
    }
    // If everything is successful
    echo json_encode(['status' => 'success', 'message' => 'Message received successfully :o) Thank you! / Zpráva úspěšně přijata :o) Děkuji!']);

} else {
    // Not an AJAX request
    echo json_encode(['status' => 'error', 'message' => 'Some technical issue is going on. Please send me a message on reach@jofi.wz.cz / Vyskytl se technický problém. Prosím napište mi zprávu na reach@jofi.wz.cz']);
}
?>
