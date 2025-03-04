<?php
ob_start();
session_start();
include("config.php");

$checkUserStmt = $pdo->prepare("SELECT id, password FROM users WHERE username = :username");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["field_login_username"]);
    $password = $_POST["field_login_password"];

    if (empty($username) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Fetch user data
        $checkUserStmt->execute(['username' => $username]);
        $user = $checkUserStmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set the session variables
            $_SESSION["id"] = $user["id"]; // Use 'id' instead of 'user_id'
            $_SESSION["username"] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}

ob_end_flush();
include("header.php");
?>


<div class="pageTitle">Log In</div>

<table width="80%" align="center" cellpadding="5" cellspacing="0" border="0">
    <tr valign="top">
        <td>
            <span class="highlight">What is veetube?</span>
            <br><br>
            Veetube is a way to get your videos to the people who matter to you. With veetube you can:
            <ul>
                <li> Show off your favorite videos to the world</li>
                <li> Blog the videos you take with your digital camera or cell phone</li>
                <li> Securely and privately show videos to your friends and family around the world</li>
                <li> ... and much, much more!</li>
            </ul>
            <br><span class="highlight"><a href="signup.php">Sign up now</a> and open a free account.</span>
            <br><br><br>
            To learn more about our service, please see our <a href="help.php">Help</a> section.<br><br><br>
        </td>
        <td width="20"><img src="/web/20050626012859im_/http://www.youtube.com/img/pixel.gif" width="20" height="1"></td>
        <td width="300">
            <div style="background-color: #D5E5F5; padding: 10px; padding-top: 5px; border: 6px double #FFFFFF;">
                <table width="100%" bgcolor="#D5E5F5" cellpadding="5" cellspacing="0" border="0">
                    <form method="post" action="login.php">
                        <input type="hidden" name="field_command" value="login_submit">
                        <tr>
                            <td align="center" colspan="2">
                                <div style="font-size: 14px; font-weight: bold; color:#003366; margin-bottom: 5px;">Veetube Log In</div>
                            </td>
                        </tr>

                        <?php if (isset($error)): ?>
                            <tr>
                                <td colspan="2" style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td align="right"><span class="label">User Name:</span></td>
                            <td><input type="text" size="20" name="field_login_username" value="<?= htmlspecialchars($username ?? '') ?>"></td>
                        </tr>
                        <tr>
                            <td align="right"><span class="label">Password:</span></td>
                            <td><input type="password" size="20" name="field_login_password"></td>
                        </tr>
                        <tr>
                            <td align="right"><span class="label">&nbsp;</span></td>
                            <td><input type="submit" value="Log In"></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2"><a href="contact.php">Forgot your password?</a></td>
                        </tr>
                    </form>
                </table>
            </div>
        </td>
    </tr>
</table>
