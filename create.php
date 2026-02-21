<?php
session_start();
include "db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    // This handles special characters so your posts actually save now
    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: index.php");
        exit();
    } else {
        $message = "<span style='color: #e74c3c;'>Error: " . $stmt->error . "</span>";
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post | Blog App</title>
    <link rel="stylesheet" href="style.css">
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
                <input type="text" name="title" placeholder="Enter title..." required>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" placeholder="Write content..." required></textarea>
            </div>
            <button type="submit" class="btn-submit">Publish Post</button>
        </form>
        <div class="message"><?php echo $message; ?></div>
    </div>
</div>

</body>
</html>