<?php // Do not put any HTML above this line
session_start();

require_once "pdo.php";

unset($_SESSION['error']);
$stmt = $pdo->query("SELECT first_name,last_name,headline,user_id,profile_id FROM profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Autos Database By Yash Sharma</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
   <?php echo(" <h2>Welcome ".$_SESSION['name']." to the Automobiles Database By Yash Sharma</h2>");?>
    <?php
    //  echo("$_POST('email')"); ?>

    <?php
    if (isset($_SESSION['success'])) {
        echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
        unset($_SESSION['success']);
    }
    ?>

    <ul>

        <?php
        if (isset($_SESSION['name'])) {
            if (sizeof($rows) > 0) {
                echo "<table border='1'>";
                echo " <thead><tr>";
                echo "<th>Name            </th>";
            
                echo " <th>Headline</th>";
            
                echo " <th>Action</th>";
                echo " </tr></thead>";
                foreach ($rows as $row) {
                    echo "<tr><td>";
                    echo('<a href="view.php?profile_id='.$row['profile_id'].'">' .$row['first_name'].' '. $row['last_name']) .'</a>';
                    echo("</td><td>");
                    echo($row['headline']);
                    echo("</td><td>");
                    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / <a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
                    echo("</td></tr>\n");
                }
                echo "</table>";
            }
            // } else {
            //     echo 'No rows found';
            // }
            echo '</li><br/></ul>';
            echo '<p><a href="add.php">Add New Entry</a></p>
    <p><a href="logout.php">Logout</a></p><p>
        <b>Note:</b> Your implementation should retain data across multiple
        logout/login sessions.  This sample implementation clears all its
        data on logout - which you should not do in your implementation.
    </p>';
        } 
        else {

            echo "<p><a href='login.php'>Please log in</a></p><p>Attempt to <a href='add.php'>add data</a> without logging in</p>";
        } 
        ?>
</div>
</body>