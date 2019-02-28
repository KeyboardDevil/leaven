<?php
header("Content-Type: application/json");

require '../cms/beersDB.php';
$sql = 'SELECT name FROM beers WHERE active=1';
$dbOutput = $conn->query($sql);
$jsonString = '';
if ($dbOutput -> num_rows > 0) {
  $output = '';
  while($row = $dbOutput ->fetch_assoc()) {
    $dbName = $row["name"];
    $output = $output.$dbName.". ";
  }
  //echo $output;
  // build JSON string
  $jsonData = '{
  "HTTP Content-Type Header":"application/json",
  "titleText":"Leaven Brewing draft list",
  "uid": "leavenDrafts",
  "updateDate": "2019-02-25T00:00:00.0Z",
  "leavenDrafts": [
    {"mainText": "Frank\'s stout",
    "abv": "12.1 %"},
    {"mainText": "Cheeky Monkey",
    "abv": "8.5 %"},
    {"mainText": "Adrian loves sours",
    "abv": "4 %"}],
  "redirectionUrl": "https://www.leavenbrewing.com"
  }';
}

// format and return JSON
$json = json_encode($jsonData);
if ($json === false) {
  $json = json_encode(array("jsonError", json_last_error_msg()));
  if ($json === false) {
    $json = '{"jsonError": "unknown"}';
  }
  http_response_code(500);
}
echo $json;

?>