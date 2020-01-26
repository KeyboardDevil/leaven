<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="StyleSheet" href="style.css" />
    <title>Menu</title>
  </head>
  <body>
    <!--<div class="row">
      <div class="beer">
        <h1>Beer Name</h1>
        <h2>Beer style • beer ABV</h2>
        <h3>Beer description</h3>
      </div>
    </div>-->
    <?php
      // DB connection
      require '../cms/beersDB.php';
      // Get the current list
      $iCount = 0;
      $sql = 'SELECT * FROM beers WHERE active=1';
      $dbOutput = $conn->query($sql);
      if ($dbOutput -> num_rows > 0) {
        while($row = $dbOutput ->fetch_assoc()) {
          $dbName = $row["name"];
          $dbAbv = $row["abv"];
          $dbShortDesc = $row["shortdescription"];
          $renderRow = false;
          if ($iCount%2==0) {$renderRow = true;}
          if($renderRow) {
            echo"<div class=\"row\">\n";
          }
          echo "<div class=\"beer\">\n";
          echo "<h1>$dbName</h1>\n";
          echo "<h2>$dbAbv</h2>\n";
          echo "<h3>$dbShortDesc</h3>\n";
          echo "</div>\n";
          if(!$renderRow) { // if false, end of row, close it
            echo"</div>\n";
          }
          $iCount++;
          // after 6 beers, BREAK
          if($iCount>5){break;}
        }
      }
    ?>
    <div id="MenuFooter">
      <!-- footer -->
    </div>
  </body>
</html>
