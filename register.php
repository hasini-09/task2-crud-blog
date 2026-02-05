<?php
include "db.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $special   = preg_match('@[^\w]@', $password);

    if(!$uppercase || !$lowercase || !$number || !$special || strlen($password) < 8) {
        $message = "<span style='color: #e74c3c;'>Password must be 8+ chars with uppercase, number, and special char.</span>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            $message = "<span style='color: #2ecc71;'>Registration successful!</span>";
        } else {
            $message = "<span style='color: #e74c3c;'>Error: " . $conn->error . "</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Us | Register</title>
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
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 { color: #333; margin-bottom: 1.5rem; }
        .form-group { text-align: left; margin-bottom: 1rem; position: relative; }
        label { display: block; margin-bottom: 5px; color: #666; font-weight: 600; }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 8px;
            transition: border-color 0.3s;
        }

        input:focus { border-color: #764ba2; outline: none; }

        /* Style for the Hide/Unhide button */
        .toggle-btn {
            position: absolute;
            right: 10px;
            top: 35px;
            background: none;
            border: none;
            color: #764ba2;
            cursor: pointer;
            font-size: 0.8rem;
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

        button.submit-btn:hover { background: #5a3782; }
        .message { margin-top: 1rem; font-weight: bold; font-size: 0.85rem; }
        .footer-link { margin-top: 1.5rem; font-size: 0.9rem; }
        a { color: #764ba2; text-decoration: none; font-weight: bold; }
        .hint { font-size: 0.75rem; color: #888; margin-top: 5px; display: block; }
    </style>
</head>
<body>

<div class="container">
    <h2>Create Account</h2>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" id="passwordField"
                   placeholder="Enter password" 
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&]).{8,}" 
                   required>
            <button type="button" class="toggle-btn" onclick="togglePassword()">SHOW</button>
            <span class="hint">Min. 8 chars, 1 Uppercase, 1 Number, 1 Special Symbol</span>
        </div>

        <button type="submit" class="submit-btn">Register Now</button>
    </form>

    <div class="message"><?php echo $message; ?></div>

    <div class="footer-link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('passwordField');
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