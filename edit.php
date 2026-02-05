<?php
session_start();
include "db.php";

// Check login
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Get post ID
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = $_GET["id"];
$message = "";

// Fetch post data - Security note: use prepared statements to avoid SQL injection
$sql = "SELECT * FROM posts WHERE id=$id";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

// Update post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $update = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";

    if ($conn->query($update) === TRUE) {
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
    <title>Edit Post | Blog App</title>
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
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: #f39c12; /* Distinctive Orange for Edit mode */
            outline: none;
            box-shadow: 0 0 8px rgba(243, 156, 18, 0.1);
        }

        textarea { resize: vertical; min-height: 150px; }

        .btn-update {
            width: 100%;
            padding: 14px;
            background: #f39c12; /* Orange for 'Update' action */
            border: none;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-update:hover { background: #e67e22; }

        .message { margin-top: 1rem; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

<div class="navbar">
    <h2>Blog Dashboard</h2>
    <div class="nav-links">
        <a href="index.php">← Cancel Editing</a>
    </div>
</div>

<div class="container">
    <div class="form-card">
        <h3>Edit Your Post</h3>

        <form method="POST">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>

            <button type="submit" class="btn-update">Update Post</button>
        </form>

        <div class="message"><?php echo $message; ?></div>
    </div>
</div>

</body>
</html>