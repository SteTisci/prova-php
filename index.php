<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <script src="index.js" defer></script>
  <title>Form</title>

  <?php

  $nameErr = $passwordErr = $emailErr = $phoneErr = "";
  $name = $password = $email = $phone = "";

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['form_type']) && $_POST['form_type'] == 'register') {

      if (empty($_POST["name"])) {
        $nameErr = "Name is required";
      } else {
        $name = test_input($_POST["name"]);
      }

      if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
      } else {
        $password = test_input($_POST["password"]);
      }

      if (empty($_POST["email"])) {
        $emailErr = "Email is required";
      } else {
        $email = test_input($_POST["email"]);
      }

      if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
      } else {
        $phone = test_input($_POST["phone"]);
      }

    } elseif (isset($_POST['form_type']) && $_POST['form_type'] == 'login') {

      if (empty($_POST["email"])) {
        $emailErr = "Email is required";
      } else {
        $email = test_input($_POST["email"]);
      }

      if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
      } else {
        $password = test_input($_POST["password"]);
      }
    }
  }
  ?>
</head>

<body>

  <main>
    <div class="image-container"></div>
    <div class="container">
      <div class="change-form-login active">
        <p>Already have an account?</p>
        <button class="login">Login</button>
      </div>
      <div class="change-form-register">
        <p>Don't have an account?</p>
        <button class="register">Register</button>
      </div>
      <section class="register-form active">
        <h1>Create an account</h1>
        <div class="form-container">
          <form action="index.php" method="post">
            <input type="hidden" name="form_type" value="register" />
            <div class="info">
              <span>Name</span>
              <span class="error">* <?php echo $nameErr ?></span>
            </div>
            <input type="text" name="name" placeholder="Full Name..." />
            <div class="info">
              <span>Password</span>
              <span class="error">* <?php echo $passwordErr ?></span>
            </div>
            <input type="password" name="password" placeholder="************" />
            <div class="info">
              <span>Email</span>
              <span class="error">* <?php echo $emailErr ?></span>
            </div>
            <input type="email" name="email" placeholder="Email Address..." />
            <div class="info">
              <span>Phone number</span>
              <span class="error">* <?php echo $phoneErr ?></span>
            </div>
            <input type="tel" name="phone" placeholder="Phone Number..." />
            <input type="submit" value="Create account" />
          </form>
        </div>
      </section>
      <section class="login-form">
        <div class="form-container">
          <h1>Login</h1>
          <form action="index.php" method="post">
            <input type="hidden" name="form_type" value="login" />
            <div class="info">
              <span>Email</span>
              <span class="error">* <?php echo $emailErr ?></span>
            </div>
            <input type="email" name="email" placeholder="Email Address..." />
            <div class="info">
              <span>Password</span>
              <span class="error">* <?php echo $passwordErr ?></span>
            </div>
            <input type="password" name="password" placeholder="************" />
            <input type="submit" value="Login" />
          </form>
        </div>
      </section>
    </div>
  </main>
</body>

<!-- TODO: gestire reinvio modulo per visualizzare la pagina attualmente attiva -->

</html>