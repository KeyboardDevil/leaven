<!doctype html>
<html lang="en">

  <head>
    <title>Test</title>
  </head>

  <body>

    <?php

      $referer = 'none';
      $bIsFamous = false;

      if(isset($_SERVER['HTTP_REFERER'])){
        $referer = $_SERVER['HTTP_REFERER'];
        $bIsFamous = strpos($referer,'bestbreweryever');
      }
    ?>

      <h1><?php echo($referer); ?></h1>
      <h2><?php echo($bIsFamous); ?></h2>

  </body>

</html>
