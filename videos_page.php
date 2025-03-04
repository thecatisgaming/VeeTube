<?php 
include("header.php"); 
require 'config.php';

$stmt = $pdo->prepare("SELECT v.*, u.username, COUNT(c.id) AS comments 
                        FROM videos v
                        LEFT JOIN users u ON v.user_id = u.id
                        LEFT JOIN comments c ON v.id = c.video_id
                        GROUP BY v.id
                        ORDER BY v.upload_date DESC
                        ");
$stmt->execute();
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Videos</title>
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
        /* Watch Elements */
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
        /* Code Elements */
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
    </style>
</head>
<body>
   
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
                        <div style="float: right; padding-right: 5px;"><a href="index.php">&gt;&gt;&gt; Go back to featured.</a></div>
                        All Videos
                    </div>
                </div>
                
                <div class="moduleFeatured"> 
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <?php foreach ($videos as $video): ?>
                        <tr valign="top">
                            <td>
                                <div class="moduleEntry">
                                    <table width="565" cellpadding="0" cellspacing="0" border="0">
                                        <tr valign="top">
                                            <td>
                                                
                                                <a href="index.php?v=<?php echo urlencode($video['id']); ?>">
                                                    <img src="<?php echo htmlspecialchars($video['thumbnail_path']); ?>" 
                                                         class="moduleEntryThumb" width="120" height="90" 
                                                         alt="<?php echo htmlspecialchars($video['title']); ?>">
                                                </a>
                                            </td>
                                            <td width="100%">
                                                <div class="moduleEntryTitle">
                                                    <a href="watch.php?id=<?php echo urlencode($video['id']); ?>">
                                                        <?php echo htmlspecialchars($video['title']); ?>
                                                    </a>
                                                </div>
                                                <div class="moduleEntryDescription">
                                                    <?php echo htmlspecialchars($video['description']); ?>
                                                </div>
                                                <div class="moduleEntryTags">
                                                    Tags:
                                                    <?php 
                                                    $tags = explode(' ', $video['tags']); 
                                                    foreach ($tags as $tag) { 
                                                        echo "<a href='results.php?tag=" . urlencode($tag) . "'>" 
                                                             . htmlspecialchars($tag) . "</a> "; 
                                                    } 
                                                    ?>
                                                </div>
                                                <div class="moduleEntryDetails">
                                                    Added: <?php echo date("F j, Y", strtotime($video['upload_date'])); ?> by 
                                                    <a href="profile.php?user=<?php echo urlencode($video['username']); ?>">
                                                        <?php echo htmlspecialchars($video['username']); ?>
                                                    </a>
                                                </div>
                                                <div class="moduleEntryDetails">
                                                    Views: <?php echo isset($video['views']) ? $video['views'] : 0; ?> | 
                                                    Comments: <?php echo isset($video['comments']) ? $video['comments'] : 0; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </td>
            <td><img src="/web/20050625004837im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
        </tr>
        <tr>
            <td><img src="/web/20050625004837im_/http://www.youtube.com/img/box_login_bl.gif" width="5" height="5"></td>
            <td><img src="/web/20050625004837im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
            <td><img src="/web/20050625004837im_/http://www.youtube.com/img/box_login_br.gif" width="5" height="5"></td>
        </tr>
    </table>
    <br>
    
    
    <table bgcolor="#FFFFFF" align="center" cellpadding="10" border="0">
        <tr>
            <td align="center" valign="center">
                <span class="footer">
                    <a href="about.php">About Us</a> | 
                    <a href="contact.php">Contact Us</a> | 
                    <a href="terms.php">Terms of Use</a> | 
                    <a href="privacy.php">Privacy Policy</a> | 
                    Copyright &copy; 2005 YouTube, LLC&#8482; | 
                    <a href="rss/global/recently_added.rss">
                        <img src="https://web.archive.org/web/20050625004837im_/http://www.youtube.com/img/rss.gif" width="36" height="14" border="0" style="vertical-align: text-top;">
                    </a>
                </span>
            </td>
        </tr>
    </table>
</body>
</html>
