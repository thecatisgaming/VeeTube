<?php
include("config.php");
include("header.php");

$checkUserStmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
$insertUserStmt = $pdo->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["field_signup_email"]);
    $username = trim($_POST["field_signup_username"]);
    $password = $_POST["field_signup_password_1"];
    $password_confirm = $_POST["field_signup_password_2"];

    if (empty($email) || empty($username) || empty($password) || empty($password_confirm)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $password_confirm) {
        $error = "Passwords do not match.";
    } else {
        $checkUserStmt->execute(['email' => $email, 'username' => $username]);

        if ($checkUserStmt->fetch()) {
            $error = "Email or username already taken.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $insertUserStmt->execute(['email' => $email, 'username' => $username, 'password' => $hashedPassword]);

            echo "<p>Signup successful! <a href='login.php'>Log in here</a>.</p>";
            header("login.php");
            exit;
        }
    }
}
?>

    <div class="formIntro">Please enter your account information below. All fields are required.</div>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="signup.php">
        <table width="720" cellpadding="5" cellspacing="0" border="0">
            <tr>
                <td width="200" align="right"><span class="label">Email Address:</span></td>
                <td><input type="text" size="30" maxlength="60" name="field_signup_email" value="<?= htmlspecialchars($email ?? '') ?>"></td>
            </tr>
            <tr>
                <td align="right"><span class="label">User Name:</span></td>
                <td><input type="text" size="20" maxlength="20" name="field_signup_username" value="<?= htmlspecialchars($username ?? '') ?>"></td>
            </tr>
            <tr>
                <td align="right"><span class="label">Password:</span></td>
                <td><input type="password" size="20" maxlength="20" name="field_signup_password_1"></td>
            </tr>
            <tr>
                <td align="right"><span class="label">Retype Password:</span></td>
                <td><input type="password" size="20" maxlength="20" name="field_signup_password_2"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <br>- I certify I am over 13 years old.
                    <br>- I agree to the <a href="terms.php" target="_blank">terms of use</a> and <a href="privacy.php" target="_blank">privacy policy</a>.
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Sign Up"></td>
            </tr>
        </table>
    </form>
</div>

