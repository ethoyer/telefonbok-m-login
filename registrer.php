<?php
require_once('functions/get_post.php');
require_once('db/connect.php');

// registers new user once form is submitted
if (isset($_POST['submit'])) {
  $username = get_post('username', $db_server);
  $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
  //inserts new user into database
  $query = "INSERT INTO users(username, pass) VALUES('$username', '$pass')";
  $db_server->query($query) or die($db_server->error);
  header('Location: login.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telefonbok | registrer ny bruker</title>
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
    <h1>Registrer ny bruker</h1>

    <form method="post" action="registrer.php">
      <table>
        <tr>
          <td>Brukernavn:</td>
          <td>
            <input type="text" name="username">
          </td>
        </tr>
        <tr>
          <td>Passord:</td>
          <td>
            <input type="password" name="pass">
          </td>
        </tr>
        <tr>
          <td colspan='2'>
            <input type="submit" name="submit" value="Register">
          </td>
      </table>
    </form>
    <p>Har du allerede en bruker? <a  id="registrer" href="login.php"> Trykk her for å logge inn.</a></p>
  </main>
</body>

</html>