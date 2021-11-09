<?php
session_start();

if (isset($_POST['cancel'])) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}
unset($_SESSION['error']);

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

require_once "pdo.php";

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['headline'])
    && isset($_POST['email']) && isset($_POST['summary'])) {
    
     if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['first_name']) && strlen($_POST['last_name']) < 1 ) {
        $_SESSION['error'] = 'Name is required';
        header("Location: add.php");
        return;
        
    } else if (strpos($_POST['email'], "@") === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: add.php");
        return;
    } else if (strlen($_POST['headline']) < 1 ) {
        $_SESSION['error'] = 'Headline is required';
        header("Location: add.php");
        return;
    } else if (strlen($_POST['summary']) < 1 ) {
        $_SESSION['error'] = 'Summary is required';
        header("Location: add.php");
        return;
    }
    
        $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :user_id, :fname, :lname, :email, :headline, :summary)');
      
      $stmt->execute(array(
        ':user_id' => $_SESSION['user_id'],
        ':fname' => $_POST['first_name'],
        ':lname' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'])
      );
        $_SESSION['success'] = "Record Added";
        header("Location: index.php");
        return;
    
} 
else {
    $SESSION['error'] = "All fields are required";
    header("Location: sign-up.php");
    return;
} 
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Yash Sharma Autos</title>
</head>
<body>
<div class="container">
    <h1>Tracking Autos for <?php echo $_SESSION['name']; ?></h1>
    <?php
    // Note triple not equals and think how badly double
    // not equals would work here...
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        <p>First Name :

            <input type="text" name="first_name" size="40"/></p>
        <p>Last Name::

            <input type="text" name="last_name" size="40"/></p>
        <p>E-Mail:

            <input type="text" name="email" size="40"/></p>
        <p>Headline:

            <input type="text" name="headline" size="60"/></p>
        <p>Summary:</p>

        <textarea name="summary" type="text" cols="90" rows="15"></textarea>
        <p>
        <input type="submit" name='add' value="Add">
        <input type="submit" name="cancel" value="Cancel"></p>
    </form>


</div>
</body>
</html>