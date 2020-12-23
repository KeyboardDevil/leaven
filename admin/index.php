<?php
  session_start();
?>
<!doctype html>
<!-- #####################
  Leaven ADMIN 1.0
#########################-->
<html lang="en">
<head>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="EXPIRES" CONTENT="0">
  <link href="https://www.leavenbrewing.com/favicon.ico" rel="shortcut icon">
  <title>Leaven Brewing Adminstration</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 1.25em;
      background-image: url('uploadBack.gif');
      background-repeat: no-repeat;
    }
    input {
      font-size: 1.2em;
    }
    .button {
      border-radius: 5px;
      background-color: #EF8354;
      padding: 8px 15px 8px 15px;
      cursor: pointer;
      width: 100%;
      margin: 12px 0;
    }
    .button:hover {
      background-color: #f6976e;
    }
    h1, h2, h3 {
      margin: .5em 0 .4em;
    }
    .UploadSection {
      background-color: #0A2239;
      border: 5px solid black;
      border-radius: 15px;
      color: #CDF7F6;
      margin: 15px;
      padding: 5px 10px;
      width: 550px;
    }
  </style>
</head>

<body>
  <?php
    require '../login.php';
  ?>
  <?php
    if (!isset($_SESSION['admin'])) { ?>
      <h1>ADMIN Login</h1>
      <div id="Login">
        <form action="index.php" method="POST" name="logIn">
          <input type="text" name="adminPass"> <input type="submit" class="button" name="passSubmit" value="Log In!">
        </form>
      </div>
    <?php
    }
    else { //user logged in! ?>
      <h1>Upload Stuff!</h1>
      <p>Only PDF files are allowed.</p>
      <div class="UploadSection">
        <h2>Upload a MugClub Email</h2>
        <form action="upload.php" method="post" name="UploadEmail" enctype="multipart/form-data">
          <input type="hidden" name="UploadType" value="email">
          <table>
            <tr>
              <td><label for="EmailDate">Email Date:</label></td>
              <td><input id="EmailDate" type="text" name="EmailDate"></td>
            </tr>
            <tr>
              <td><label for="EmailSubj">Email Subject:</label></td>
              <td><input id="EmailSubj" type="text" name="EmailSubj"></td>
            </tr>
            <tr>
              <td><label for="EmailPDF">Email PDF</label></td>
              <td><input type="file" name="EmailPDF" id="EmailPDF"></td>
            </tr>
            <tr><td colspan="2"><input class="button" type="submit" value="Upload a MugClub Email"></tr>
            </table>
        </form>
      </div>
      <div class="UploadSection">
        <h2>Upload a new TacoNotTaco Menu</h2>
        <p>WARNING: uploading a new menu will overwrite the old one!  <strong>There can be only one</strong>.</p>
        <form action="upload.php" method="post" name="UploadMenu" enctype="multipart/form-data">
          <input type="hidden" name="UploadType" value="menu">
          <input type="file" name="MenuPDF" id="MenuPDF">
          <input class="button" type="submit" value="Upload a new TNT Menu">
        </form>
      </div>
      <div class="UploadSection">
        <h2>Log out</h2>
        <form action="index.php" method="POST" name="LogOut">
          <input type="submit" name="logOut" class="button" value="Log OUT">
        </form>
      </div>
    <?php
    } ?>

</body>
</html>