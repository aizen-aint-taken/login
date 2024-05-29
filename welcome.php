<?php

include "./config.php";


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Succesful Registration</title>
</head>
<body>
<?php
    // Check if email parameter is set in the URL
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
        echo "<p>Hello, your email is: $email</p>";
    } else {
        echo "Email not found.";
    }
    ?>
</body>
</html>