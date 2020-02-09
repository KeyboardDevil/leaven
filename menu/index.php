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
    a, a:visited, a:active {
      color: white;
    }
    @font-face {
      font-family: Futura-Round;
      src: url("fonts/FuturaRound-Bold.woff") format("woff"), url("fonts/FuturaRound-Bold.ttf") format("truetype");
    }
    @font-face {
      font-family: Kapra-Neue;
      src: url("fonts/KapraNeue-MediumCondensed.woff") format("woff"), url("fonts/KapraNeue-MediumCondensed.ttf") format("truetype");
    }
    #LogoBack {
      height: 900px;
      background: url('img/kjBack.jpg') center no-repeat;
    }
    #ScreenChoice {
      padding-bottom: .4em;
      text-align: center;
    }
    form {
      text-align: center;
      margin-top: 2em;
    }
    .whichScreen {
      width: 15em;
      height: 4em;
      font-family: futura-Round;
      background-color: darkred;
      color: white;
      border-radius: 10px;
      border: dashed 3px;
      font-size: 25px;
      margin: 0 125px;
    }
    .whichScreen:hover {
      background-color: #f7c118;
      border: solid 3px darkred;
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
      font-size: 155px;
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
      width: 50%;
      text-align: center;
    }
    #MenuEditLink {
      font-size: 40px;
      font-family: Kapra-Neue;
      color: white;
    }
    #MenuEditLink:hover {
      color: #f7c118;
    }
    #MenuFooter {
      display: flex;
      min-width: 100%;
      height: 78px;
      color: black;
      position: fixed;
      bottom: 0;
      background: #f7c118;
    }
    .footerPanel {
      width: 50%;
      line-height: 70px;
      font-family: Futura-Round;
      font-size: 24px;
      text-transform: uppercase;
      text-align: center;
    }
    .footerSmall {
      line-height: 68px;
    }
    .menuBig {
      font-size: 34px;
    }
    .footerLogo {
      position: fixed;
      bottom: 0;
      left: 890px;
    }
    #DevilLogo {
      position: absolute;
      z-index: 99;
      right: 20px;
      bottom: 90px;
      opacity: 0.5;
    }
    #Offline {
      position: absolute;
      display: none;
      bottom: 80px;
      left: 10px;
      z-index: 99;
    }
  </style>
</head>

<body>
  <?php
  require '../cms/beersDB.php';
  $screenID = null;
  if (!isset($_GET["screenID"])) {
    // No screen selected
    echo '<div id="LogoBack">';
    echo '<div id="ScreenChoice">';
    echo '<h1>Which screen is this?</h1>';
    echo '<span id="MenuEditLink"><a href="../cms/">Edit the beer list</a></span>';
    echo '<form name="Screen" method="get" action="index.php"><input type="submit" class="whichScreen" name="screenID" value="1">';
    echo '<input type="submit" class="whichScreen" name="screenID" value="2"></form>';
    echo '</div>';
    echo '</div>';
  } else {
    $screenID = $_GET["screenID"];
    $sql = 'SELECT * FROM beers WHERE active=1';
    $dbOutput = $conn->query($sql);
    $rowCount = $dbOutput->num_rows;

    // Adrian!  Let the PHP run THROUGH YOU!  COME to the DARK SIDE!
    if ($screenID == 1) {
      $start = 0;
      $end = round(($rowCount / 2), 0, PHP_ROUND_HALF_UP);
    } else {
      $start = round(($rowCount / 2), 0, PHP_ROUND_HALF_UP);
      $end = $rowCount;
    }

    $iCount = 0;
    if ($rowCount > 0) {
      while ($row = $dbOutput->fetch_assoc()) {
        if ($iCount >= $start && $iCount < $end) {
          $dbName = $row["name"];
          $dbAbv = $row["abv"];
          $dbShortDesc = $row["shortdescription"];
          $renderRow = false;
          // Let's render this son of a bitch!
          if (($iCount - $start) % 2 == 0) {
            $renderRow = true;
          }
          if ($renderRow) {
            echo "<div class=\"row\">\n";
          }
          echo "<div class=\"beer\">\n";
          echo "<h1>$dbName</h1>\n";
          echo "<h2>$dbAbv</h2>\n";
          echo "<h3>$dbShortDesc</h3>\n";
          echo "</div>\n";
          if (!$renderRow) { // if false, end that row, close that bastard
            echo "</div>\n";
          }
        }
        $iCount++;
        if (($iCount - $start) > 5) {
          break;
        }
      }
    }
    if ($screenID == 2) {
      echo '<img src="img/devil.gif" id="DevilLogo">';
    }
  }
  ?>
  </div>
  <img src="img/offline.gif" id="Offline">
  <div id="MenuFooter">
    <div class="footerPanel">
      <span class="footerSmall">facebook / instagram</span> <span class="menuBig">&nbsp; @Leavenbrewing</span>
    </div>
    <img class="footerLogo" src="img/logo.png">
    <div class="footerPanel">
      <span class="menuBig">#Leavenbrewing</span>
    </div>
  </div>
</body>

<script>
  // MONEY SHOT! Reload every 15 mins if internet is up ;)
  // if internet is down, show OFFLINE image
  setInterval(function(){ if (navigator.onLine) {window.location.href=window.location.href;} else{ document.getElementById('Offline').setAttribute("style","display:block;"); }}, 900000);
</script>

</html>