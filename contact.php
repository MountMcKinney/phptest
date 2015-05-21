<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email =  trim($_POST["email"]);
    $message =  trim($_POST["message"]);
    if ($name == "" || $email == "" || $message == "") {
      echo "You must specify a value for name.";
      exit;
    }

    foreach ($_POST as $value) {
      if(stripos($value,'Content-Type:') !== FALSE){
        echo "There was a problem with the information you entered.";
        exit;
      }
    }

    if ($_POST["address"] != "") {
      echo "Your form submission has an error.";
      exit;
    }

    require_once("inc/phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();




    if(!$mail->ValidateAddress($email)){
      echo "Please enter a vaild email";
      exit;
    }

    $email_body = "";
    $email_body = $email_body . "Name: " . $name . "<br>";
    $email_body = $email_body . "Email: " . $email . "<br>";
    $email_body = $email_body . "Message: " . $message;

    //Set who the message is to be sent from
    $mail->setFrom($email, $name);
    //Set who the message is to be sent to
    $mail->addAddress('john@mountmckinney.com', 'John McKinney');
    //Set the subject line
    $mail->Subject = 'Contact Form Submission | '.$name;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($email_body);

    //send the message, check for errors
    if (!$mail->send()) {
        echo "There was a problem sending the email: " . $mail->ErrorInfo;
        exit;
    }



    header("Location: contact.php?status=thanks");
    exit;
}
?><?php
$pageTitle = "Contact Mike";
$section = "contact";
include('inc/header.php'); ?>

	<div class="section page">

		<div class="wrapper">

            <h1>Contact</h1>

            <?php if (isset($_GET["status"]) AND $_GET["status"] == "thanks") { ?>
                <p>Thanks for the email! I&rsquo;ll be in touch shortly!</p>
            <?php } else { ?>

                <p>I&rsquo;d love to hear from you! Complete the form to send me an email.</p>

                <form method="post" action="contact.php">

                    <table>
                        <tr>
                            <th>
                                <label for="name">Name</label>
                            </th>
                            <td>
                                <input type="text" name="name" id="name">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="email">Email</label>
                            </th>
                            <td>
                                <input type="text" name="email" id="email">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="message">Message</label>
                            </th>
                            <td>
                                <textarea name="message" id="message"></textarea>
                            </td>
                        </tr>
                        <tr style="display:none">
                            <th>
                                <label for="address">Address</label>
                            </th>
                            <td>
                                <input type="text" name="address" id="address">
                                <p>Leave this field blank if you see it.</p>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" value="Send">

                </form>

            <?php } ?>

        </div>

	</div>

<?php include('inc/footer.php') ?>
