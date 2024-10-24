<?php
require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

$SERVER_NAME = getenv('SERVER_NAME');
$USERNAME = getenv('NAME');
$PASSWORD = getenv('PSWD');
$DB_NAME = getenv('DB_NAME');


$nameErr = $passwordErr = $emailErr = $phoneErr = "";
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

            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);

            // Create database connection
            $conn = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DB_NAME);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = 'INSERT INTO Utenti(username, password, email, telefono) VALUES (?, ?, ?, ?)';

            if ($stmt = $conn->prepare($sql)) {
                // Crypt the password before inserting it in the database
                $password = password_hash($password, PASSWORD_DEFAULT);

                $stmt->bind_param('ssss', $name, $password, $email, $phone);
                $stmt->execute();
            } else {
                echo "Errore durante l'inserimento dei dati" . $conn->error;
            }
            $conn->close();

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

            // TODO: aggiungere controllo dati prima di reinderizzare
            $_SESSION["name"] = $name;
            $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);

            header("Location: homepage.php");
            exit();
        }

    }

}