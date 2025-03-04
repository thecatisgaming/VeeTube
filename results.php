<?php
include("header.php"); 

include("config.php");

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchTerm) {
    $searchTerm = htmlspecialchars($searchTerm);

    $query = "SELECT * FROM videos WHERE tags LIKE :tag";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':tag' => '%' . $searchTerm . '%']);
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $videos = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - <?php echo $searchTerm; ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your styles here -->
</head>
<body>

    <div style="font-size: 14px; text-align: center; margin-bottom: 20px;">
        <h2>Search Results for: "<?php echo htmlspecialchars($searchTerm); ?>"</h2>
    </div>

    <div style="font-size: 13px; color: #333333; margin-bottom: 30px; text-align: center; width: 70%; margin-left: auto; margin-right: auto;">
<?php if (count($videos) > 0): ?>
    <div class="moduleFeatured"> 
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr valign="top">
                <?php 
                // Loop through the videos and display each in its own table cell.
                foreach ($videos as $video): 
                ?>
                    <td width="20%" align="center">
                        <a href="watch.php?id=<?php echo $video['id']; ?>">
                            <img src="<?php echo htmlspecialchars($video['thumbnail_path']); ?>" class="moduleFeaturedThumb" width="120" height="90" alt="<?php echo htmlspecialchars($video['title']); ?>">
                        </a>
                        <div class="moduleFeaturedTitle">
                            <a href="watch.php?id=<?php echo $video['id']; ?>"><?php echo htmlspecialchars($video['title']); ?></a>
                        </div>
                        <div class="moduleFeaturedDetails">
                            Added: <?php echo date("F j, Y", strtotime($video['upload_date'])); ?><br>
                            by <a href="profile.php?user=<?php echo urlencode($video['username']); ?>"><?php echo htmlspecialchars($video['username']); ?></a>
                        </div>
                        <div class="moduleFeaturedDetails">
                            Views: <?php echo isset($video['views']) ? $video['views'] : 0; ?> | Comments: <?php echo isset($video['comments']) ? $video['comments'] : 0; ?>
                        </div>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
    </div>
<?php else: ?>
    <p>No videos found for the selected search.</p>
<?php endif; ?>


    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php" style="font-size: 14px;">Back to Home</a>
    </div>

</body>
</html>
