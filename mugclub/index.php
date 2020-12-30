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
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&family=Bangers&display=swap" rel="stylesheet">
  <style>
    h1 {
      font-family: 'Bangers', cursive;
      font-size: 5em;
      text-shadow: 2px 2px 5px #b91313;
      margin: 5px;
    }
    body {
      background: url('img/mugBack.gif') no-repeat fixed center;
      margin: 50px;
      font-family: 'Prompt', sans-serif;
    }
    .button {
      border-radius: 5px;
      background-color: #1B98E0;
      padding: 8px 15px 8px 15px;
      cursor: pointer;
      color: black;
      font-size: 1.2em;
      margin: 0 10px;
    }
    .button:hover {
      background-color: #23a9f6;
    }
    input {
      font-size: 1.6em;
    }
    #LogOut {
      display: block;
      position: absolute;
      right: 50px;
      top: 50px;
    }
  </style>
</head>

<body>
  <?php require '../login.php'; ?>
  
  <!-- <img src="img/lbmcLogo.gif"> -->
  
  <?php
    if (!isset($_SESSION['lbmc'])) { ?>
      <div id="Login">
      <?php 
      if($loginInvalid){
        echo('<h1>That\'s not right!</h1><img src="img/magicWord.gif" width="400">');
        echo ('<style>body{background: url("img/nerdyBack.jpg") fixed top no-repeat;</style>');
      }
      else { 
        echo "<h1>WELCOME Mug Club Member!</h1>";
      }?>
        <p>Looks like you need to <strong>log in</strong> for all of the super-secret member goodness.</p>
        <form action="index.php" method="POST" name="logIn">
          <input type="text" name="password"><input type="submit" class="button" name="passSubmit" value="Log In!">
        </form>
      </div>
    <?php
    }
    else { //user logged in!
      require '../cms/beersDB.php';
      // get emails
      $sql = 'SELECT date, title, filename FROM uploads';
      $dbOutput = $conn->query($sql);
      ?>
      <div id="Members">
        <h1>You are logged in!</h1>
        <h2>Download past Mug Club emails</h2>
        <ul>
        <?php
        if ($dbOutput -> num_rows > 0) {
          echo '<ul>';
          while($row = $dbOutput ->fetch_assoc()) {
            $dbDate = $row["date"];
            $dbTitle = $row["title"];
            $dbFile = $row["filename"];
            echo '<li><a href="'.$dbFile.'">'.$dbDate.' - '.$dbTitle.'</a></li>';
          }
          echo '</ul>';
        }
        ?>
        </ul>
        <form id="LogOut" action="index.php" method="POST" name="LogOut">
          <input type="submit" name="logOut" class="button" value="Log OUT">
        </form>
      </div>
    <?php
    } ?>
    <!-- <img src="img/MembersOnly.png" id="MembersOnly"> -->

</body>
</html>