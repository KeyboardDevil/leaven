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
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Lato&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Lato', sans-serif;
      font-size: 1.5em;
      background-image: url('uploadBack.gif');
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    input {
      font-size: 1.2em;
    }
    .button {
      border-radius: 5px;
      background-color: #1B98E0;
      padding: 8px 15px 8px 15px;
      cursor: pointer;
      width: 100%;
      margin: 12px 0;
      color: black;
    }
    .button:hover {
      background-color: #E8F1F2;
    }
    .uploadFile {
      border-radius: 5px;
      background-color: #EB5160;
      padding: 8px 15px 8px 15px;
      cursor: pointer;
      margin: 12px 0;
      color: white;
    }
    h1 {
      text-shadow: 2px 2px 5px #1B98E0;
    }
    h1, h2, h3 {
      margin: .5em 0 .4em;
    }
    h1 {
      font-family: 'Bangers', cursive;
      font-size: 3em;
    }
    .warning {
      color: yellow;
      font-weight: bold;
    }
    .UploadSection {
      background-color: #0A2239;
      border-radius: 15px;
      color: white;
      margin: 15px;
      padding: 5px 10px;
      width: 40%;
    }
    .flexIt {
      display: flex;
    }
    .qr {
      margin: 38px;
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
      <div class="UploadSection">
        <form action="index.php" method="POST" name="logIn">
          <label for="Password">Enter your password: </label>
          <input id="Password" type="text" name="adminPass"> <input type="submit" class="button" name="passSubmit" value="Log In!">
        </form>
      </div>
    <?php
    }
    else { //user logged in! ?>
      <h1>Leaven Administration</h1>
      <p>Only PDF files are allowed. Each section works independently, you can upload a menu <strong>or</strong> an email.</p>
      <div class="flexIt">
        <div class="UploadSection">
          <h2>Upload a new TacoNotTaco Menu</h2>
          <p>WARNING: uploading a new menu <span class="warning">will overwrite</span> the old one!</p>
          <form action="upload.php" method="post" name="UploadMenu" enctype="multipart/form-data">
            <input type="hidden" name="UploadType" value="menu">
            <input class="uploadFile" type="file" name="MenuPDF" id="MenuPDF">
            <input class="button" type="submit" value="Upload a new TNT Menu">
          </form>
        </div>
        <a href="tntQRmenu.jpg" target="_blank"><img class="qr" src="tntQRmenu.jpg" width="200" height="200"></a>
      </div>
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
              <td><input class="uploadFile" type="file" name="EmailPDF" id="EmailPDF"></td>
            </tr>
            </table>
            <input class="button" type="submit" value="Upload a MugClub Email"></td>
        </form>
      </div>
      <div class="UploadSection">
        <h2>Edit Beers!</h2>
        <p>Edit the BeerMS Menu</p>
        <form action="../cms/index.php" method="POST" name="LogOut">
          <input class="button" type="submit" value="Go to BeerMS">
        </form>
      </div>
      <div class="UploadSection">
        <h2>Log out</h2>
        <p>Log out and go back to LeavenBrewing</p>
        <form action="index.php" method="POST" name="LogOut">
          <input type="submit" name="logOut" class="button" value="Log OUT">
        </form>
      </div>
    <?php
    } ?>

</body>
</html>