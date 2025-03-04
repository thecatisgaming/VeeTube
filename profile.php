<?php
include("header.php");
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$logged_in_user = $_SESSION['username'];

$username = isset($_GET['user']) ? $_GET['user'] : $logged_in_user;

$stmt = $pdo->prepare("SELECT id, username, is_admin, custom_css, created_at FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user) {
    $user_id = $user['id'];
    $is_admin = $user['is_admin'];
    $custom_css = $user['custom_css'];
    $join_date = $user['created_at'];
    $formatted_join_date = date("m/d/Y", strtotime($join_date));
} else {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_css']) && $is_admin) {
    $new_css = $_POST['custom_css'];
    $stmt = $pdo->prepare("UPDATE users SET custom_css = ? WHERE id = ?");
    $stmt->execute([$new_css, $user_id]);
    header("Location: profile.php?user=" . $username);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile: <?php echo htmlspecialchars($username); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Verdana, Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .logo {
            font-weight: bold;
            font-size: 28px;
            margin-right: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .nav-bar {
            background-color: #f1f1f1;
            padding: 5px 10px;
            border-bottom: 1px solid #ccc;
        }
        .nav-bar a {
            margin-right: 15px;
            text-decoration: none;
            color: #0000cc;
            font-size: 13px;
        }
        .profile-info {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #fdfdfd;
        }
        .custom-css-form {
            margin: 20px;
        }
        <?php echo $custom_css; ?>
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo htmlspecialchars($username); ?>
        <?php if ($is_admin): ?>
            <small class="admin-badge">Fellow Nloadian!</small>
        <?php endif; ?>
        </h1>
    </div>
    <div class="nav-bar">
        <a href="index.php">Home</a>
        <a href="videos.php">Videos</a>
        <a href="channels.php">Channels</a>
        <a href="about.php">About</a>
    </div>
    <div class="profile-info">
        <h2>Profile Information</h2>
        <p>Username: <?php echo htmlspecialchars($username); ?></p>
        <p>Join Date: <?php echo $formatted_join_date; ?></p>
    </div>
    <?php if ($logged_in_user == $username || $is_admin): ?>
        <div class="custom-css-form">
            <form method="POST" action="profile.php?user=<?php echo urlencode($username); ?>">
                <textarea name="custom_css" rows="10" cols="50" placeholder="Enter custom CSS here..."><?php echo htmlspecialchars($custom_css); ?></textarea><br>
                <input type="submit" name="save_css" value="Save CSS">
            </form>
        </div>
    <?php endif; ?>
    <?php include("footer.php"); ?>
</body>
</html>
