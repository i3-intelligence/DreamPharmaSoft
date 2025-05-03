<?php include '../views/header.php'; ?>
<form method="POST" action="../actions/login.php">
    <input name="username" required placeholder="Username"><br>
    <input type="password" name="password" required placeholder="Password"><br>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf'] ?>">
    <button type="submit">Login</button>
</form>
<?php include '../views/footer.php'; ?>