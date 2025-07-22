<?php include '../views/Header.php'; ?>
<form method="POST" action="../actions/Register.php">
    <input name="username" required placeholder="Username"><br>
    <input type="password" name="password" required placeholder="Password"><br>
    <input type="hidden" name="CSRF_token" value="<?php print $_SESSION['CSRF'] ?>">
    <button type="submit">Register</button>
</form>
<?php include '../views/Footer.php'; ?>