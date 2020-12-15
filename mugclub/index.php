<?php
  session_start();
?>
<!doctype html>
<!-- #####################
  Mug Club 1.0
#########################-->
<html lang="en">
<head>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="EXPIRES" CONTENT="0">
  <link href="https://www.leavenbrewing.com/favicon.ico" rel="shortcut icon">
  <title>Leaven Brewing MUG CLUB</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet"> 
  <link href="mugclub.css" rel="stylesheet">
</head>

<body id="Members">
  <?php require 'memLogin.php';
    if($loginInvalid){echo('<h1>That\'s not right!</h1><img src="img/magicWord.gif" width="400">');
  }
  else { ?>
    <h1>Member Login</h1>
    <img src="img/lbmcLogo.gif">
  <?php } ?>
  <?php
    if (!isset($_SESSION['lbmc'])) { ?>
      <div id="Login"> 
        <p>WELCOME Mug Club Member! Log in here for all of the super-secret member goodness.</p>
        <form action="index.php" method="POST" name="logIn">
          <input type="text" name="password"> <input type="submit" class="button" name="passSubmit" value="Log In!">
        </form>
      </div>
    <?php
    }
    else { //user logged in! ?>
      <div id="Members">
        <h1>You are logged in!</h1>
        <form action="index.php" method="POST" name="LogOut">
          <input type="submit" name="logOut" class="button" value="Log OUT">
        </form>
      </div>
    <?php
    } ?>
    <img src="img/MembersOnly.png" id="MembersOnly">

</body>
</html>