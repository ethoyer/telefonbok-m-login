<?php
require_once('db/connect.php');
require_once('functions/get_post.php');
require_once('functions/logout.php');

session_start();

//logs in
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
  header('Location: index.php');
}

if (isset($_POST['delete'])) { //deletes entry
  $contactID = get_post('contactID', $db_server);
  $query = "DELETE FROM contacts WHERE id=$contactID";
  $result = $db_server->query($query) or die('Query failed:' . $db_server->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telefonbok | hjem</title>
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
    <h1>Telefonbok</h1>
    <?php
    // if not logged in
    if (!isset($_SESSION['isloggedin'])) {
      echo "<form method='post' action='index.php'>
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
      $user = $_SESSION['username'];

      echo "<a href='new_contact.php'><p>+ Legg til ny kontakt.</p></a>";

      $contacts = $db_server->query("SELECT * FROM contacts WHERE contactOwner = '$user'"); // selects all entries from category

      echo "<table id='kontaktliste'>
      <tr><th>Navn</th><th>Tlf.</th><th>Addr.</th></tr>";
      while ($contact = mysqli_fetch_row($contacts)) {
        echo "<tr><td>$contact[1] $contact[2]</td><td>+$contact[3] $contact[4]</td><td>$contact[5], $contact[6]</td>";

        // if user is logged in and they made the entry they can delete it
        if (isset($_SESSION['isloggedin']) && $contact[7] == $_SESSION['username']) {
          echo "<form class='delButton' method='post' action='index.php'>";
          echo "<input type='hidden' name='contactID' value='$contact[0]'>";
          echo "<td><input type='submit' name='delete' value='Slett kontakt'></td>";
          echo "</form>";
        }
      }
      echo "</table>";
    }
    ?>
  </main>

</body>

</html>