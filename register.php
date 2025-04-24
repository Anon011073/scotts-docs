<?php include 'includes/header.php'; ?>

<h2>Register</h2>

<form action="register_process.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Register</button>
</form>

<?php include 'includes/footer.php'; ?>
