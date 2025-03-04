<?php 
include("header.php"); 
require 'config.php';

$stmt = $pdo->prepare("SELECT v.*, u.username, COUNT(c.id) AS comments 
                        FROM videos v
                        LEFT JOIN users u ON v.user_id = u.id
                        LEFT JOIN comments c ON v.id = c.video_id
                        GROUP BY v.id
                        ORDER BY v.views DESC
                        LIMIT 9");
$stmt->execute();
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div style="padding: 0px 5px;">
    <table width="790" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr valign="top">
            <td style="padding-right: 15px;">
                <!-- Upload, Watch, Share Panel -->
                <table width="595" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#E5ECF9">
                    <tr>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tl.gif" width="5" height="5"></td>
                        <td width="100%"><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tr.gif" width="5" height="5"></td>
                    </tr>
                    <tr>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
                        <td style="padding: 5px 0px 10px 0px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr valign="top">
                                    <td width="33%" style="border-right: 1px dashed #369; padding: 0px 10px 10px 10px; color: #444;">
                                        <div style="font-size: 16px; font-weight: bold; margin-bottom: 5px;"><a href="my_videos_upload.php">Upload</a></div>
                                        Quickly upload and tag videos in almost any video format.
                                    </td>
                                    <td width="33%" style="border-right: 1px dashed #369; padding: 0px 10px 10px 10px; color: #444;">
                                        <div style="font-size: 16px; font-weight: bold; margin-bottom: 5px;"><a href="browse.php">Watch</a></div>
                                        Instantly find and watch 1000's of fast streaming videos.
                                    </td>
                                    <td width="33%" style="padding: 0px 10px 10px 10px; color: #444;">
                                        <div style="font-size: 16px; font-weight: bold; margin-bottom: 5px;"><a href="my_friends_invite.php">Share</a></div>
                                        Easily share your videos with family, friends, or co-workers.
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
                    </tr>
                    <tr>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_bl.gif" width="5" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_br.gif" width="5" height="5"></td>
                    </tr>
                </table>
                <br>
                <table width="595" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#CCCCCC">
                    <tr>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tl.gif" width="5" height="5"></td>
                        <td width="100%"><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tr.gif" width="5" height="5"></td>
                    </tr>
                    <tr>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
                        <td width="585">
                            <div class="moduleTitleBar">
                                <div class="moduleTitle">
                                    <div style="float: right; padding: 1px 5px 0px 0px; font-size: 12px;">
                                        <a href="videos_page.php">See More Videos</a>
                                    </div>
                                    Today's Featured Videos
                                </div>
                            </div>
                            
                            <?php 
                            
                            usort($videos, function($a, $b) {
                                return $b['views'] - $a['views'];
                            });

                            
                            foreach ($videos as $video): 
                            ?>
                            <div class="moduleEntry">
                                <table width="565" cellpadding="0" cellspacing="0" border="0">
                                    <tr valign="top">
                                        <td>
                                            <!-- Dynamically linking the video -->
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
                            <?php endforeach; ?>
                        </td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
                    </tr>
                    <tr>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_bl.gif" width="5" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_br.gif" width="5" height="5"></td>
                    </tr>
                </table>
            </td>
            
            <td width="180">
                <table width="180" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFEEBB">
                    <tr>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tl.gif" width="5" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tr.gif" width="5" height="5"></td>
                    </tr>
                    <tr>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
                        <td width="170">
                            <div style="font-size: 16px; font-weight: bold; text-align: center; padding: 5px 5px 10px 5px;">
                                <a href="signup.php">Sign up for your free account!</a>
                            </div>
                        </td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
                    </tr>
                    <tr>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_bl.gif" width="5" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
                        <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_br.gif" width="5" height="5"></td>
                    </tr>
                </table>
                <div style="margin: 10px 0px 5px 0px; font-size: 12px; font-weight: bold; color: #333;">Recent Tags:</div>
                <?php
                // Fetch the most used tags from the database.
                $query = "SELECT tags FROM videos WHERE tags != ''";
                $stmt = $pdo->query($query);
                $tags = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $tagsList = explode(' ', $row['tags']); // Split by space
                    foreach ($tagsList as $tag) {
                        $tag = trim($tag);
                        if (!empty($tag)) {
                            if (isset($tags[$tag])) {
                                $tags[$tag]++;
                            } else {
                                $tags[$tag] = 1;
                            }
                        }
                    }
                }

                
                arsort($tags);

                
                $displayedTags = 0;
                $maxTags = 30; // How many tags to display

                echo '<div style="font-size: 17px; color: #333333; margin-bottom: 30px; text-align: center; width: 50%; margin-left: auto; margin-right: auto;">';

                foreach ($tags as $tag => $count) {
                    if ($displayedTags >= $maxTags) break;
                    
                    $fontSize = ($count > 5) ? '17px' : '12px'; // Larger font for more frequent tags
                    echo '<a style="font-size: ' . $fontSize . ';" href="results.php?search=' . urlencode($tag) . '">' . htmlspecialchars($tag) . '</a> : ';
                    $displayedTags++;
                }

                echo '<div style="font-size: 13px; color: #333333;"><a href="tags.php">See More Tags</a></div>';
                echo '</div>';
                ?>		
                <div style="padding-top: 15px;">
                    <table width="180" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFCC">
                        <tr>
                            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tl.gif" width="5" height="5"></td>
                            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
                            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tr.gif" width="5" height="5"></td>
                        </tr>
                        <tr>
                            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
                            <td width="170">
                                <div style="padding: 5px;">
                                    <script type="text/javascript">
                                    // Google AdSense code
                                    google_ad_client = "pub-6219811747049371";
                                    google_ad_width = 120;
                                    google_ad_height = 240;
                                    google_ad_format = "120x240_as";
                                    google_ad_type = "text";
                                    google_ad_channel = "";
                                    google_color_border = "FFFFCC";
                                    google_color_bg = "FFFFCC";
                                    google_color_link = "0033CC";
                                    google_color_url = "0033CC";
                                    google_color_text = "444444";
                                    </script>
                                    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
                                </div>
                            </td>
                            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
                        </tr>
                        <tr>
                            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_bl.gif" width="5" height="5"></td>
                            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
                            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_br.gif" width="5" height="5"></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <table cellpadding="10" cellspacing="0" border="0" align="center">
        <tr>
            <td align="center" valign="center">
                <span class="footer">
                    <a href="whats_new.php">What's New</a> | 
                    <a href="about.php">About Us</a> | 
                    <a href="help.php">Help</a> | 
                    <a href="terms.php">Terms of Use</a> | 
                    <a href="privacy.php">Privacy Policy</a>
                    <br><br>
                    Copyright &copy; 2005 YouTube, LLC&#8482; | 
                    <a href="rss/global/recently_added.rss">
                        <img src="http://www.youtube.com/img/rss.gif" width="36" height="14" border="0" style="vertical-align: text-top;">
                    </a>
                </span>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
