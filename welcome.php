<!DOCTYPE html>
<?php session_start() ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
</head>

<body>
    <div class="info-container">
        <h1>Your registration was successful!</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION["name"]) ?></p>
        <p>Email: <?php echo htmlspecialchars($_SESSION["email"]) ?></p>
        <p>Phone number: <?php echo htmlspecialchars($_SESSION["phone"]) ?></p>
    </div>
</body>

</html>