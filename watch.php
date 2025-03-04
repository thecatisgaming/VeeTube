<?php
ob_start();
session_start();

include("header.php");
require 'config.php';

$user_id = $_SESSION['username'] ?? null;

// Fetch the video details
if (!isset($_GET['id'])) {
    echo "Invalid video request.";
    exit();
}

$videoId = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM videos WHERE id = ?");
$stmt->execute([$videoId]);
$video = $stmt->fetch();

if (!$video) {
    echo "Video not found.";
    exit();
}


if (!isset($_SESSION['viewed_videos'][$videoId])) {
    $session_id = session_id();

    $stmt = $pdo->prepare("UPDATE videos SET views = views + 1 WHERE id = ?");
    $stmt->execute([$videoId]);

    $_SESSION['viewed_videos'][$videoId] = true;
}

$stmt = $pdo->prepare("SELECT username, (SELECT COUNT(*) FROM videos WHERE user_id = u.id) AS video_count FROM users u WHERE u.id = ?");
$stmt->execute([$video['user_id']]);
$user = $stmt->fetch();

$stmt = $pdo->prepare("SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.video_id = ? ORDER BY c.date_posted DESC");
$stmt->execute([$videoId]);
$comments = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT COUNT(*) AS comment_count FROM comments WHERE video_id = ?");
$stmt->execute([$videoId]);
$commentCount = $stmt->fetchColumn();

?>


<style>
    body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-color: #FFFFFF;
	color: #222222;
}

a:link, a:visited, a:active {
	color: #0033CC;
}

td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

.small {
	font-size: 10px;
	}

.label {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #222222;
}

.title {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: 700;
	color: #003366;
}

.title_login {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 400;
	color: #FFFFFF;
}

