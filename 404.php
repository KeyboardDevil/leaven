<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Site by Frank - www.KeyboardDevil.com -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="brewery, leaven brewing, riverview brewery, florida brewery" name="keywords">
  <meta content="Leaven Brewing - Transforming Grain for the Better" name="description">
  <!-- Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-3474776-4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-3474776-4');
  </script>
  <title>Leaven Brewing: Oh Noes!</title>  
  <link href="https://www.leavenbrewing.com/favicon.ico" rel="shortcut icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://www.leavenbrewing.com/lib/animate-css/animate.min.css" rel="stylesheet">
  <link href="https://www.leavenbrewing.com/css/style.css" rel="stylesheet">
</head>
  
<body>
  <?php
    $adrianVotes = 0;
    $frankVotes = 0;
    $strFire = '';
    // DATABASE magic
    require 'cms/beersDB.php';
    // FORM check
    if (isset($_GET["fire"])) {
      $strFire = htmlspecialchars($_GET["fire"]);
      $sqlUpdate = "UPDATE fired SET votes=votes+1 WHERE name='".$strFire."'";
      if ($conn->query($sqlUpdate) === TRUE) {
        echo "<script>window.location.href='https://www.leavenbrewing.com/index.php'</script>";
      } else {
          echo "<h2>Oh shit, this thing is REALLY broken now " . $conn->error . "</h2>";
      }
    } // end UPDATE
    // set counters for view
    $sqlSelect = 'SELECT id, name, votes FROM fired';
    $dbOutput = $conn->query($sqlSelect);
    if ($dbOutput -> num_rows > 0) {
      while($row = $dbOutput ->fetch_assoc()) {
        $name = $row["name"];
        if ($name == "adrian") {
          $adrianVotes = $row["votes"];
        }
        else {
          $frankVotes = $row["votes"];
        }
      }
    } // end DB
    $conn->close();
  ?>

  <!--  Header Section-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <a href="https://www.leavenbrewing.com/index.php"><img src="https://www.leavenbrewing.com/img/logo.png" alt="Leaven Logo" title="" /></a>
      </div>
      <!-- #nav-menu-container -->
    </div>
  </header>
  <!-- #header -->
  
  <!-- Oh NOES -->
  <section id="OhNoes">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="section-title">Oh Noes!</h2>
          <div class="section-title-divider"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <img src="https://www.leavenbrewing.com/img/404Logo.png" alt="The Great Vanilla Goat!" class="imgFloater">
          <h3>What did you do?!</h3>
          <p class="about-text">Well, you broke it.  This is why we don't have nice things... Like beer.  OK beer is nice.  In fact, it's delicious! Well, OK. We have <strong>some</strong> nice things, but you still manged to <strong>break</strong> something.</p>
          <blockquote>This kind of technical failure can't go unanswered.  And that means...</blockquote>
          <h3>One of our geeks is getting <span class="fired">FIRED</span>... And <span class="you">you</span> get to choose who gets the ax!</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div id="FireThem">
            <form id="VoteForm" name="FireVote" method="post" action="https://www.leavenbrewing.com/404.php">
              <input type="hidden" name="voted" value="true">
              <span class="fireChoice" id="adrian">FIRE Adrian!<img src="https://www.leavenbrewing.com/img/arrowAdrian.gif" alt="Fire Adrian!"></span>
              <?php
                echo '<span class="numVotes">Current Votes: <span class="voteCount">'.$adrianVotes.'</span></span>';
              ?>
              <a href="https://www.leavenbrewing.com/404.php?fire=adrian"><img alt="Fire Adrian!" class="fireHim" name="adrian" src="https://www.leavenbrewing.com/img/adrian.jpg"></a>
              <a href="https://www.leavenbrewing.com/404.php?fire=frank"><img alt="Fire Frank!" class="fireHim" name="frank" src="https://www.leavenbrewing.com/img/frank.jpg"></a>
              <?php
                echo '<span class="numVotes">Current Votes: <span class="voteCount">'.$frankVotes.'</span></span>';
              ?>
              <span class="fireChoice" id="frank">FIRE Frank!<img src="https://www.leavenbrewing.com/img/arrowFrank.gif"></span>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--  Footer-->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="copyright">
            &copy; Copyright <strong>Leaven Brewing</strong>. All Rights Reserved
          </div>
          <div class="credits">
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <script src="https://www.leavenbrewing.com/lib/jquery/jquery-3.6.4.min.js"></script>
  <script src="https://www.leavenbrewing.com/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://www.leavenbrewing.com/lib/superfish/hoverIntent.js"></script>
  <script src="https://www.leavenbrewing.com/lib/superfish/superfish.min.js"></script>
  <script src="https://www.leavenbrewing.com/lib/morphext/morphext.min.js"></script>
  <script src="https://www.leavenbrewing.com/lib/wow/wow.min.js"></script>
  <script src="https://www.leavenbrewing.com/lib/stickyjs/sticky.js"></script>
  <script src="https://www.leavenbrewing.com/lib/easing/easing.js"></script>
  <script src="https://www.leavenbrewing.com/js/custom.js"></script>
  <script src="https://www.leavenbrewing.com/contactform/contactform.js"></script>
  <script>
    $('.fireHim').hover(function() {
      $(this).css( "opacity","1" );
      strID = "#"+this.name;
      $(strID).css("visibility","visible");
    },function(){
      $(this).css( "opacity",".5" );
      $(".fireChoice").css("visibility","hidden");
    });
  </script>

</body>

</html>