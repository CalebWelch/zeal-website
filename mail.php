<?php
    
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
        $subject = strip_tags(trim($_POST["subject"]));
        $number = strip_tags(trim($_POST["number"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! Message Not Send.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "david.thach@zealitconsultants.com";

        // Set the email subject.
        $subject = "New Message from $name";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Subject: $subject\n\n";
        $email_content .= "Number: $number\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.  
		$headers = 'From: '.$name . '<' . $email.">\r\n".
		'Reply-To: '.$recipient."\r\n" .
		'X-Mailer: PHP/' . phpversion();
		echo "Made it";
		@mail($recipient, $subject, $message, $headers);  
		echo "Thank you for your message.  We will be in touch with you soon!";

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Oops! Something went wrong.";
    }
?>