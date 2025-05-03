<?php include '../views/header.php'; ?>
<form method="POST" action="../actions/register.php">
    <input name="username" required placeholder="Username"><br>
    <input type="password" name="password" required placeholder="Password"><br>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf'] ?>">
    <button type="submit">Register</button>
</form>
<?php include '../views/footer.php'; ?>