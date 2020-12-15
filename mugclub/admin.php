<?php
  session_start();
?>
<!doctype html>
<!-- #####################
  Mug Club 1.0 ADMIN
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

<body>
  <?php
    require 'memLogin.php';
  ?>
  <?php
    if (!isset($_SESSION['admin'])) { ?>
      <h1>ADMIN Login</h1>
      <div id="Login"> 
        <form action="admin.php" method="POST" name="logIn">
          <input type="text" name="adminPass"> <input type="submit" class="button" name="passSubmit" value="Log In!">
        </form>
      </div>
    <?php
    }
    else { //user logged in! ?>
      <div id="Admin">
        <h1>Upload File</h1>
        <!--<h2>Files and stuff</h2>
        <h3>Other files and stuff</h3>
        <p>some content</p>-->
        <form action="upload.php" method="post" name="UploadEmail" enctype="multipart/form-data">
          <table>
            <tr>
              <td><label for="EmailDate">Date:</label></td>
              <td><input id="EmailDate" type="text" name="EmailDate"></td>
            </tr>
            <tr>
              <td><label for="EmailSubj">Subject:</label></td>
              <td><input id="EmailSubj" type="text" name="EmailSubj"></td>
            </tr>
            <tr>
              <td><label for="EmailPDF">Upload PDF</label></td>
              <td><input type="file" name="EmailPDF" id="EmailPDF"></td>
            </tr>
            <tr><td colspan="2"><input class="button" type="submit" value="UPLOAD"></tr>
            </table>
        </form>
        <h2>Other stuff</h2>
        <form action="index.php" method="POST" name="LogOut">
          <input type="submit" name="logOut" class="button" value="Log OUT">
        </form>
      </div>
    <?php
    } ?>

</body>
</html>