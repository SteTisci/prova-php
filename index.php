<!DOCTYPE html>
<?php session_start() ?>
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

  // Function to test the validity of the data inserted in the input fields. removes spaces, lashes and special characters from the data.
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // Form validation, check which form is submitted, if the input is not empty and the correct format.
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['form_type']) && $_POST['form_type'] == 'register') {

      if (empty($_POST["name"])) {
        $nameErr = "Name is required";
      } else {
        $name = test_input($_POST["name"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
          $nameErr = "Only letters and white space allowed";
        }
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

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
        }
      }

      if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
      } else {
        $phone = test_input($_POST["phone"]);

        if (!preg_match("/^\+?[0-9]{6,15}$/", $phone)) {
          $phoneErr = "Only numbers allowed";
        }
      }

      // if all input fields are correct the server redirects to the welcome page.
      if (empty($nameErr) && empty($passwordErr) && empty($emailErr) && empty($phoneErr)) {
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;
        $_SESSION["phone"] = $phone;
        $_SESSION["password"] = $password;

        header("Location: welcome.php");
        exit();
      }

    } elseif (isset($_POST['form_type']) && $_POST['form_type'] == 'login') {

      if (empty($_POST["name"])) {
        $nameErr = "Name is required";
      } else {
        $name = test_input($_POST["name"]);
      }

      if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
      } else {
        // If i use post for the password, chrome will show a security warning
        $password = test_input($password);
      }

      // Redirect to the homepage after the login
      if (empty($nameErr) && empty($passwordErr)) {
        $_SESSION["name"] = $name;
        $_SESSION["password"] = $password;

        header("Location: homepage.php");
        exit();
      }

    }

  }
  ?>
</head>

<body>

  <main>
    <div class="image-container"></div>
    <div class="container">
      <!-- when the submit button is clicked and an input field is wrong, reload the page with the current form submitted and the error messages. -->
      <div
        class="change-form-login <?php echo isset($_POST['form_type']) && $_POST['form_type'] == 'register' ? 'active' : ''; ?>">
        <p>Already have an account?</p>
        <button class="login">Sign in</button>
      </div>
      <div
        class="change-form-register <?php echo isset($_POST['form_type']) && $_POST['form_type'] == 'login' ? 'active' : ''; ?>">
        <p>Don't have an account?</p>
        <button class="register">Sign up</button>
      </div>
      <section
        class="register-form <?php echo isset($_POST['form_type']) && $_POST['form_type'] == 'register' ? 'active' : ''; ?>">
        <h1>Create an account</h1>
        <div class="form-container">
          <form action="index.php" method="post" novalidate>
            <!-- hidden input to check which form is submitted -->
            <input type="hidden" name="form_type" value="register" />
            <div class="info">
              <span>Name</span>
              <span class="error">* <?php echo $nameErr ?></span>
            </div>
            <input type="text" name="name" placeholder="Full Name..." autocomplete="off" />
            <div class="info">
              <span>Password</span>
              <span class="error">* <?php echo $passwordErr ?></span>
            </div>
            <input type="password" name="password" placeholder="************" autocomplete="off" />
            <div class="info">
              <span>Email</span>
              <span class="error">* <?php echo $emailErr ?></span>
            </div>
            <input type="email" name="email" placeholder="Email Address..." autocomplete="off" />
            <div class="info">
              <span>Phone number</span>
              <span class="error">* <?php echo $phoneErr ?></span>
            </div>
            <input type="tel" name="phone" placeholder="Phone Number..." autocomplete="off" />
            <input type="submit" value="Create account" />
          </form>
        </div>
      </section>
      <section
        class="login-form <?php echo isset($_POST['form_type']) && $_POST['form_type'] == 'login' ? 'active' : ''; ?>">
        <div class="form-container">
          <h1>Login</h1>
          <form action="index.php" method="post" novalidate>
            <input type="hidden" name="form_type" value="login" />
            <div class="info">
              <span>Name</span>
              <span class="error">* <?php echo $nameErr ?></span>
            </div>
            <input type="text" name="name" placeholder="Full name..." autocomplete="off" />
            <div class="info">
              <span>Password</span>
              <span class="error">* <?php echo $passwordErr ?></span>
            </div>
            <input type="password" name="password" placeholder="************" autocomplete="off" />
            <input type="submit" value="Login" />
          </form>
        </div>
      </section>
    </div>
  </main>
</body>

</html>