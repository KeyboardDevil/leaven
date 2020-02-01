<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="StyleSheet" href="style.css" />
    <title>Menu</title>
    <style>
      body {
        background-color: black;
        color: white;
        text-transform: uppercase;
        margin-top: 35px;
      }
      @font-face {
        font-family: Futura-Round;
        src: url("fonts/FuturaRound-Bold.woff") format("woff"), url("fonts/FuturaRound-Bold.ttf")  format("truetype");
      }
      @font-face {
        font-family: Kapra-Neue;
        src: url("fonts/KapraNeue-MediumCondensed.woff") format("woff"), url("fonts/KapraNeue-MediumCondensed.ttf")  format("truetype");
      }
      #ScreenChoice {
        padding-bottom: 1em;
        text-align: center;
      }
      form {
        text-align: center;
      }
      .whichScreen {
        width: 15em;
        height: 4em;
        font-family: futura-Round;
        background-color: darkred;
        color: white;
        border-radius: 10px;
        border: dashed 2px;
        font-size: 25px;
        margin: 0 125px;
      }
      .whichScreen:hover {
        background-color: #f7c118;
        border: solid 3px;
        color: black;
        cursor: pointer;
      }
      h1,h2,h3 {
        margin: 0;
        padding: 0;
      }
      h1,h3 {
        font-family: Kapra-Neue;
      }
      h1 {
        font-size:155px;
        text-transform: uppercase;
        margin-bottom: 20px;
        max-height: 150px;
        width: 100%;
        overflow: hidden;
      }
      h2 {
        font-family: Futura-Round;
        color: #f7c118;
        font-size: 30px;
      }
      h3 {
        font-size: 45px;
        color: #f7c118;
      }
      .row {
        display: flex;
        flex-direction: row;
        padding-bottom: 25px;
      }
      .beer {
        width:50%;
        text-align: center;
      }
      #MenuFooter {
        max-width: 100%;
        position: fixed;
        bottom: 0;
      }
      #DevilLogo {
        position: absolute;
        z-index: 99;
        right: 20px;
        bottom: 100px;
      }
    </style>
  </head>
  <body>
    <?php
      require '../cms/beersDB.php';
      $screenID = null;
      if (!isset($_GET["screenID"])) {
        // No screen selected
        echo '<h1 id="ScreenChoice">Which screen is this?</h1>';
        echo '<form name="Screen" method="get" action="index.php"><input type="submit" class="whichScreen" name="screenID" value="1">';
        echo '<input type="submit" class="whichScreen" name="screenID" value="2"></form>';
      }
      else {
        echo '<meta http-equiv="refresh" content="120"/>';
        $screenID = $_GET["screenID"];
        if ($screenID == 1) {
          $iCount = 0;
          $sql = 'SELECT * FROM beers WHERE active=1';
          $dbOutput = $conn->query($sql);
          $rowCount = $dbOutput -> num_rows;
          if ($rowCount > 0) {
            while($row = $dbOutput ->fetch_assoc()) {
              $dbName = $row["name"];
              $dbAbv = $row["abv"];
              $dbShortDesc = $row["shortdescription"];
              $renderRow = false;
              // Let's render this son of a bitch!
              if ($iCount%2==0) {$renderRow = true;}
              if($renderRow) {
                echo"<div class=\"row\">\n";
              }
              echo "<div class=\"beer\">\n";
              echo "<h1>$dbName</h1>\n";
              echo "<h2>$dbAbv</h2>\n";
              echo "<h3>$dbShortDesc</h3>\n";
              echo "</div>\n";
              if(!$renderRow) { // if false, end of row, close that bastard
                echo"</div>\n";
              }
              $iCount++;
              // After 6 beers, BREAK YO SELF FOOL!
              if($iCount>5){break;}
            }
          }
        }
        if ($screenID == 2) {
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
            echo '<img src="img/devil.jpg" id="DevilLogo">';
          }
        }
      }
    ?>
    <img id="MenuFooter" src="img/menuFooter.gif">
  </body>
</html>