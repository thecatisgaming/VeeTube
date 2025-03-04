<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>VeeTube Home</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
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
    
    a.title:link { font-family: Arial, Helvetica, sans-serif; color: #CCFFFF; font-size: 12px; font-weight: bold; }
    a.title:active { font-family: Arial, Helvetica, sans-serif; color: #CCFFFF; font-size: 12px; font-weight: bold; }
    a.title:visited { font-family: Arial, Helvetica, sans-serif; color: #CCFFFF; font-size: 12px; font-weight: bold; }
    a.title:hover { font-family: Arial, Helvetica, sans-serif; color: #CCFFFF; font-size: 12px; font-weight: bolder; }
    
    .table_top {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
      font-weight: 700;
      color: #333333;
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
      width: 270px;
      background-color: #FFFFCC;
      background-image: url(/web/20050819125750im_/http://www.youtube.com/img/table_results_selected_bg.gif);
      background-repeat: repeat-x;
      background-position: left top;
      border-bottom: 1px dashed #999999;
      padding: 8px;
    }
    
    .moduleFrameEntry {
      width: 270px;
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
      margin: 8px 10px 5px 10px;
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
      margin: 10px 0;
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
      padding: 3px 0 3px 10px;
    }
    
    .formTitle {
      padding: 4px 0 5px 7px;
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
      margin: 0 auto 20px auto;
    }
    
    .formIntro {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 13px;
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
      color: #666633;
      margin: 5px 0 0 6px;
    }
    
    .formFieldInfo {
      font-size: 11px;
      color: #555555;
      margin: 5px 0;
    }
    
    .pageTitle {
      padding: 4px 0 5px 7px;
      margin-bottom: 15px;
      background-color: #E5ECF9;
      border-bottom: 1px dashed #3366CC;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 14px;
      font-weight: bold;
    }
    
    .pageTable {
      padding: 0px 5px;
      margin-bottom: 20px;
    }
    
    .pageText {
      padding: 0px 5px;
    }
    
    .pageIntro {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
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
      margin: 10px auto 0 auto;
      border: 1px solid #CCC;
    }
    
    .watchInfoArea {
      width: 395px;
      margin: 0 auto 10px auto;
      padding: 15px;
      background-color: #FFFFFF;
      text-align: left;
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
      margin: 5px 0 10px 0;
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
      color: #DD8833;
      margin: 10px 0 2px 0;
    }
    
    .codeArea {
      background-color: #FFFFFF;
      border: 1px dashed #999999;
      padding: 7px;
      margin-bottom: 15px;
    }
    
    .apiLabel {
      background-color: #E5ECF9;
      margin: 20px 0 10px 0;
      padding: 10px;
    }
  </style>
</head>
<body>
  <table width="800" cellpadding="0" cellspacing="0" border="0" align="center">
    <tr>
      <td bgcolor="#FFFFFF" style="padding-bottom: 25px;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr valign="top">
            <td width="130" rowspan="2" style="padding: 5px;">
              <a href="index.php"><img src="veetube.png" width="120" height="48" alt="VeeTube" border="0"></a>
            </td>
            <td valign="top">
              <table width="670" cellpadding="0" cellspacing="0" border="0">
                <tr valign="top">
                  <td style="padding: 0px 5px; font-style: italic;">
                    Upload, tag and share your videos worldwide!
                  </td>
                  <td align="right">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td>
                          <?php if (isset($_SESSION['username'])): ?>
                            <strong>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</strong>
                            &nbsp;|&nbsp;
                            <a href="logout.php">Log Out</a>
                          <?php else: ?>
                            <a href="login.php">Log In</a>
                            &nbsp;|&nbsp;
                            <a href="signup.php">Sign Up</a>
                          <?php endif; ?>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="width:100%">
                    <div style="font-size: 12px; font-weight: bold; float: right; padding: 10px 5px 0px 5px;">
                      <a href="upload.php">Upload</a> &nbsp;//&nbsp; 
                      <a href="videos_page.php">Browse</a> &nbsp;//&nbsp; 
                      <a href="invite.php">Invite</a>
                    </div>
                    <!-- Search Form -->
                    <form method="GET" action="results.php">
                      <table cellpadding="2" cellspacing="0" border="0">
                        <tr>
                          <td>
                            <input type="text" name="search" size="30" maxlength="128" style="color:green; font-size: 14px; padding: 2px;">
                          </td>
                          <td>
                            <input type="submit" value="Search Videos">
                          </td>
                        </tr>
                      </table>
                    </form>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table align="center" width="100%" bgcolor="#D5E5F5" cellpadding="0" cellspacing="0" border="0" style="margin: 5px 0 10px 0;">
          <tr>
            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tl.gif" width="5" height="5"></td>
            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="1" height="5"></td>
            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/box_login_tr.gif" width="5" height="5"></td>
          </tr>
          <tr>
            <td><img src="/web/20050728010454im_/http://www.youtube.com/img/pixel.gif" width="5" height="1"></td>
            <td width="100%">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td>
                    <table cellpadding="2" cellspacing="0" border="0">
                      <tr>
                        <td>&nbsp;<a href="index.php" class="bold">Home</a></td>
                        <td>&nbsp;|&nbsp;</td>
                        <td><a href="my_videos.php">My Videos</a></td>
                        <td>&nbsp;|&nbsp;</td>
                        <td><a href="my_favorites.php">My Favorites</a></td>
                        <td>&nbsp;|&nbsp;</td>
                        <td><a href="my_profile.php">My Profile</a></td>
                      </tr>
                    </table>
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
      </td>
    </tr>
  </table>
</body>
</html>
