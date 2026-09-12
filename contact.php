<?php

function render_page($title, $body)
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/pages.css">
    <title><?php echo $title; ?></title>
</head>
<body>

    <nav class="navbar">
        <a href="index.html" class="nav-btn">Sākums</a>
        <a href="parmani.html" class="nav-btn">Par Mani</a>
        <a href="prasmes.html" class="nav-btn">Prasmes</a>
        <a href="projekti.html" class="nav-btn">Projekti</a>
    </nav>

    <div id="particles-js"></div>

    <div class="name">
        <div class="box">
            <?php echo $body; ?>
        </div>
    </div>

    <script src="particles.js"></script>
    <script src="app.js"></script>

</body>
</html>
<?php
    die();
}

if (isset($_POST['Email'])) {

    $email_to = "satansdaugter6@gmail.com";
    $email_subject = "Test Email";

    function problem($error)
    {
        $body  = '<h3 class="fcf-h3">Something went wrong</h3>';
        $body .= '<p>' . $error . '</p>';
        $body .= '<a href="kontakti.html" class="fcf-btn fcf-btn-primary fcf-btn-lg fcf-btn-block">Back to the form</a>';
        render_page('Contact us', $body);
    }


    if (
        !isset($_POST['Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Message'])
    ) {
        problem('Diemžēl radās problēma ar iesniegto veidlapu.');
    }

    $name = $_POST['Name']; 
    $email = $_POST['Email']; 
    $message = $_POST['Message']; 

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'Ievadītā e-pasta adrese nav derīga.<br>';
    }

    $string_exp = "/^[\p{L} .'-]+$/u";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'Ievadītais vārds nav derīgs.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'Ievadītā ziņa nav derīga.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Form details below.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Message: " . clean_string($message) . "\n";


    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'Content-Type: text/plain; charset=UTF-8' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);

    $body  = '<h3 class="fcf-h3">Message sent</h3>';
    $body .= '<p>Paldies, ka sazinājāties!. Drīzumā ar jums drīz sazināšos.</p>';
    $body .= '<a href="index.html" class="fcf-btn fcf-btn-primary fcf-btn-lg fcf-btn-block">Back to home</a>';
    render_page('Sazines ar mani', $body);

} else {
    header('Location: kontakti.html');
    exit();
}