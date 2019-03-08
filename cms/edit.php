<!doctype html>
<!-- ############
  Edit beer 0.1
##############-->
<html lang="en">
  <head>
    <link href="https://www.leavenbrewing.com/favicon.ico" rel="shortcut icon">
    <title>Update the Beer List</title>
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
  <body class="editPage">
    <?php
    // Check and process the form
    $beerID = null;
    if (!isset($_GET["id"])) {
      echo 'ID not set!';
    }
    else {
      $beerID = $_GET["id"];
    }
    $image = null;
    $name = null;
    $abv = null;
    $description = null;
    $active = null;
    $setActive = true;
    require 'beersDB.php';

    // SUBMIT Edit
    if (isset($_POST["newBeerImage"]) && isset($_POST["newBeerName"]) && isset($_POST["newBeerAbv"]) && isset($_POST["newBeerDescription"])) {
      $image = htmlentities($_POST["newBeerImage"]);
      $name = htmlentities($_POST["newBeerName"]);
      $abv = htmlentities($_POST["newBeerAbv"]);
      $description = htmlentities($_POST["newBeerDescription"]);
      $active = htmlentities($_POST["activeChoice"]);
      if ($active == "inactive") {
        $setActive = false;
      }
    }
    ?>
    <form method="post" action="edit.php">
      <?php
      //echo "<input type=\"hidden\" name=\"password\" value=\"$password\">";
      // RENDER Edit
      $sql = "SELECT * FROM beers WHERE id='".$beerID."'";
      $dbOutput = $conn->query($sql);
      if ($dbOutput->num_rows > 0) {
        while($row = $dbOutput->fetch_assoc()) {
          $image = $row["image"];
          $name = $row["name"];
          $abv = $row["abv"];
          $description = $row["description"];
          echo '<h1>Edit beer: '.$name.'</h1>';
          ?>
          <!-- <div class="flex-it">
            <div class="flex-section">
              <img name="Pint" class="addImage" src="../img/beersPint.png"><br/>Pint
            </div>
            <div class="flex-section">
              <img name="PintDark" class="addImage" src="../img/beersPintDark.png"><br/>Pint Dark
            </div>
            <div class="flex-section">
              <img name="Stange" class="addImage" src="../img/beersStange.png"><br/>Stange
            </div>
            <div class="flex-section">
              <img name="StangeLight" class="addImage" src="../img/beersStangeLight.png"><br/>Stange Light
            </div>
            <div class="flex-section">
              <img name="Goblet" class="addImage" src="../img/beersGoblet.png"><br/>Goblet
            </div>
            <div class="flex-section">
              <img name="Snifter" class="addImage" src="../img/beersSnifter.png"><br/>Snifter
            </div>
            <div class="flex-section">
              <img name="Weizen" class="addImage" src="../img/beersWeizen.png"><br/>Weizen
            </div>
            <div class="flex-section">
              <img name="Mug" class="addImage" src="../img/beersMug.png"><br/>Mug
            </div>
            <div class="flex-section">
              <img name="Tulip" class="addImage" src="../img/beersTulip.png"><br/>Tulip
            </div>
          </div> -->
          <table border="0">
          <!--<tr>
            <td><h2>Image</h2></td>
            <td><img class="addImage" src="../img/beers<?php echo($image); ?>.png"></td>
          </tr>-->
          <tr>
            <td><h2>Beer Name</h2></td>
            <td><input type="text" size="36" name="newBeerName" value="<?php echo ($name); ?>"></td>
          </tr>
          <tr>
            <td><h2>ABV &amp; Size</h2></td>
            <td><input type="text" size="36" name="newBeerAbv" value="<?php echo ($abv); ?>"></td>
          </tr>
          <tr>
            <td><h2>Description</h2></td>
            <td><textarea name="newBeerDescription" rows="4" cols="85"><?php echo ($description); ?></textarea></td>
          </tr>
        </table>
        <input type="submit" value="SAVE this Beer" class="btn btn-info btn-lg" /> 
        <button type="button" class="btn btn-default" id="CancelButton">Cancel</button>
      <?php
        }
      }
      ?>
    </form>

    <script>
      $( ".addImage" ).click(function doStuff() {
        var img = document.createElement("IMG");
        var beerString = this.name;
        img = '<img src="../img/beers'+beerString+'.png">'+' <strong>'+beerString+'</strong>';
        $("#AddImageDiv").html(img);
        $("#AddImageDiv").append('<input type="hidden" name="newBeerImage" value="'+beerString+'">');
      });
      $("#CancelButton").click(function goHome() {window.history.go(-1);});
    </script>

  </body>
</html>