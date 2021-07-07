<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telefonbok | setup.php</title>
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <nav>
    <a href="../index.php">Hjem</a>
    <?php //hvis logget ut, vis logg inn og registrer link
    if (!isset($_SESSION['isloggedin'])) {
    ?>
      <a href="../login.php">Logg inn</a>
      <a href="../registrer.php">Registrer</a>
    <?php
    }
    ?>
    <?php //hvis logget inn, vis logg ut form
    if (isset($_SESSION['isloggedin'])) {
    ?>
      <form method="post" action="../functions/logout.php">
        <input type="submit" name="logout" value="Logg ut">
      </form>
      <a href="../delete_user.php">Slett bruker</a>
    <?php
    }
    ?>
  </nav>
  <h1>Setup.php</h1>
</body>

</html>

<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = '';

$db_server = new mysqli($host, $user, $pass, $db);

// create the database
$query = 'CREATE DATABASE IF NOT EXISTS telefonbok';
$db_server->query($query) or die('Query failed:' . $db_server->error);

// select the db
$db_server->select_db('telefonbok') or die('Can not select db:' . $db_server->error);

// create the user table
$query = 'CREATE TABLE IF NOT EXISTS users (
	username VARCHAR(60) PRIMARY KEY,
  	pass VARCHAR(250))';
$db_server->query($query) or die('Query failed:' . $db_server->error);

// create the contacts table
$query = 'CREATE TABLE IF NOT EXISTS contacts (
	id INT PRIMARY KEY auto_increment,
  	fname VARCHAR(60),
    lname VARCHAR(60),
    countryCode INT(10),
    pnumber INT(60),
    addr VARCHAR(60),
    zipcode INT(4),
    contactOwner VARCHAR(60))';
$db_server->query($query) or die('Query failed:' . $db_server->error);

echo "Created Database and tables.";

// insert 3 users into user table with hashed password
$pw = password_hash('12345', PASSWORD_DEFAULT);
$query = "INSERT INTO users(username, pass) VALUES('carljr', '$pw')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$pw = password_hash('passord', PASSWORD_DEFAULT);
$query = "INSERT INTO users(username, pass) VALUES('katrine91', '$pw')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$pw = password_hash('banan', PASSWORD_DEFAULT);
$query = "INSERT INTO users(username, pass) VALUES('mortenløk', '$pw')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

//inserts 2-4 contacts to each user
$query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('Ole', 'Olsen', 47, 98653676, 'Sitronvegen 7', '1323', 'katrine91')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('Maya', 'Nguyen', 47, 76493820, 'Sitronvegen 11', '1323', 'carljr')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('Kjersti', 'Johnssen', 47, 34567832, 'Pæreveien 13', '1412', 'mortenløk')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('Kari', 'Johansen', 47, 50695837, 'Eplegata 50', '2815', 'carljr')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('Mohammed', 'Abdel', 47, 56938240, 'Pæreveien 7', '1412', 'carljr')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('Maria', 'Høyer', 47, 76452378, 'Bananbyen 1', '1034', 'katrine91')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('Mamma', 'Høyer', 47, 55783245, 'Bananbyen 2', '1034', 'mortenløk')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('Morten', 'Høyer', 47, 22356783, 'Bananbyen 2', '1034', 'carljr')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$query = "INSERT INTO contacts(fname, lname, countryCode, pnumber, addr, zipcode, contactOwner) VALUES('Katrine', 'Johnssen', 47, 54789324, 'Pæreveien 13', '1412', 'mortenløk')";
$db_server->query($query) or die('Query failed:' . $db_server->error);

$db_server->close();
?>