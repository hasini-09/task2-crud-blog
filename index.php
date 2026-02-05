<?php
session_start();
include "db.php";

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Fetch posts
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Blog App</title>
    <style>
        /* Consistent theme with login/register */
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        body {
            background: #f4f7f6; /* Lighter background for better reading */
            margin: 0;
            padding-bottom: 50px;
        }

        /* Top Navigation Bar */
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
            margin-left: 20px;
            font-weight: 600;
            background: rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .nav-links a:hover { background: rgba(255,255,255,0.4); }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .section-title {
            color: #333;
            border-left: 5px solid #764ba2;
            padding-left: 15px;
            margin-bottom: 30px;
        }

        /* Blog Post Cards */
        .post-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            transition: transform 0.2s;
        }
        .post-card:hover { transform: translateY(-3px); }

        .post-card h4 {
            margin: 0 0 10px 0;
            color: #2d3436;
            font-size: 1.4rem;
        }

        .post-card p {
            color: #636e72;
            line-height: 1.6;
        }

        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-size: 0.85rem;
        }

        .post-date { color: #b2bec3; }

        .actions a {
            text-decoration: none;
            font-weight: bold;
            margin-left: 15px;
        }
        .edit-btn { color: #764ba2; }
        .delete-btn { color: #e74c3c; }

        .no-posts {
            text-align: center;
            background: white;
            padding: 50px;
            border-radius: 12px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["user"]); ?>!</h2>
    <div class="nav-links">
        <a href="create.php">+ Create New Post</a>
        <a href="logout.php" style="background: #e74c3c;">Logout</a>
    </div>
</div>

<div class="container">
    <h3 class="section-title">Latest Stories</h3>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="post-card">
                <h4><?php echo htmlspecialchars($row["title"]); ?></h4>
                <p><?php echo nl2br(htmlspecialchars($row["content"])); ?></p>
                
                <div class="post-meta">
                    <span class="post-date">Published on: <?php echo date("M d, Y", strtotime($row["created_at"])); ?></span>
                    <div class="actions">
                        <a href="edit.php?id=<?php echo $row["id"]; ?>" class="edit-btn">Edit</a>
                        <a href="delete.php?id=<?php echo $row["id"]; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<div class='no-posts'><h3>No posts available yet.</h3><p>Be the first to write something!</p></div>";
    }
    ?>
</div>

</body>
</html>