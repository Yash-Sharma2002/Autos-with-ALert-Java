<?php



session_start();
// unset($_SESSION['error']);

if (isset($_POST['cancel'])) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}
if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

require_once "pdo.php";

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['headline'])
    && isset($_POST['email'])) {


    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1) {
        $_SESSION['error'] = 'Name is required';
        header("Location: edit.php?profile_id=" . $_GET['profile_id']);
        return;
    } else if (strpos($_POST['email'], "@") === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: edit.php?profile_id=" . $_GET['profile_id']);
        return;
    } else if (strlen($_POST['headline']) < 1) {
        $_SESSION['error'] = 'Headline is required';
        header("Location: edit.php?profile_id=" . $_GET['profile_id']);
        return;
    } 
    $stmt = $pdo->prepare("UPDATE profile SET first_name = ':fname',
    last_name = ':lname', email = ':email', headline=':headline',
    summary = ':summary'
    WHERE profile_id = ':profile_id'");
    $stmt->execute(
        array(
            ':fname' => $_POST['first_name'],
            ':lname' => $_POST['last_name'],
            ':email' => $_POST['email'],
            ':headline' => $_POST['headline'],
            ':summary' => $_POST['summary'],
            ':profile_id' => $_GET['profile_id']
        )
    );
    $_SESSION['success'] = 'Record Updated';
    header('Location: index.php');
    return;
}

// Guardian: Make sure that user_id is present
if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
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
    <?php require_once "bootstrap.php"; ?>
    <title>Yash Sharma 's Edit Page</title>
</head>

<body>
    <div class="container">
        <h1>Editing Profile</h1>
        <?php
        // Flash pattern
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
            unset($_SESSION['error']);
        }
        ?>
        <form method="post">
            <p>First Name<input type="text" name="first_name" size="40" value="<?php echo $row['first_name'] ?>" /></p>
            <p>Last Name<input type="text" name="last_name" size="40" value="<?php echo $row['last_name'] ?>" /></p>
            <p>E-Mail<input type="text" name="eamil" size="30" value="<?php echo $row['email'] ?>" /></p>
            <p>Headline<input type="text" name="headline" size="60" value="<?php echo $row['headline'] ?>" /></p>
            <p>Summary </p>
            <p> <textarea name="summary" type="text" cols="90" rows="15"><?php echo $row['summary']; ?></textarea></p>
            <input type="hidden" name="profile_id" value="<?php echo $_GET['profile_id'] ?>">
            <input type="submit" name="Update" value="Update">
            <input type="submit" name="cancel" value="Cancel">

        </form>
        <p>
    </div>
</body>

</html>