<?php
header("Content-Type: application/json");

require '../cms/beersDB.php';
$sql = 'SELECT name FROM beers WHERE active=1';
$dbOutput = $conn->query($sql);
$arrNames = [];
if ($dbOutput -> num_rows > 0) {
  $output = '';
  while($row = $dbOutput ->fetch_assoc()) {
    $dbName = $row["name"];
    $arrNames[] = array("draft" => html_entity_decode($dbName)); 
  }
  
  // build JSON data
  $jsonData = array(
    "titleText"=>"Leaven Brewing draft list",
    "uid"=>"leavenDrafts",
    // ### TODO: Get update date from db
    "updateDate"=>"2019-02-25T00:00:00.0Z",
    "leavenDrafts"=>$arrNames,
    "redirectionUrl"=>"https://www.leavenbrewing.com"
  );
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