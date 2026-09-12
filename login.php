<?php

session_start();

include "config/database.php";

$error = "";

if (isset($_SESSION["admin_logged_in"])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    /*
     * Temporary administrator account
     *
     * Username: admin
     * Password: admin123
     */

    if ($username === "admin" && $password === "admin123") {

        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_username"] = $username;

        header("Location: dashboard.php");
        exit();

    } else {

        $error = "Invalid username or password.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Student Information System</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body class="login-page">

    <div class="login-container">

        <div class="login-card">

            <div class="login-header">

                <div class="login-logo">
                    S
                </div>

                <h1>StudentIMS</h1>

                <p>Student Information System</p>

            </div>


            <div class="login-title">

                <h2>Welcome Back</h2>

                <p>Sign in to access the administrator dashboard.</p>

            </div>


            <?php if ($error != ""): ?>

                <div class="login-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <form method="POST">

                <div class="login-form-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter your username"
                        required
                        autofocus
                    >

                </div>


                <div class="login-form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                </div>


                <button type="submit" class="login-button">
                    Sign In
                </button>

            </form>


            <div class="login-footer">

                <p>
                    Student Information Management System
                </p>

            </div>

        </div>

    </div>

</body>

</html>

