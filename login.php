<?php
require_once('db/connect.php');

session_start();

if (!isset($_SESSION['isloggedin']) && isset($_POST['login'])) {
  $username = get_post('username', $db_server);
  $password = $_POST['password'];

  $result = $db_server->query("SELECT username, pass FROM users WHERE username='$username'");
  $db_server->close();
  if ($result->num_rows != 0) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if (password_verify($password, $row['pass'])) {
      session_regenerate_id();
      // set session parameters
      $_SESSION['username'] = $username;
      $_SESSION['isloggedin'] = TRUE;
      $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
    }
  }
}

// sanitize your input
function get_post($var, $conn)
{
  $var = stripslashes($_POST[$var]);
  $var = htmlentities($var);
  $var = strip_tags($var);
  $var = $conn->real_escape_string($var);

  return $var;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telefonbok | logg inn</title>
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
    <h1>Logg inn</h1>
    <?php
    // if not logged in
    if (!isset($_SESSION['isloggedin'])) {
      echo "<form method='post' action='login.php'>
				<table>
					<tr>
						<td>Brukernavn:</td>
						<td>
						<input type='text' name='username'>
						</td>
					</tr>
					<tr>
						<td>Passord:</td>
						<td>
						<input type='password' name='password'>
						</td>
					</tr>
					<tr>
						<td colspan='2'>
						<input type='submit' name='login' value='Logg inn'>
						</td>
					</tr>
				</table>
			</form>";
    } else {
      header('Location: index.php');
    }
    ?>
  </main>
</body>

</html>