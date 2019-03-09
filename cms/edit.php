<?php
  session_start();
?>
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
    if(isset( $_SESSION['MagicKey'] )) {
      // Check and process the form
      $beerID = null;
      $image = null;
      $name = null;
      $abv = null;
      $description = null;
      $active = null;
      $setActive = true;
      $returnMode = false;
      if (isset($_GET["id"])) {
        // First render, id passed in URL
        $beerID = $_GET["id"];
      }
      require 'beersDB.php';

      // SUBMIT Edit
      if (isset($_POST["BeerName"]) && isset($_POST["BeerAbv"]) && isset($_POST["BeerDescription"])) {
        //$image = htmlentities($_POST["newBeerImage"]);
        $beerID = $_POST["id"];
        $name = htmlentities($_POST["BeerName"], ENT_QUOTES);
        $abv = htmlentities($_POST["BeerAbv"], ENT_QUOTES);
        $description = htmlentities($_POST["BeerDescription"], ENT_QUOTES);
        // update DB
        $sql = "UPDATE beers SET name = '$name', abv = '$abv', description = '$description' WHERE id='$beerID'";
        if ($conn->query($sql) === TRUE) {
          echo "<h1>Record updated successfully!</h1>";
          echo '<h2><a href="index.php">Go Back to Beer List</a>';
          $returnMode = true;
        } else {
          echo "Holy shit, it's BROKE! Error updating record: " . $conn->error;
        }
      }
      if (!$returnMode) {
      ?>
        <form method="post" action="edit.php">
          <?php
          //echo "<input type=\"hidden\" name=\"password\" value=\"$password\">";
          // RENDER Edit
          $sql = "SELECT * FROM beers WHERE id='".$beerID."'";
          $dbOutput = $conn->query($sql);
          if ($dbOutput->num_rows > 0) {
            while($row = $dbOutput->fetch_assoc()) {
              $name = $row["name"];
              $abv = $row["abv"];
              $description = $row["description"];
              $selectedImage = '<img src="../img/beers'.$row["image"].'.png" class="replaceImg">';
              echo '<h1>Edit beer: '.$name.'</h1>';
              ?>
              <table border="0">
              <!--<tr>
                <td><h2>Beer Image: <?php echo($selectedImage);?></h2></td>
                <td>
                  <div class="flex-it">
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
                  </div>
                </td>
              </tr>-->
              <tr>
                <td><h2>Beer Name</h2></td>
                <td><input type="text" size="36" name="BeerName" value="<?php echo ($name); ?>"></td>
              </tr>
              <tr>
                <td><h2>ABV &amp; Size</h2></td>
                <td><input type="text" size="36" name="BeerAbv" value="<?php echo ($abv); ?>"></td>
              </tr>
              <tr>
                <td><h2>Description</h2></td>
                <td><textarea name="BeerDescription" rows="4" cols="85"><?php echo ($description); ?></textarea></td>
              </tr>
            </table>
            <input type="hidden" name="id" value="<?php echo($beerID); ?>">
            <input type="submit" value="SAVE this Beer" class="btn btn-info btn-lg" /> 
            <button type="button" class="btn btn-default" id="CancelButton">Cancel</button>
          <?php
            }
          }
          $conn->close();
          ?>
        </form>
      <?php
      }
      ?>

      <script>
        $("#CancelButton").click(function goHome() {window.location.href="index.php";});
      </script>
    <?php
    } else { // end MagicKey check
      echo 'NOT AUTHORIZED! Return to the <a href="index.php">Login page</a>';
    }
    ?>

  </body>
</html>