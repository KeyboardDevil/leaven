<?php
  session_start();
?>
<!doctype html>
<!-- #####################
  BeerMS - Settings page 1.0
#########################-->
<html lang="en">
  <head>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <META HTTP-EQUIV="EXPIRES" CONTENT="0">
    <link href="https://www.leavenbrewing.com/favicon.ico" rel="shortcut icon">
    <title>BeerMS: Update Your Beer List</title>
    <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="cmsStyle.css">
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-3474776-4"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-3474776-4');
    </script>
  </head>
  <body>
    <?php
    require 'pass.php';
    if (!isset( $_SESSION['MagicKey'] )) {
      echo ("<script>window.location.href = 'index.php';</script>");
    } 
    // ################################
    // Check and process the form
    // ################################
    if (isset( $_SESSION['MagicKey'] )) {
      require 'beersDB.php';
      
      if (isset($_POST["menu"])) {
        $menuTiming = intval($_POST["menuTiming"]);
        $activateMenuSql = "UPDATE settings SET menuTimingToggle=1, menuTiming=".$menuTiming;
        if ($conn->query($activateMenuSql) === TRUE) {
        } else {
          echo "Error: " . $activateMenuSql . "<br>" . $conn->error;
        }
      }
      if (isset($_POST["marketing"])) {
        if ($_POST["marketingContent"] != '' && $_POST["marketingTitle"] != '') {
          $marketingTiming = intval($_POST["marketingTiming"]);
          $marketingScreen = intval($_POST["marketingScreen"]);
          $marketingTitle = htmlentities($_POST["marketingTitle"]);
          $marketingContent = $_POST["marketingContent"];
          $marketingContent = str_replace("\n",'<br>',$marketingContent);
          $activateMarkSql = 'UPDATE settings SET marketingToggle=1, marketingTiming='.$marketingTiming.', marketingScreen='.$marketingScreen.', marketingTitle="'.$marketingTitle.'", marketingContent="'.$marketingContent.'"';
          if ($conn->query($activateMarkSql) === TRUE) {
            // do nothing
          } else {
            echo "Error: " . $activateMarkSql . "<br>" . $conn->error;
          }
        }
      }
      else {
        if (isset($_POST["submitted"])) {
          // kill marketing if unselected, and submitted
          $killMarketing = 'UPDATE settings SET marketingToggle=0';
          if ($conn->query($killMarketing) === TRUE) {
            // do nothing
          } else {
            echo "Error: " . $activateMarkSql . "<br>" . $conn->error;
          }
        }
      }
    // ################################
    // End process form
    // ################################
    ?>
    <div id="BeerMS">
      <form action="index.php" method="POST"><input class="btn btn-danger" type="submit" name="logout" value="LOG OUT of BeerMS"></form>
      <img class="beerMSLogo" src="beerMS.gif" alt="Powered by BeerMS">
    </div>
    <h1>Manage your Settings</h1>

    <form method="post" action="settings.php" id="SettingsForm">
    <input type="hidden" name="submitted" value="1"/>
    <?php
    //####################
    // Render form
    //####################
    // Get DB values
    $_TOGGLEMenu = false;
    $_TOGGLEMarketing = false;
    $marketingTiming=0;
    $marketingScreen=0;
    $marketingTitle='';
    $marketingContent='';
    $sql = 'SELECT menuTimingToggle, menuTiming, marketingToggle, marketingScreen, marketingTiming, marketingTitle, marketingContent FROM settings';
    $dbOutput = $conn->query($sql);
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
          $marketingContent = str_replace('<br>',"\n",$marketingContent);
        }
      }
    }
    $strMenuChecked = '';
    $strMarkChecked = '';
    if($_TOGGLEMenu) { $strMenuChecked = " checked"; }
    if($_TOGGLEMarketing) { $strMarkChecked = " checked"; }
    ?>
    <div class="form-group">
      <label class="switch">
        <input id="MenuSelection" type="checkbox" name="menu"<?php echo ($strMenuChecked); ?>>
        <span class="slider round"></span>
      </label><span class="settingLabels">Customize menu refresh rate</span>
      <div id="RefreshSettings">
        <span class="settingLabels">Refresh menu every:</span>
        <select name="menuTiming">
          <option value="4000"<?php if($menuTiming==4000){echo(' selected');} ?>>4 SECONDS</option>
          <option value="600000"<?php if($menuTiming==600000){echo(' selected');} ?>>10 minutes</option>
          <option value="900000"<?php if($menuTiming==900000){echo(' selected');} ?>>15 minutes</option>
          <option value="1800000"<?php if($menuTiming==1800000){echo(' selected');} ?>>30 minutes</option>
        </select><br/>
      </div>
    </div>

    <div class="form-group">
      <label class="switch">
        <input id="MarketingSelection" type="checkbox" name="marketing"<?php echo ($strMarkChecked); ?>>
        <span class="slider round"></span>
      </label><span class="settingLabels">Enable Marketing messages</span> <img class="helpIcon" src="help.gif">
      <p class="helpMsg">Enabling this feature will replace your menu, for the selected amount of time, with custom content. You can use this to advertise events, brewery swag or for special annoucements. HTML is allowed in Marketing Content.</p>
      <div id="MarketingSettings">
        <span class="settingLabels">Show marketing for:</span>
        <select name="marketingTiming">
          <option value="5000"<?php if($marketingTiming==5000){echo(' selected');} ?>>5 SECONDS</option>
          <option value="60000"<?php if($marketingTiming==60000){echo(' selected');} ?>>60 seconds</option>
          <option value="90000"<?php if($marketingTiming==90000){echo(' selected');} ?>>90 seconds</option>
          <option value="120000"<?php if($marketingTiming==180000){echo(' selected');} ?>>120 seconds</option>
        </select><br/>
        <span class="settingLabels">On screen number:</span>
        <select name="marketingScreen">
          <option value="2"<?php if($marketingScreen==2){echo(' selected');} ?>>2</option>
        </select><br/>
        <span class="settingLabels">Marketing Title</span>
        <input class="form-control" type="text" name="marketingTitle" value="<?php echo ($marketingTitle); ?>">
        <span class="settingLabels">Marketing Content</span>
        <textarea class="form-control" rows="8" name="marketingContent"><?php echo ($marketingContent); ?></textarea>
      </div>
    </div>
    
    <input type="submit" class="btn btn-primary" value="Save Settings"> <input type="button" class="btn btn-warning cancel" value="Cancel Changes">
    
    <?php
      $conn->close();
    ?>
    </form>

    <p class="lastUpd">Code last updated: <?php echo date ("F d Y H:i", getlastmod()); ?></p>

    <?php
      } // close MagicKey check
    ?>

    <script>
      if (!$("#MenuSelection")[0].checked) {$('#RefreshSettings').hide();}
      $('#MenuSelection').click(function showMenu() {$('#RefreshSettings').slideToggle();});
      if (!$("#MarketingSelection")[0].checked) {$('#MarketingSettings').hide();}
      $('#MarketingSelection').click(function showMarketing() {$('#MarketingSettings').slideToggle();});
      $(".cancel").click(function goHome(){window.location.href="index.php"});

      $('.helpIcon').mouseover(function() {
        $('.helpMsg').css('visibility', 'visible');
      });
      $('.helpIcon').mouseout(function() {
        $('.helpMsg').css('visibility', 'hidden');
      });
    </script>


  </body>
</html>