a.title:link {font-family: Arial, Helvetica, sans-serif; color: #CCFFFF; font-size: 12px; font-weight: bold;}
a.title:active {font-family: Arial, Helvetica, sans-serif; color: #CCFFFF; font-size: 12px; font-weight: bold;}
a.title:visited {font-family: Arial, Helvetica, sans-serif; color: #CCFFFF; font-size: 12px; font-weight: bold;}
a.title:hover {font-family: Arial, Helvetica, sans-serif; color: #CCFFFF; font-size: 12px; font-weight: bolder;}

.table_top {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 700;
	color:#333333;
}

.bold {
	font-weight: bold;
}

.highlight {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: 700;
	color: #333333;
}

.nav {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: 700;
}

.nav_sub {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: 400;
}

.footer {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #111111;
}

.success {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: 700;
	color: #333333;
}

.error {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: 700;
	color: #FF0000;
}

.bodystyle {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}



.moduleEntrySelected {
	background-image: url(/web/20050819125750im_/http://www.youtube.com/img/table_results_selected_bg.gif);
	background-repeat: repeat-x;
	background-color: #FFFFCC;
	background-position: left top;
	border-bottom: 1px dashed #999999;
	padding: 10px 10px 0px 10px;
}

.moduleEntry {
	background-color: #DDD;
	background-image: url(/web/20050819125750im_/http://www.youtube.com/img/table_results_bg.gif);
	background-position: left top;
	background-repeat: repeat-x;
	border-bottom: 1px dashed #999999;
	padding: 10px;
}

.moduleEntryThumb {
	border: 5px solid #FFFFFF;
	margin-right: 10px;
}

.moduleEntryTitle {
	font-size: 14px;
	font-weight: bold;
	margin-bottom: 2px;
	color: #333333;
}

.moduleEntryDescription {
	font-size: 12px;
	margin-bottom: 6px;
	color: #333;
	padding-right: 10px;

}

.moduleEntryTags {
	font-size: 12px;
	margin-bottom: 5px;
	color: #444;
}

.moduleEntryDetails {
	font-size: 11px;
	margin-bottom: 5px;
	color: #444;
}

.moduleTitle {
	font-size: 14px;
	font-weight: bold;
	margin: 0px 0px 5px 5px;
	color: #444;
}

.moduleTitleBar {
	width: 100%;
	background-color: #CCC;
	border-bottom: 1px dashed #999;
}

.moduleFeatured {
	background-color: #DDD;
	background-image: url(/web/20050819125750im_/http://www.youtube.com/img/table_results_bg.gif);
	background-position: left top;
	background-repeat: repeat-x;
	border-bottom: 1px dashed #999999;
	padding: 5px 5px 15px 5px;
}

.moduleFeaturedThumb {
	border: 5px solid #FFFFFF;
	margin: 5px;
}

.moduleFeaturedTitle {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	margin-bottom: 3px;
	color: #0033CC;
	
}

.moduleFeaturedDetails {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
	color: #666666;
	margin-bottom: 3px;
}

.moduleFrameBarTitle {
	font-size: 12px;
	font-weight: bold;
	margin: 0px 5px 5px 5px;
	color: #444;
}

.moduleFrameEntrySelected {
	width: 270;
	background-color: #FFFFCC;
	background-image: url(/web/20050819125750im_/http://www.youtube.com/img/table_results_selected_bg.gif);
	background-repeat: repeat-x;
	background-position: left top;
	border-bottom: 1px dashed #999999;
	padding: 8px;
}

.moduleFrameEntry {
	width: 270;
	background-color: #DDD;
	background-image: url(/web/20050819125750im_/http://www.youtube.com/img/table_results_bg.gif);
	background-position: left top;
	background-repeat: repeat-x;
	border-bottom: 1px dashed #999999;
	padding: 8px;
}

.moduleFrameTitle {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	margin-bottom: 3px;
	color: #0033CC;
	
}

.moduleFrameDetails {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
	margin-bottom: 5px;
	color: #666666;
	
}

.tableFavRemove {
	margin-right: 5px;
	margin-left: 10px;
	margin-top: 8px;
	margin-bottom: 5px;
	
}

.tableVideoStats {
	width: 100%;
	background-image: url(/web/20050819125750im_/http://www.youtube.com/img/table_results_selected_bg.gif);
	background-repeat: repeat-x;
	background-color: #FFFFCC;
	background-position: left top;
	border: 1px dashed #CCCC66;
	padding-top: 5px;
	padding-bottom: 15px;
	margin-top: 10px;
	margin-bottom: 10px;
}

.tableSubTitle {
	padding: 0px 0px 5px 0px;
	border-bottom: 1px dashed #CCC;
	margin-bottom: 10px;
	font-size: 14px;
	font-weight: bold;
	color: #CC6633;
}

.tableSubTitleInfo {
	font-size: 12px;
	padding: 3px;
	padding-left: 10px;
}



/* Form Elements */

.formTitle {
	padding: 4px;
	padding-left: 7px;
	padding-bottom: 5px;
	margin-bottom: 10px;
	background-color: #E5ECF9;
	border-bottom: 1px dashed #3366CC;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}

.formTable {
	width: 80%;
	padding: 5px;
	margin-bottom: 20px;
	margin-left: auto;
	margin-right: auto;
}

.formIntro {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: normal;
	margin-bottom: 15px;
	padding-left: 10px;
}

.formHighlight {
	background-image: url(/web/20050819125750im_/http://www.youtube.com/img/table_results_selected_bg.gif);
	background-repeat: repeat-x;
	background-color: #FFFFCC;
	background-position: left top;
	border: 1px dashed #CCCC66;
	padding: 7px;
	padding-bottom: 10px;
	margin-bottom: 5px;
}

.formHighlightText {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	color: #666633;
	margin-top: 5px;
	margin-left: 6px;
}

.formFieldInfo {
	font-size: 11px;
	color: #555555;
	margin-top: 5px;
	margin-bottom: 5px;
}




.pageTitle {
	padding: 4px;
	padding-left: 7px;
	padding-bottom: 5px;
	margin-bottom: 15px;
	background-color: #E5ECF9;
	border-bottom: 1px dashed #3366CC;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}

.pageTable {
	padding: 0px 5px 0px 5px;
	margin-bottom: 20px;
}

.pageText {
	padding: 0px 5px 0px 5px;
}

.pageIntro {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	margin-bottom: 15px;
}


.mailMessageArea {
	background-color: #FFFFFF;
	border: 1px dashed #999999;
	padding: 7px;
	padding-bottom: 10px;
	margin-bottom: 15px;
}





.watchTitleBar {
	background-color: #CCCCCC;
	border-bottom: 1px dashed #999999;
}

.watchTitle {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: bold;
	margin-left: 5px;
	margin-bottom: 6px;
	color: #333333;
	
}

.watchTable {
	background-color: #DDDDDD;
	background-image: url(/web/20050819125750im_/http://www.youtube.com/img/table_results_bg.gif);
	background-repeat: repeat-x;
	background-position: left top;
	border-bottom: 1px dashed #999999;
	padding: 5px;
	padding-bottom: 10px;
	text-align: center;
}

#flashcontent {
	background-color: #FFFFFF;
	width: 425px;
	height: 350px;
	margin-top: 10px;
	margin-left: auto;
	margin-right: auto;
	border: 1px solid #CCC;
}

.watchInfoArea {
	width: 395px;
	text-align: left;
	margin-left: auto;
	margin-right: auto;
	margin-bottom: 10px;
	padding-left: 15px;
	padding-right: 15px;
	padding-bottom: 15px;
	background-color:#FFFFFF;
}

.watchDescription {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	padding-bottom: 5px;
	color: #000;
	border-bottom: 1px dashed #CCC;
}

.watchTags {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	margin: 5px 0px 10px 0px;
	color: #333333;
}

.watchAdded {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	margin-bottom: 5px;
	color: #333333;
}

.watchDetails {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	color: #333333;
}

.commentsTitle {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #333333;
	background-color: #EEEEEE;
	padding: 5px;
	padding-bottom: 6px;
	border-top: 1px dashed #999999;
	border-bottom: 1px dashed #999999;

}

.commentsEntry {
	font-size: 11px;
	background-color: #FFFFCC;
	padding: 10px;
	border-bottom: 1px dashed #999999;
    text-align: left;


}

.commentsThumb {
	border: 5px solid #FFFFFF;
	margin-right: 5px;
}

.profileLabel {
	font-size: 12px;
	font-weight: bold;
	color:#DD8833;
	margin: 10px 0px 2px 0px;
}


.codeArea {
	background-color: #FFFFFF;
	border: 1px dashed #999999;
	padding: 7px;
	margin-bottom: 15px;
}

.apiLabel {
	background-color: #E5ECF9; 
	margin-top: 20px; 
	margin-bottom: 10px; 
	padding-left: 10px; 
	padding-right: 10px; 
	padding-top: 10px; 
	padding-bottom: 10px;
}
	

/*
     FILE ARCHIVED ON 12:57:50 Aug 19, 2005 AND RETRIEVED FROM THE
     INTERNET ARCHIVE ON 00:03:55 Mar 02, 2025.
     JAVASCRIPT APPENDED BY WAYBACK MACHINE, COPYRIGHT INTERNET ARCHIVE.

     ALL OTHER CONTENT MAY ALSO BE PROTECTED BY COPYRIGHT (17 U.S.C.
     SECTION 108(a)(3)).
*/
/*
playback timings (ms):
  captures_list: 0.458
  exclusion.robots: 0.018
  exclusion.robots.policy: 0.008
  esindex: 0.009
  cdx.remote: 54.271
  LoadShardBlock: 137.307 (3)
  PetaboxLoader3.datanode: 187.616 (4)
  load_resource: 174.92
  PetaboxLoader3.resolve: 109.049
*/
</style>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<table width="800" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td bgcolor="#FFFFFF" style="padding-bottom: 25px;">
		

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	
	
		<td><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
	</tr>
	<tr>
		<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_bl.gif" width="5" height="5"></td>
		<td><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
		<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_br.gif" width="5" height="5"></td>
	</tr>
</table>

<div style="padding: 0px 5px 0px 5px;">
		

<iframe id="invisible" name="invisible" src="/web/20050728151528if_/http://www.youtube.com/watch.php?v=vy8evhya_9E" scrolling="yes" width="0" height="0" frameborder="0" marginheight="0" marginwidth="0"></iframe>   


<table width="795" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td width="515" style="padding-right: 15px;">
		
		<div class="tableSubTitle"><?php echo htmlspecialchars($video['title']); ?></div>
		<div style="font-size: 13px; font-weight: bold; text-align:center;">
		<a href="mailto:/?subject=<?php echo htmlspecialchars($video['title']); ?>&amp;body=http://veetube.nloadvideo.com/watch.php?id=<?php echo $videoId; ?>">Share</a>
		// <a href="#comment">Comment</a>
		// <a href="#" onclick="return FavoritesHandler(<?php echo $video['id']; ?>);">Add to Favorites</a>

<script type="text/javascript">
    function FavoritesHandler(videoId) {
        var userId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'null'; ?>;
        if (!userId) {
            alert('You must be logged in to favorite videos.');
            return false;
        }

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_favorite.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Handle the response
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle success or failure based on the response
                if (xhr.responseText === 'success') {
                    alert('Video added to favorites!');
                } else {
                    alert('Error adding video to favorites.');
                }
            }
        };

        // Send the data (user_id and video_id)
        xhr.send("user_id=" + userId + "&video_id=" + videoId);

        return false;
    }
</script>

		// <a href="">Contact Me</a>
		</div>
		
        <iframe src="player/player.php?id=<?php echo $videoId; ?>" width="500" height="500" frameborder="0" allow="autoplay; encrypted-media" style="border:none;"></iframe>


		<table width="425" cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
				<td>
					<div class="watchDescription"><?php echo htmlspecialchars($video['description']); ?>					<div class="watchAdded" style="margin-top: 5px;">
										</div>
					</div>
					<div class="watchTags">Tags //             <?php
            $tags = explode(' ', $video['tags']);
            foreach ($tags as $tag) {
                echo "<a href='results.php?tag=" . urlencode($tag) . "'>$tag</a> ";
            }
            ?>					</div>
			
								
					<div class="watchAdded">
					Added: <?php echo date("F j, Y", strtotime($video['upload_date'])); ?> by <a href="profile.php?user= <?php echo htmlspecialchars($id ?? '', ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($user['username']); ?></a> //
					<a href=""><?php echo $user['video_count']; ?> videos)</a>
					</div>
			
					<div class="watchDetails">
					Views: <?php echo $video['views']; ?> | <a href="#comment">Comments</a>: <?php echo $commentCount; ?>				</div>
					<p>Rate This Video.</p>
        <div class="star-rating">
            <form action="" method="POST">
                <strong>Rate this video:</strong><br>
                <i class="fa fa-star" data-value="1"></i>
                <i class="fa fa-star" data-value="2"></i>
                <i class="fa fa-star" data-value="3"></i>
                <i class="fa fa-star" data-value="4"></i>
                <i class="fa fa-star" data-value="5"></i>
                <input type="hidden" name="rating" id="rating" value="">
                <button type="submit">Submit Rating</button>
            </form>
        </div>
            <script>
        const stars = document.querySelectorAll('.star-rating i');
        const ratingInput = document.getElementById('rating');
        
        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const value = star.getAttribute('data-value');
                updateStars(value);
            });
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                ratingInput.value = value;
                updateStars(value, true);
            });
        });

        function updateStars(value, permanent = false) {
            stars.forEach(star => {
                const starValue = star.getAttribute('data-value');
                if (starValue <= value) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }
    </script>
				</td>
			</tr>
		</table>
		
		
		<div style="padding: 15px 0px 10px 0px;">
		<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#E5ECF9">
			<tr>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_tl.gif" width="5" height="5"></td>
				<td width="100%"><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_tr.gif" width="5" height="5"></td>
			</tr>
			<tr>
				<form name="linkForm" id="linkForm">
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
				<td align="center">
		
				<div style="font-size: 11px; font-weight: bold; color: #CC6600; padding: 5px 0px 5px 0px;">Share this video! Copy and paste this link:</div>
				<div style="font-size: 11px; padding-bottom: 15px;">
				<input name="video_link" type="text" onclick="javascript:document.linkForm.video_link.focus();document.linkForm.video_link.select();" value="http://veetube.nloadvideo.com/watch.php?id=<?php echo $videoId; ?>" size="50" readonly="true" style="font-size: 10px; text-align: center;">
				</div>
				
				</td>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
				</form>
			</tr>
			<tr>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_bl.gif" width="5" height="5"></td>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_br.gif" width="5" height="5"></td>
			</tr>
		</table>
		</div>
		
		<a name="comment"></a>
		
		                <p>Write a Comment for this video.</p>
            <form action="" method="POST">
                <textarea name="comment" placeholder="Write a comment..." required></textarea>
                <input type="hidden" name="video_id" value="<?php echo $videoId; ?>">
                <button type="submit">Post Comment</button>

		
		</form>
		<br>

		<div class="commentsTitle">Comments (<?php echo $commentCount; ?>):</div>
		
		<div class="commentsEntry" 
><?php foreach ($comments as $comment): ?>

                    <p class="comment-author"><?php echo htmlspecialchars($comment['username']); ?> commented:</p>
                    <p class="comment-text"><?php echo htmlspecialchars($comment['comment']); ?></p>
            <?php endforeach; ?></div>
	
		</td>
		<td width="280">
		
		<table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#CCCCCC">
			<tr>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_tl.gif" width="5" height="5"></td>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_tr.gif" width="5" height="5"></td>
			</tr>
			<tr>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
				<td width="270">
				<div class="moduleTitleBar">
				<table width="270" cellpadding="0" cellspacing="0" border="0">
					<tr valign="top">
						<td><div class="moduleFrameBarTitle">Tag // <?php
            $tags = explode(' ', $video['tags']);
            foreach ($tags as $tag) {
                echo "<a href='search.php?tag=" . urlencode($tag) . "'>$tag</a> ";
            }
            ?></div></td>
						<td align="right"><div style="font-size: 11px; margin-right: 5px;"><a href="results.php?&amp;search=aerobatic+sukhoi+airplane+stunt+trick" target="_parent">See more Results</a></div></td>
					</tr>
				</table>
				</div>

<iframe id="side_results" name="side_results" src="results.php?search=<?php
    $tags = explode(' ', $video['tags']);
    echo isset($tags[0]) ? urlencode($tags[0]) : '';
?>" scrolling="auto" width="270" height="400" frameborder="0" marginheight="0" marginwidth="0">
    [Content for browsers that don't support iframes goes here]
</iframe>

				</td>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
			</tr>
			<tr>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_bl.gif" width="5" height="5"></td>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
				<td><img src="/web/20050728151528im_/http://www.youtube.com/img/box_login_br.gif" width="5" height="5"></td>
			</tr>
		</table><br>
		

		
		<div style="font-weight: bold; color: #333; margin: 10px 0px 5px 0px;">Related tags:</div>
		<div style="padding: 0px 0px 5px 0px; color: #999;">&#187;             <?php
            $tags = explode(' ', $video['tags']);
            foreach ($tags as $tag) {
                echo "<a href='search.php?tag=" . urlencode($tag) . "'>$tag</a> ";
            }
            ?>		</tr>

		</td>
	</tr>
</table>

		</div>
		</td>
	</tr>
</table>
