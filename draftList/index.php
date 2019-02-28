<?php
//header("Content-Type: application/json");

require '../cms/beersDB.php';
$sql = 'SELECT name FROM beers WHERE active=1';
$dbOutput = $conn->query($sql);
echo '<h2>testing</h2>';
if ($dbOutput -> num_rows > 0) {
  $output = '';
  while($row = $dbOutput ->fetch_assoc()) {
    $dbName = $row["name"];
    $output = $output.$dbName.". ";
  }
  echo $output;
}

/*
// format and return JSON
$json = json_encode($data);
if ($json === false) {
  $json = json_encode(array("jsonError", json_last_error_msg()));
  if ($json === false) {
    $json = '{"jsonError": "unknown"}';
  }
  http_response_code(500);
}
echo $json;
*/
?>