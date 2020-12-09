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
  <link href="mugclub.css" rel="stylesheet">
</head>

<body>

  <div id="Login">
    <img src="img/lbmcLogo.gif">
    <form action="index.php" method="POST" name="logIn">
      <input type="text" name="password"> <input type="submit" name="passSubmit" value="Log In!">
    </form>
  </div>

</body>
</html>