<?php
session_start();

if (isset($_POST['cancel'])) {
    // Redirect the browser to game.php
    header("Location: main.php");
    return;
}

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

require_once "pdo.php";

if (isset($_POST['delete']) && isset($_POST['profile_id'])) {
    $sql = "DELETE FROM profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header('Location: index.php');
    return;
}

// Guardian: Make sure that user_id is present
if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing user_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT first_name,last_name FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php');
    return;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Autos Database By Yash Sharma</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
    <div class="container">
        <p>Confirm: Deleting <?php echo $row['first_name'] ." ". $row['last_name'] ;?></p>
        <form method="post"><input type="hidden" name="profile_id" value="<?php echo $_GET['profile_id'] ?>">
            <input type="submit" value="Delete" name="delete">
            <a href="index.php">Cancel</a>
        </form>
    </div>
</body>