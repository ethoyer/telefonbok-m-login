<?php
require_once('functions/get_post.php');
require_once('db/connect.php');
session_start();

// creates new entry upon submit
if (isset($_POST['submit'])) {
  $fname = get_post('fname', $db_server);
  $lname = get_post('lname', $db_server);
  $countryCode = get_post('countryCode', $db_server);
  $pnumber = get_post('pnumber', $db_server);
  $addr = get_post('addr', $db_server);
  $zipcode = get_post('zipcode', $db_server);
  $author = $_SESSION['username'];

  // $query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('$fname', '$lname', '$countryCode', '$pnumber', '$addr', '$zipcode', '$author')";
  // $db_server->query($query) or die($db_server->error);

  function kontakt_alert($msg){
    echo "<script>alert('$msg');</script>";
  }

  kontakt_alert($fname . " " . $lname . " har blitt lagt til i dine kontakter.");
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telefonbok | legg til kontakt</title>
  <link rel="stylesheet" href="style.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
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
    <h1>Legg til kontakt</h1>
    <p id="feedback"></p>
    <form method="post" action="new_contact.php">
      <table>
        <tr>
          <td>Fornavn*: </td>
          <td>
          <input type="text" name="fname" maxlength="60" required>
          </td>
        </tr>
        <tr>
          <td>Etternavn*: </td>
          <td>
            <input type="text" name="lname" maxlength="60" required>
          </td>
        </tr>
        <tr>
          <td>Country code*: </td>
          <td>
            <input type="number" name="countryCode" maxlength="10" required>
          </td>
        </tr>
        <tr>
          <td>Tlf. nummer*: </td>
          <td>
            <input type="number" name="pnumber" maxlength="60" required>
          </td>
        </tr>
        <tr>
          <td>Addresse: </td>
          <td>
            <input type="text" name="addr" maxlength="60">
          </td>
        </tr>
        <tr>
          <td>Postnummer: </td>
          <td>
            <input type="number" name="zipcode" maxlength="4">
          </td>
        </tr>
        <tr>
          <td colspan='2'>
          <input type="submit" name="submit" value="Legg til kontakt">
          </td>
        </tr>
      </table>
    </form>
    <p id="asterisk">* disse feltene må fylles ut</p>
  </main>

</body>
<script>
function newContactMessage(message){
  $('#feedback').html(message);
}
  </script>

</html>