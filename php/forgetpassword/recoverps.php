<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['Sendemail'])){
    $em = $sec->secure($_POST['enteredemail']);
    $data = SQLSRV_QUERY($dbcn,"SELECT * FROM SK_USER Where Email = '$em'",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
    if(SQLSRV_NUM_ROWS($data) > 0){
    $datafetch = SQLSRV_FETCH_ARRAY($data);
    $name = $datafetch['Name'];
    $us = $datafetch['username'];
    $pw = $datafetch['Realpassword'];
require './php/forgetpassword/PHPMailer/src/Exception.php';
require './php/forgetpassword/PHPMailer/src/PHPMailer.php';
require './php/forgetpassword/PHPMailer/src/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = false; //SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'abdalla20736@gmail.com';                     // SMTP username
    $mail->Password   = 'Aa3199462';                               // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('abdalla20736@gmail.com', 'Silkroad Online');
    $mail->addAddress("$em", "$name");     // Add a recipient
    $mail->addReplyTo('abdalla20736@gmail.com', 'Silkroad Online');


    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Silkroad Online Recover Password';
    $mail->Body    = "<h1>Hello $name.</h1><br><br><br>  
    <span style='font-size:16px; font-style:italic;'>This a message from your favorite game Silkroad Online<br>
    Your Username is : $us<br>
    Your Password is : $pw
    </span";
    $mail->AltBody = 'Silkroad Online Recover Password';

    $mail->send();
    moveto('?page=news&success=2');
    } catch (Exception $e) {
    moveto('?page=recoverps&failed=2');
    }
    }else{
        SwalfireApanel2("<span style='color:#fff;'>Sorry, This E-mail not found</span>","#111B2F","black");
    }
}
if(isset($_GET['failed']) && isset($_SESSION['StatusMSG'])){
    if($_GET['failed'] == 2){
        unset($_SESSION['StatusMSG']);
        SwalfireApanel2("<span style='color:#fff;'>Error, Please Try to contact with the administrator</span>","#111B2F","black");
    }
}

?>

<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>Password Recovery</span>
<form method='POST'>
<div class='forget-password-div'>
<input  type="Email" class='forget-ps-input' placeholder='Enter Your Email Address' name='enteredemail' autocomplete='OFF'>
<button name='Sendemail' class='btn-site btn-recoverps'>Send an email</button>
</form>
</div>
<html>
<head>
</head>
<body>

</body>
</html>