<?php
require_once('db/connect.php');
require_once('functions/get_post.php');
require_once('functions/logout.php');

session_start();
$user = $_SESSION['username'];

// deletes user if delete is clicked
if (isset($_POST['delete_user'])) {
  $query = "DELETE FROM contacts WHERE contactOwner='$user'";
  $result = $db_server->query($query) or die('Query failed:' . $db_server->error);

  //sletter bruker
  $query = "DELETE FROM users WHERE username='$user'";
  $result = $db_server->query($query) or die('Query failed:' . $db_server->error);


  //destroys cookie session and logs out
  $_SESSION = array();
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	}
	session_destroy();
	header('Location: index.php');
}


$contactAmount = $db_server->query("SELECT COUNT(*) FROM contacts WHERE contactOwner = '$user'"); //teller antall kontakter brukeren har i databasen
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telefonbok | slett bruker</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
<nav>
    <a href="index.php">Hjem</a>
    <?php //hvis logget ut, vis logg inn og registrer link
    if (!isset($_SESSION['isloggedin'])) {
    ?>
    <a href="login.php">Logg inn</a>
    <a href="registrer.php">Registrer</a>
    <?php
    }
    ?>
    <?php //hvis logget inn, vis logg ut form
    if (isset($_SESSION['isloggedin'])) {
    ?>
      <form method="post" action="functions/logout.php">
        <input type="submit" name="logout" value="Logg ut">
      </form>
      <a href="delete_user.php">Slett bruker</a>
    <?php
    }
    ?>
  </nav>

  <main>
    <h1>Slett bruker</h1>
    <?php
    echo "<p>Er du sikker på at du vil slette din bruker, $user?</p>
    <p>Du har ";
    if (mysqli_num_rows($contactAmount) > 0) {
      while($contactData = mysqli_fetch_array($contactAmount)){
          echo $contactData[0];
      }
    }
    echo " kontakter på din liste som vil bli slettet.</p>";
   
    ?>
          <form method="post" action="delete_user.php">
        <input type="submit" name="delete_user" value="Slett min bruker.">
      </form>
  </main>

</body>

</html>