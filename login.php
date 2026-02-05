<?php
session_start();
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            $_SESSION["user"] = $username;
            header("Location: index.php");
            exit();
        } else {
            $message = "<span style='color: #e74c3c;'>Incorrect password.</span>";
        }
    } else {
        $message = "<span style='color: #e74c3c;'>User not found.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Blog App</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 { color: #333; margin-bottom: 0.5rem; }
        p.welcome-text { color: #777; margin-bottom: 2rem; font-size: 0.9rem; }

        .form-group { text-align: left; margin-bottom: 1.2rem; position: relative; }

        label { display: block; margin-bottom: 8px; color: #555; font-weight: 600; }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        input:focus { border-color: #764ba2; outline: none; box-shadow: 0 0 5px rgba(118, 75, 162, 0.2); }

        /* Style for the Hide/Unhide button */
        .toggle-btn {
            position: absolute;
            right: 10px;
            top: 38px; /* Adjusted for the label height */
            background: none;
            border: none;
            color: #764ba2;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: bold;
            padding: 5px;
        }

        button.submit-btn {
            width: 100%;
            padding: 12px;
            background: #764ba2;
            border: none;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }

        button.submit-btn:hover { background: #5a3782; transform: translateY(-1px); }

        .message { margin-top: 1rem; font-weight: bold; min-height: 1.2rem; }

        .footer-link { 
            margin-top: 2rem; 
            padding-top: 1rem; 
            border-top: 1px solid #eee; 
            font-size: 0.9rem; 
            color: #666;
        }
        
        a { color: #764ba2; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome Back</h2>
    <p class="welcome-text">Please enter your details to login.</p>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter your username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" id="loginPassword" placeholder="Enter your password" required>
            <button type="button" class="toggle-btn" onclick="toggleLoginPassword()">SHOW</button>
        </div>

        <button type="submit" class="submit-btn">Login</button>
    </form>

    <div class="message"><?php echo $message; ?></div>

    <div class="footer-link">
        New here? <a href="register.php">Create an account</a>
    </div>
</div>

<script>
    function toggleLoginPassword() {
        const passwordField = document.getElementById('loginPassword');
        const toggleBtn = document.querySelector('.toggle-btn');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleBtn.textContent = 'HIDE';
        } else {
            passwordField.type = 'password';
            toggleBtn.textContent = 'SHOW';
        }
    }
</script>

</body>
</html>