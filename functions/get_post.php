<?php
// sanitizes input
function get_post($var, $conn)
{
  $var = stripslashes($_POST[$var]);
  $var = htmlentities($var);
  $var = strip_tags($var);
  $var = $conn->real_escape_string($var);

  return $var;
}

?>