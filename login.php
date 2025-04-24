<?php include 'includes/header.php'; ?>

<h2>Login</h2>

<form action="login_process.php" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="register.php">Register here</a></p>

<?php include 'includes/footer.php'; ?>
