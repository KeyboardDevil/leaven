<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="StyleSheet" href="style.css" />
    <title>Menu 2</title>
  </head>
  <body>
    <?php
      require '../cms/beersDB.php';
      $iCount = 1;
      $iRow = 0;
      $sql = 'SELECT * FROM beers WHERE active=1';
      $dbOutput = $conn->query($sql);
      $rowCount = $dbOutput -> num_rows;
      if ($rowCount > 0) {
        while($row = $dbOutput ->fetch_assoc()) {
          $dbName = $row["name"];
          $dbAbv = $row["abv"];
          $dbShortDesc = $row["shortdescription"];
          // Skip the first 6 (there's a better way to do this LOL, TODO)
          if ($iRow > 6) {
            // Let's render this son of a bitch!
            $renderRow = false;
            if ($iCount%2==0) {$renderRow = true;}
            if($renderRow) {echo"<div class=\"row\">\n";}
            echo "<div class=\"beer\">\n";
            echo "<h1>$dbName</h1>\n";
            echo "<h2>$dbAbv</h2>\n";
            echo "<h3>$dbShortDesc</h3>\n";
            echo "</div>\n";
            if(!$renderRow || $iRow == ($rowCount-1)) {echo"</div>\n";}
          }
          $iRow++;
          $iCount++;
          // After 12 beers, we're out of room! BREAK YO SELF FOOL!
          if($iRow>12){break;}
        }
      }
    ?>
    <img id="MenuFooter" src="img/menuFooter.gif">
  </body>
</html>