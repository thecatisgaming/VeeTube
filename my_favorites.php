<?php
session_start();
include("header.php"); 
require 'config.php';


if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['id'];

$query = "SELECT v.id, v.title, v.thumbnail_path, v.upload_date, u.username 
          FROM favorites f
          JOIN videos v ON f.video_id = v.id
          JOIN users u ON v.user_id = u.id
          WHERE f.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


    <div style="font-size: 16px; font-weight: bold; margin-top: 20px; margin-bottom: 20px; text-align: center;"><a href="upload.php">Upload Your Videos</a></div>
    <br>
<table width="80%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#CCCCCC">
    <tr>
        <td><img src="/web/20050625004837im_/http://www.youtube.com/img/box_login_tl.gif" width="5" height="5"></td>
        <td width="100%"><img src="/web/20050625004837im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
        <td><img src="/web/20050625004837im_/http://www.youtube.com/img/box_login_tr.gif" width="5" height="5"></td>
    </tr>
    <tr>
        <td><img src="/web/20050625004837im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
        <td>
            <div class="moduleTitleBar">
                <div class="moduleTitle">
                    <div style="float: right; padding-right: 5px;">
                        <a href="videos_page.php">&gt;&gt;&gt; Watch More Videos</a>
                    </div>
                    My Favorite Videos
                </div>
            </div>
            
            <div class="moduleFeatured"> 
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr valign="top">
                        <?php 
                       
                        if (empty($videos)): ?>
                            <td colspan="5" align="center">
                                You have not favorited any videos yet.
                            </td>
                        <?php else: 
                           
                            foreach ($videos as $video): 
                            ?>
                                					<div class="moduleEntry">
					<table width="565" cellpadding="0" cellspacing="0" border="0">
						<tr valign="top">
							<td><a href="index.php?v=z9Wk4O20FyE"><img src="<?php echo htmlspecialchars($video['thumbnail_path']); ?>" class="moduleEntryThumb" width="120" height="90"></a></td>
							<td width="100%"><div class="moduleEntryTitle"><a href="wateh.php?id=<?php echo $video['id']; ?>"><?php echo htmlspecialchars($video['title']); ?></a></div>
							<div class="moduleEntryDescription"><?php echo htmlspecialchars($video['description']); ?></div>
							<div class="moduleEntryTags">
							Tags // <?php
            $tags = explode(' ', $video['tags']);
            foreach ($tags as $tag) {
                echo "<a href='results.php?tag=" . urlencode($tag) . "'>$tag</a> ";
            }
            ?> 							</div>
							<div class="moduleEntryDetails">Added: <?php echo date("F j, Y", strtotime($video['upload_date'])); ?> by <a href="profile.php?user=<?php echo htmlspecialchars($video['username']); ?>"><?php echo htmlspecialchars($video['username']); ?></a></div>
							<div class="moduleEntryDetails">Views: <?php echo isset($video['views']) ? $video['views'] : 0; ?> | Comments: <?php echo isset($video['comments']) ? $video['comments'] : 0; ?></div>
							</td>
						</tr>
					</table>
					</div>
                            <?php endforeach; 
                        endif;
                        ?>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
