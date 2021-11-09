<?php

session_start();
require_once "pdo.php";

if (isset($_POST['Done'])) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}


// Guardian: Make sure that profile_id is present
if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare('SELECT * FROM  Profile  where profile_id = :xyz');
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php');
    return;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YASH SHARMA DATABSAE VIEW</title>
</head>
<body>
<div class="container">
<h1>Profile information</h1>
<?php echo '<p>First Name: ' . $row['first_name'].'</p>'; ?>

<?php echo "<p>Last Name: ". $row['last_name']."</p>"; ?>

<?php echo " <p>Email: ".$row['email']."</p>"; ?>
<!-- <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="b1f4dcd0d8ddf1">[email&#160;protected]</a></p> -->
<?php echo "<p>Headline: ".$row['headline']."</p>"; ?>
 <p>Summary:
<?php
if (!isset($row['summary'])) {
    echo("No Summary here.Try to write Some!!!");
    return;
}  else if (isset($row['summary'])) {
    echo $row['summary'];
    return;
}
 ?>

</p>
<p>
<!-- <input type="button" value="Done"> -->
<input type="submit" name="cancel" value="Done">
</p>
</div>
<!-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
    
</body>
</html>