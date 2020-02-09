<!doctype html>
<html lang="en">

<?php
  // Settings for Leaven Brewing menu  
?>
<head>
  <meta charset="UTF-8">
  <title>Menu</title>
  <style>
    @font-face {
      font-family: Futura-Round;
      src: url("fonts/FuturaRound-Bold.woff") format("woff"), url("fonts/FuturaRound-Bold.ttf") format("truetype");
    }
    @font-face {
      font-family: Kapra-Neue;
      src: url("fonts/KapraNeue-MediumCondensed.woff") format("woff"), url("fonts/KapraNeue-MediumCondensed.ttf") format("truetype");
    }
    body {
      font-family: Futura-Round;
      text-align: center;
      font-size: 2em;
      background-color: #232c34;
      color: white;
      margin-top: 35px;
    }
    a, a:visited, a:active {
      color: white;
    }
    .logo {
      text-align: center;
      margin: -30px 0;
    }
    h1 {
      margin: 0.25em 0;
    }
    #Settings {
      width: 60%;
    }
    #Welcome {
      font-size: 0.8em;
      margin: 15px 0;
    }
    .formRow {
      padding: 0.3em 0;
    }
    .formSection {
      display: flex;
      justify-content: right;
    }
    .formSection input,select{
      font-size: 24px;
      margin-left: 2em;
      width: 250px;
    }
    .warning {
      width: 40%px;
    }
    .warning, .warning input {
      font-size: 1em;
    }
    #MenuFooter {
      display: flex;
      min-width: 100%;
      height: 78px;
      color: black;
      position: fixed;
      bottom: 0;
      background: lightblue;
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
    .SubmitButton {
      background: rgb(28, 184, 65);
      text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
      border: 1px solid white;
      border-radius: 4px;
    }
    .SubmitButton:hover {
      background: white;
      cursor: pointer;
    }
    </style>
</head>

<body>
  <h1>Menu Settings</h1>
  <div id="Welcome">
    Welcome to the settings page! Here you can customize your digital menu.
  </div>
  <?php
    require '../cms/pass.php';
      if (!isset( $_SESSION['MagicKey'] )) {
    ?>
    <div class="warning">
      <p>You must enter your password to continue.</p>
      <form method="post" action="settings.php">
        <input type="password" name="password" size="8"> <input type="submit" name="submit" value="Submit">
      </form>
    </div>
    <?php
    }
    else {
      ?>
      <!-- Settings Form -->
      <form id="Settings" method="post" action="settings.php">
        <div class="formRow">
          <div class="formSection">
            Menu Custom Color: 
            <select name="customColor">
              <option value="lightblue">Light Blue</option>
              <option value="fff">White</option>
              <option value="333">Red</option>
            </select>
          </div>
        </div>
        <div class="formRow">
          <div class="formSection">
            Footer content LEFT <input type="text" name="footerLeft" />
          </div>
        </div>
        <div class="formRow">
          <div class="formSection">
            Your Insta/Facebook <input type="text" name="instaFacebook" value="@" />
          </div>
        </div>
        <div class="formRow">
          <div class="formSection">
            Your Hashtag: <input type="text" name="hashtag" value="#" />
          </div>
        </div>
        <div class="formRow">
          <div class="formSection">
            <input class="SubmitButton" type="submit" name="submit" value="Save It!" />
          </div>
        </div>
      </form>
      <!-- ###############
      EXAMPLE FOOTER
      ################ -->
      <div id="MenuFooter">
        <div class="footerPanel">
          <span class="footerSmall">Footer content LEFT</span> <span class="menuBig">&nbsp; @YourInsta&Facebook</span>
        </div>
        <img class="footerLogo" src="img/logoFake.png">
        <div class="footerPanel">
          <span class="menuBig">#YourHashtag</span>
        </div>
      </div>
      <?php
    } ?>
</body>

</html>