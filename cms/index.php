<?php
  session_start();
?>
<!doctype html>
<!-- #####################
  BeerMS - Beer form 3.0
#########################-->
<html lang="en">
  <head>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <META HTTP-EQUIV="EXPIRES" CONTENT="0">
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
  <body>
    <?php
    require 'pass.php';
    if (!isset( $_SESSION['MagicKey'] )) {
    ?>
      <div class="warning">
        <img src="beerMSlogin.gif"><br />
        <img src="leavenLoginLogo.gif">
        <h1>Please enter password to continue.</h1>
        <form method="post" action="index.php">
          <input type="password" name="password" size="8"> <input type="submit" name="submit" value="Submit">
        </form>
      </div>
    <?php
    }
    // ################################
    // Check and process the form
    // ################################
    $image = null;
    $name = null;
    $abv = null;
    $description = null;
    $shortdescription = null;
    $active = null;
    $setActive = true;
    if (isset( $_SESSION['MagicKey'] )) {
      require 'beersDB.php';
      if (isset($_POST["newBeerImage"]) && isset($_POST["newBeerName"]) && isset($_POST["newBeerAbv"]) && isset($_POST["newBeerDescription"])) {
        $image = htmlentities($_POST["newBeerImage"]);
        $name = htmlentities($_POST["newBeerName"]);
        $abv = htmlentities($_POST["newBeerAbv"]);
        $description = htmlentities($_POST["newBeerDescription"]);
        $shortdescription = htmlentities($_POST["newBeerShortDescription"]);
        $active = htmlentities($_POST["activeChoice"]);
        if ($active == "inactive") {
          $setActive = false;
        }          
      }
      // ###############
      // DEACTIVATE beer
      if (isset($_POST["deactivate"])) {
        $deactivate = $_POST["deactivate"];
        // Get beer ID
        $beerDeactivated = explode("-",$deactivate,2);
        $beerDeactivated = $beerDeactivated[1];
        $deactivateSql = "UPDATE beers SET active=0 WHERE ID=$beerDeactivated";
        if ($conn->query($deactivateSql) === TRUE) {
          echo "<p>Deactivated beer ID: $beerDeactivated</p>";
        } else {
          echo "Error: " . $deactivateSql . "<br>" . $conn->error;
        }
      }
      // ###############
      // DELETE beer
      if (isset($_POST["delete"])) {
        $delete = $_POST["delete"];
        // Get beer ID
        $beerDeleted = explode("-",$delete,2);
        $beerDeleted = $beerDeleted[1];
        $deleteSql = "DELETE from beers WHERE ID=$beerDeleted";
        if ($conn->query($deleteSql) === TRUE) {
          echo "<p>DELETED beer ID: $beerDeleted</p>";
        } else {
          echo "Error: " . $deleteSql . "<br>" . $conn->error;
        }
      }
      // ###############
      // ACTIVATE beer
      if (isset($_POST["activate"])) {
        $activate = $_POST["activate"];
        // Get beer ID
        $beerActivated = explode("-",$activate,2);
        $beerActivated = $beerActivated[1];
        $activateSql = "UPDATE beers SET active=1 WHERE ID=$beerActivated";
        if ($conn->query($activateSql) === TRUE) {
          echo "<p>Activated beer ID: $beerActivated</p>";
        } else {
          echo "Error: " . $activateSql . "<br>" . $conn->error;
        }
      }
      // ###############
      // ADD a new beer
      if ($image!='' && $name!='' && $abv!='' && $description!='') {
        $stmt = $conn->prepare("INSERT INTO beers (image, name, abv, description, shortdescription, active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $image, $name, $abv, $description, $shortdescription, $setActive);
        $sql = 'INSERT INTO beers (image,name,abv,description,shortdescription,active) VALUES ("'.$image.'","'.$name.'","'.$abv.'","'. $description.'","'. $shortdescription.'","'. $setActive.'")';
        if ($conn->query($sql) === TRUE) {
          echo "New beer created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    // ################################
    // End process form
    // ################################
    ?>
    <div class="lefty">
      <h1>Manage your beer list</h1>
      <ul class="howto">
        <li>The <span class="beerShortDescription">yellow field</span> is what will show on the digital menu (max 60 chars).</li>
        <li><strong>Active</strong> beers will appear on both site and menu, <strong>Inactive</strong> beers will <strong>not appear</strong>.</li>
        <li>To <strong>DELETE</strong> a beer completely, you must first <strong>DEACTIVATE</strong> it.</li>
      </ul>
      <button type="button" class="btn btn-info btn-lg add-btn" data-toggle="modal" data-target="#myModal">ADD a new beer</button>
    </div>
    <div id="BeerMS">
      <form action="index.php" method="POST"><input class="btn btn-danger" type="submit" name="logout" value="LOG OUT of BeerMS"></form><br />
      <img src="beerMS.gif" alt="Powered by BeerMS">
    </div>
    <div class="clear"></div>
    <form method="post" action="index.php">
      <?php
      // Get the current list and render the form
      $sql = 'SELECT ID, active, image, name, abv, description, shortdescription FROM beers';
      $dbOutput = $conn->query($sql);
      ?>
      <?php
      if ($dbOutput -> num_rows > 0) {
        $activeBeers = array();
        $inactiveBeers = array();
        while($row = $dbOutput ->fetch_assoc()) {
          $dbID = $row["ID"];
          $dbImage = $row["image"];
          $dbName = $row["name"];
          $dbAbv = $row["abv"];
          $dbDesc = $row["description"];
          $dbShortDesc = $row["shortdescription"];
          $dbActive = $row["active"];
          // stuff the arrays
          if ($dbActive) {
            $activeBeers[] = array("beerid"=>$dbID, "beerimage"=>$dbImage,"beername"=>$dbName,"beerabv"=>$dbAbv,"beerdesc"=>$dbDesc,"beershortdesc"=>$dbShortDesc);
          }
          else {
            $inactiveBeers[] = array("beerid"=>$dbID, "beerimage"=>$dbImage,"beername"=>$dbName,"beerabv"=>$dbAbv,"beerdesc"=>$dbDesc,"beershortdesc"=>$dbShortDesc);
          }
        }
        ?>
        <!-- print the beers -->
        <div id="BeerContainer">
          <div id="BeerActive">
            <h3 class="beerSectionHeader activeHeader">Active Beers</h3>
            <div class="clear"></div>
            <table id="ActiveBeerTable">
              <?php
              foreach ($activeBeers as $beer) {
                echo "<tr>\n";
                echo "<td class=\"buttons\">";
                echo '<a class="btn btn-primary editLink" href="edit.php?id='.$beer["beerid"].'">EDIT this beer</a>';
                echo "<input class=\"btn btn-warning deactivate-beer\" type=\"submit\" name=\"deactivate\" value=\"DEACTIVATE beer-".$beer["beerid"]."\">";
                echo "</td>\n";

                echo "<td class=\"activeBeerDesc\">";
                echo "<div class=\"beerList\">";
                echo "<img height=\"70\" src=\"../img/beers".$beer["beerimage"].".png\" alt=\"glass\"/>";
                echo "<h3>".$beer["beername"]."</h3>";
                echo "<h4>".$beer["beerabv"]."</h4>";
                echo "<p class=\"beerDescription\">".$beer["beerdesc"]."</p>";
                echo "<p class=\"beerShortDescription\">Digital Menu description:<br/>".$beer["beershortdesc"]."</p>";
                echo "</td>\n";
                echo "</tr>\n";
              }
              echo "</table>\n"
              ?>
              <img class="hiImg" src="theZen.jpg">
            </div>
            <div id="BeerInactive">
              <h3 class="beerSectionHeader">Inactive Beers</h3>
              <table id="InactiveBeerTable">
                <?php
                foreach ($inactiveBeers as $beer) {
                  echo "<tr>\n";
                  echo "<td class=\"buttons\">";
                  echo '<a class="btn btn-primary editLink" href="edit.php?id='.$beer["beerid"].'">EDIT this beer</a>';
                  echo "<input class=\"btn btn-success activate-beer\" type=\"submit\" name=\"activate\" value=\"ACTIVATE beer-".$beer["beerid"]."\">";
                  echo "<input class=\"btn btn-danger delete-beer\" type=\"submit\" name=\"delete\" value=\"DELETE beer-".$beer["beerid"]."\">";
                  echo "</td>\n";
                  
                  echo "<td class=\"inactiveBeerDesc\">";
                  echo "<div class=\"beerList\">";
                  echo "<img height=\"70\" src=\"../img/beers".$beer["beerimage"].".png\" alt=\"glass\"/>";
                  echo "<h3>".$beer["beername"]."</h3>";
                  echo "<h4>".$beer["beerabv"]."</h4>";
                  echo "<p class=\"beerDescription\">".$beer["beerdesc"]."</p>";
                  echo "<p class=\"beerShortDescription\">Digital Menu description:<br/>".$beer["beershortdesc"]."</p>";
                  echo "</td>\n";
                  echo "</tr>\n";
                }
                echo "</table>";
              }
              ?>
          </div>
        </div>

    <?php
      $conn->close();
    ?>

    <!-- Deactivate confirm -->
    <script type="text/javascript">
      $(".deactivate-beer").click(function (e) {
        var result = window.confirm('You are about to DEACTIVATE this beer! Are you sure?');
        if (result == false) {
          e.preventDefault();
        }
      });
      // DELETE confirm
      $(".delete-beer").click(function (e) {
        var result = window.confirm('You are about to DELETE this beer completely! Are you SURE?');
        if (result == false) {
          e.preventDefault();
        }
      });
    </script>

    <!-- ADD NEW BEER modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn btn-primary" data-dismiss="modal">&times;</button><h3 class="modalH">Add a NEW beer</h3>
      </div>
      <div class="modal-body">
        <div class="add-section">
          <p class="add-header">Image <span class="addDetail">(choose below)</span></p>
          <div id="AddImageDiv"></div>
        </div>
        <div class="add-section">
          <p class="add-header">Beer Name</p>
          <input type="text" size="25" name="newBeerName">
        </div>
        <div class="add-section">
          <p class="add-header">Type &amp; ABV</p>
          <input type="text" size="30" name="newBeerAbv">
        </div>
      </div>
      <div class="modal-body">
        <div class="add-section">
          <p class="add-header">Website Description</p>
          <textarea name="newBeerDescription" rows="3" cols="80"></textarea>
        </div>
      </div>
      <div class="modal-body">
      <div class="add-section">
          <p class="add-header">Digital Menu Description</p>
          <textarea name="newBeerShortDescription" rows="1" cols="80"></textarea>
        </div>
      </div>
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
      <div class="modal-footer">
        <div id="ActiveRadios">
          <input type="radio" name="activeChoice" id="activeButton" value="active" checked> <label for="activeButton">Active</label><br/>
          <input type="radio" id="inactiveButton" name="activeChoice" value="inactive"> <label for="inactiveButton">Inactive</label>
        </div>
        <input type="submit" value="ADD this Beer" class="btn btn-info btn-lg" /> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
</form>

    <p class="lastUpd">Code last updated: <?php echo date ("F d Y H:i", getlastmod()); ?></p>
    <h3>Go back to <a href="/index.php">LeavenBrewing</a></h3>
    <p>&nbsp;</p>

    <?php
      } // close MagicKey check
    ?>
  <script>
    $( ".addImage" ).click(function doStuff() {
      var img = document.createElement("IMG");
      var beerString = this.name;
      img = '<img src="../img/beers'+beerString+'.png">'+' <strong>'+beerString+'</strong>';
      $("#AddImageDiv").html(img);
      $("#AddImageDiv").append('<input type="hidden" name="newBeerImage" value="'+beerString+'">');
    });
  </script>

  </body>
</html>