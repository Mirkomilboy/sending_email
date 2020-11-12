<?php
    // Message variables
    $msg = '';
    $msgClass = '';

    // Check for Submit
    if(filter_has_var(INPUT_POST, 'submit')) {
        // Get Form Data
        $name = htmlspecialchars($_POST["name"]);
        $email = htmlspecialchars($_POST["email"]);
        $message = htmlspecialchars($_POST["message"]);

        // Check required fields
        if(!empty($name) && !empty($email) && !empty($message)) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $msg = 'Please, use a valid email';
                $msgClass = 'alert-danger';
            } else {
                $toEmail = 'msadirov1997@gmail.com';
                $subject = 'Contact Request Form ' . $name;
                $body = '<h2>Contact Request</h2>
                        <h4>Name</h4><p>'.$name.'</p>
                        <h4>Email</h4><p>'.$email.'</p>
                        <h4>Message</h4><p>'.$message.'</p>
                ';

                // Email Headers
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers.= "Content-Type:text/html;charset=UTF-8" . "\r\n";

                // Additional header
                $headers .= "From: " . $name. "<".$email.">" . "\r\n";

                if(mail($toEmail, $subject, $body, $headers)) {
                    // Email sent
                    $msg = 'Your mail has been sent';
                    $msgClass = 'alert-success';
                } else {
                    $msg = 'Your mail was not sent';
                    $msgClass = 'alert-danger';
                }
            }
        } else {
            $msg = 'Please, fill in all fields';
            $msgClass = 'alert-danger';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inc/bootstrap.min.css">
    <title>About Us</title>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a href="index.php" class="navbar-brand">My Website</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php if($msg != ''): ?>
            <div class="alert <?php echo $msgClass; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">Message</label>
                <textarea name="message" id="" cols="30" rows="10" class="form-control">
                    <?php echo isset($_POST['message']) ? $message : ''; ?>
                </textarea>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>