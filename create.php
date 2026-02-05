<?php
session_start();
include "db.php";

// Check login
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    // Security Tip: Use prepared statements to prevent SQL Injection!
    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        $message = "<span style='color: #e74c3c;'>Error: " . $conn->error . "</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post | Blog App</title>
    <style>
        /* Consistent Theme */
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        body {
            background: #f4f7f6;
            margin: 0;
            padding-bottom: 50px;
        }

        /* Navbar consistent with index.php */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar h2 { margin: 0; font-size: 1.5rem; }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            background: rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .nav-links a:hover { background: rgba(255,255,255,0.4); }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        h3 { color: #333; margin-top: 0; margin-bottom: 1.5rem; border-bottom: 2px solid #f1f2f6; padding-bottom: 10px; }

        .form-group { margin-bottom: 1.5rem; text-align: left; }

        label { display: block; margin-bottom: 8px; color: #555; font-weight: 600; }

        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus {
            border-color: #764ba2;
            outline: none;
        }

        textarea { resize: vertical; min-height: 150px; }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #764ba2;
            border: none;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-submit:hover { background: #5a3782; }

        .message { margin-top: 1rem; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

<div class="navbar">
    <h2>Blog Dashboard</h2>
    <div class="nav-links">
        <a href="index.php">← Back to Posts</a>
    </div>
</div>

<div class="container">
    <div class="form-card">
        <h3>Create New Post</h3>

        <form method="POST">
            <div class="form-group">
                <label>Post Title</label>
                <input type="text" name="title" placeholder="Enter a catchy title..." required>
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea name="content" placeholder="Share your thoughts here..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">Publish Post</button>
        </form>

        <div class="message"><?php echo $message; ?></div>
    </div>
</div>

</body>
</html>