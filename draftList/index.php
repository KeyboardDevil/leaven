<html>
<?php
//header("Content-Type: application/json");

require '../cms/beersDB.php';
$sql = 'SELECT name, abv FROM beers where active=1';
$dbOutput = $conn->query($sql);
if ($dbOutput -> num_rows > 0) {
  while($row = $dbOutput ->fetch_assoc()) {
    $dbName = $row["name"];
    $dbAbv = $row["abv"];
    echo $dbName.'<br>';
  }
}

/*
$json = json_encode($data);
if ($json === false) {
    // Avoid echo of empty string (which is invalid JSON), and
    // JSONify the error message instead:
    $json = json_encode(array("jsonError", json_last_error_msg()));
    if ($json === false) {
        // This should not happen, but we go all the way now:
        $json = '{"jsonError": "unknown"}';
    }
    // Set HTTP response status code to: 500 - Internal Server Error
    http_response_code(500);
}
echo $json;
*/
?>
</html>