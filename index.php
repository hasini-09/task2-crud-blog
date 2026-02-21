<?php
include "db.php";

$limit = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = "";
$where = "";

if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where = "WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
}

$sql = "SELECT * FROM posts $where ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);

$count_sql = "SELECT COUNT(*) as total FROM posts $where";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_posts = $count_row['total'];
$total_pages = ceil($total_posts / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Blog App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <h2>Blog App</h2>
    <div class="nav-links">
        <a href="create.php">+ Create New Post</a>
        <a href="logout.php" class="logout-btn" style="background: #e74c3c;">Logout</a>
    </div>
</div>

<div class="container">
    <div class="search-section">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search stories..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <h3 class="section-title"><?php echo $search ? "Search Results" : "Latest Stories"; ?></h3>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
            <div class="post-card">
                <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <div class="post-meta">
                    <div class="actions">
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Delete this post?')">Delete</a>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<div class='no-posts'><h3>No posts found.</h3></div>";
    }
    ?>

    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

</body>
</html>