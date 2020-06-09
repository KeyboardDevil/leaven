<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Menu</title>
  <link rel="stylesheet" href="style.css">
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="EXPIRES" CONTENT="0">
</head>

<body>
  <?php
  require '../cms/beersDB.php';
  $_TOGGLEMarketing = false;
  $settingsSql = 'SELECT menuTimingToggle, menuTiming, marketingToggle, marketingScreen, marketingTiming, marketingTitle, marketingContent FROM settings';
  $dbOutput = $conn->query($settingsSql);
  if ($dbOutput) {
    while($row = $dbOutput ->fetch_assoc()) {
      $_TOGGLEMenu = $row["menuTimingToggle"];
      $_TOGGLEMarketing = $row["marketingToggle"];
      if ($_TOGGLEMenu) {
        $menuTiming = $row["menuTiming"];
      }
      if ($_TOGGLEMarketing) {
        $marketingTiming = $row["marketingTiming"];
        $marketingScreen = $row["marketingScreen"];
        $marketingTitle = $row["marketingTitle"];
        $marketingContent = $row["marketingContent"];
      }
    }
  }
  $isAd = false;
  if ($_TOGGLEMarketing && isset($_GET["screenID"]) && isset($_GET["isAd"]) && $_GET["isAd"]) {
    $isAd = 'true';
  }
  if ($isAd && $_GET["screenID"]==$marketingScreen) {
    // this is an ad
    echo '<div id="LogoBack" class="adSpace">';
    echo '<h1>'.$marketingTitle.'</h1>';
    echo '<p class="ad">'.$marketingContent.'</p>';
    echo '</div>';
  }
  else {
    $screenID = null;
    // this is not an ad, show menu
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
        echo '<img src="img/poweredBy.gif" id="BeerMSLogo">';
      }
    }
    echo '</div>';
  } // End isAd else
  ?>
  <img src="img/offline.gif" id="Offline">
  <div id="MenuFooter">
    <div class="footerPanel">
      <span class="footerSmall">facebook / instagram</span> <span class="menuBig">&nbsp; @Leavenbrewing</span>
    </div>
    <img class="footerLogo" src="img/logoNew.png">
    <div class="footerPanel">
      <span class="menuBig">#Leavenbrewing</span>
    </div>
  </div>
</body>

<?php
if (isset($_GET["screenID"])) {
?>
  <script type="text/javascript">
    <?php
      // Ad string
      $url = '';
      $reloadTime = '5000';
      $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      if (isset($_GET["isAd"]) && $_GET["isAd"]="true") {
        $url = str_replace("&isAd=true","", $actual_link);
        $reloadTime = $marketingTiming;
      }
      else if ($_TOGGLEMarketing) {
        // is Ad
        $url = $actual_link."&isAd=true";
        $reloadTime = $menuTiming;
      }
      echo 'let strURL = "'.$url.'";';
      echo 'let reloadTime = "'.$reloadTime.'";';
    ?>
    
    setInterval(function(){if(navigator.onLine){window.location.href=strURL;}else{document.getElementById('Offline').setAttribute("style","display:block;");}},reloadTime);
  </script>
<?php
}
?>
</html>