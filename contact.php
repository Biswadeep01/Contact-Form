<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'Mail/Exception.php';
require 'Mail/PHPMailer.php';
require 'Mail/SMTP.php';

$errors = [];
$errorMessage = ' ';
$successMessage = ' ';

if (!empty($_POST))
{
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $radio = $_POST['RadioOptions'];
  $message = htmlentities($_POST['message']);

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required";
    } else {
        $name = cleanInput($name);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errors[] = "Only letters and white space allowed";
        }
    }

    // Validate phone number
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } else {
        $phone = cleanInput($phone);
        // Check if phone number is valid
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $errors[] = "Invalid phone number format";
        }
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required";
    } else {
        $email = cleanInput($email);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
    }

    if (empty($radio)) {
        $errors[] = "Choose either Feedback or Query";
    }

    if (empty($message)) {
        $errors[] = 'Message is empty';
    }
    if (!empty($errors)) {
        $allErrors = join ('<br/>', $errors);
        $errorMessage = "<p style='color: red; '>{$allErrors}</p>";
    } else {
        $emailSubject = 'New email from your contact form';
        $body = "<p>Name: {$name}</p><p>Phone: {$phone}</p><p>Email: {$email}</p><p>Option: {$radio}</p><p>Message: {$message}</p>";

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            // Configure the PHPMailer instance
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'neelendu.hajra@gmail.com';
            $mail->Password = 'xttingdjdaccotuc';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
        
            // Set the sender, recipient, subject, and body of the message 
            $mail->setFrom('neelendu.hajra@gmail.com', 'Contact Form');
            $mail->addAddress('biswadeep.mukhopadhyay00@gmail.com', 'Website');
            
            $mail->isHTML(true);
            $mail->Subject = $emailSubject;
            $mail->Body = $body;
        
            // Send the message
            $mail->send () ;
            
            $successMessage = "<div> <h1 style='color: green; text-align:center; '>Thank you for contacting us :)</h1></div>";
            echo $successMessage;
                
        } 
        catch (Exception $e) {
            $errorMessage = "<div> <h1 style='color: green; text-align:center; '>Something went wrong !<br>Try again later...</h1></div>";
            echo $errorMessage;
        }
    }
}

// Function to sanitize input data
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<script type="text/JavaScript">
 function Redirect() {
    window.history.back();
 }
//  document.write("You will be redirected to the main page in 1 seconds.");
 setTimeout(function() {
Redirect();
 }, 2500);
</script>