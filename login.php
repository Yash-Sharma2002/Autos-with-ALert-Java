<?php
session_start();
require_once "pdo.php";

if (isset($_POST['cancel'])) {
    // Redirect the browser to game.php
    header("Location: main.php");
    return;
}


$salt = 'XyZzy12*_';
//$stored_hash = hash('md5', 'XyZzy12*_php123');
// Pw is php123

$failure = false;  // If we have no POST data

if (isset($_POST['email']) && isset($_POST['pass'])) {



    $check = hash('md5', $salt . $_POST['pass']);


    $sql = "SELECT user_id,name FROM users WHERE email = :em AND password = :pw";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':em' => $_POST['email'],
        ':pw' => $check
    ));
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
     if ($row !== false) {

        $_SESSION['name'] = $row['name'];

        $_SESSION['user_id'] = $row['user_id'];

        // Redirect the browser to index.php

        $_SESSION['success'] = "Login Success";
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = "Incorrect password";
        error_log("Login fail " . $_POST['email'] . " $check");
        header("Location: login.php");
        return;
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Welcome to Autos Database By Yash Sharma</title>
</head>

<body>
    <div class="container">
        <h1>Please Log In</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
            
        }
        ?>
        
        <form method="POST" action="login.php">
            E-mail <input type="text" id="email" name="email"><br />
            Password <input type="text" id="id_1723" name="pass"><br />
            <input type="submit" onclick="return doValidate();" value="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>
        <p>
            For a password hint, view source and find a password hint
            in the HTML comments.
            <!-- Hint: The password is the four character sound a cat
        makes (all lower case) followed by 123. -->
        </p>
    </div>
    <script>
        function doValidate() {

            console.log('Validating...');

            try {
                email = document.getElementById('email').value;
                pw = document.getElementById('id_1723').value;

                console.log("Validating email = " + email + " password =" + pw);

                if (pw == null || pw == "") {

                    alert("Both fields must be filled out");

                    return false;

                } else if (email.indexOf('@') == -1) {
                    alert("Email Must Have @ sign");
                    return false;
                }

                return true;

            } catch (e) {

                return false;

            }

            return false;

        }
    </script>

</body>

</html>