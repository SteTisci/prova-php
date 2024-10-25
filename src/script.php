<?php
// I use dotenv for the enviroment variables of the database
require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

$SERVER_NAME = getenv('SERVER_NAME');
$DB_USERNAME = getenv('DB_USERNAME');
$DB_PASSWORD = getenv('DB_PASSWORD');
$DB_NAME = getenv('DB_NAME');


$nameErr = $passwordErr = $emailErr = $phoneErr = $loginErr = "";
$name = $password = $email = $phone = "";

// Function to test the validity of the data inserted in the input fields. 
// removes spaces, lashes and special characters from the data.
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Form validation, check which form is submitted, if the input is not empty and the correct format.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli($SERVER_NAME, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

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
            // Crypt the password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['password'] = $passwordHash;

            // Insert the data from the register form in the database
            $sql = 'INSERT INTO Utenti(username, password, email, telefono) VALUES (?, ?, ?, ?)';

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('ssss', $name, $passwordHash, $email, $phone);
                $stmt->execute();
            } else {
                echo "Errore durante l'inserimento dei dati: " . $conn->error;
            }
            $stmt->close();

            header("Location: welcome.php");
            exit();
        }

    } elseif (isset($_POST['form_type']) && $_POST['form_type'] == 'login') {
        // Retrive username and password from the data in the database
        $sql = "SELECT username, password FROM Utenti WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('s', $_POST['name']);
            $stmt->execute();
            $stmt->bind_result($db_username, $db_password);

            // if a row is present in the batabase and the password match the ashed one, the script redirect to the welcome page
            if ($stmt->fetch() && password_verify($_POST['password'], $db_password)) {
                $_SESSION['name'] = $db_username;

                header("Location: homepage.php");
                exit();
            } else {
                $loginErr = "* Username or Password doesn't match any account";
            }
            $stmt->close();
        }
    }
    $conn->close();
}