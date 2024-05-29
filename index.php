<?php
include './config.php';
session_start();

if (isset($_POST['submit'])) {
    if (empty($_POST['email']) 
    ||  empty($_POST['username']) 
    ||  empty($_POST['password'])) {
        echo "All fields are required.";
        exit;
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    $email = $mysqli->real_escape_string($_POST['email']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $hashed_pass = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $mysqli->prepare("SELECT email FROM registrant WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Email already exists.";
        exit;
    }
    $stmt->close();

    $stmt = $mysqli->prepare("INSERT INTO registrant (email, username, password)
     VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $email, $username, $hashed_pass);
        
        if ($stmt->execute()) {
            header("Location: welcome.php?email=" . urlencode($email));
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }

    $mysqli->close();
}

session_destroy();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="bstrap.css"> -->
    <style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 300px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.container:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.form-label {
    text-align: left;
    display: block;
    font-size: 20px;
    margin-bottom: 5px;
    color: #606770;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #dddfe2;
    border-radius: 4px;
    font-size: 14px;
    margin-bottom: 10px;
    box-sizing: border-box;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus {
    border-color: #1877f2;
    box-shadow: 0 0 5px rgba(24, 119, 242, 0.5);
    outline: none;
}

.btn-primary {
    background-color: #1877f2;
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-primary:hover {
    background-color: #165db7;
    box-shadow: 0 4px 10px rgba(24, 119, 242, 0.3);
}

.btn-primary:active {
    background-color: #154a8a;
    box-shadow: 0 2px 5px rgba(24, 119, 242, 0.5);
}

.btn-primary:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(24, 119, 242, 0.7);
}

.mb-3 {
    margin-bottom: 15px;
}
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <div class="mb-3">
                <label for="Email" class="form-label">Email:</label><br>
                <input type="email" class="form-control" name="email" id="Email"><br>
            </div>

            <div class="mb-3">
                <label for="Username" class="form-label">Username:</label><br>
                <input type="text" class="form-control" name="username" id="Username"><br>
            </div>

            <div class="mb-3"> 
                <label for="Password" class="form-label">Password:</label><br>
                <input type="password" class="form-control" name="password" id="Password"><br>
                <input type="checkbox" class="form-control" name="checkbox" onclick="SeePassword()"><br>ShowPassword
            </div>

            <input type="submit" name="submit" class="btn btn-primary" value="Register"><br>
        </form>
    </div>
    <script src="password.js"></script>
</body>
</html>