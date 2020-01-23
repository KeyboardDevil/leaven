<?php
/*
Template Name: Taplist Page
*/
?>
<html>
<head>
</head>
<body>
  <?php

    $brewery_name = 'Leaven Brewing';
    $beverage_location = '';

    $string = file_get_contents("https://server.digitalpour.com/DashboardServer/api/v3/MenuItems/5d8a2b6c35272612344327e5/1/Tap?apiKey=5d8c913b76d5a90b0b38cedf");
    //echo $string;

    $json_taps = json_decode($string, true);

    foreach ($json_taps as $beverage) {
      $beverage_name = $beverage['MenuItemProductDetail']['Beverage']['BeverageName'];
      $beverage_price = $beverage['MenuItemProductDetail']['Prices'];
      $beverage_type = $beverage['MenuItemProductDetail']['BeverageType'];
      $beverage_style = $beverage['MenuItemProductDetail']['Beverage']['BeerStyle']['StyleName'];
      $beverage_color = $beverage['MenuItemProductDetail']['Beverage']['BeerStyle']['Color'];
      $beverage_ibu = $beverage['MenuItemProductDetail']['Beverage']['Ibu'];
      $beverage_abv = $beverage['MenuItemProductDetail']['Beverage']['Abv'];
      $beverage_desc = $beverage['MenuItemProductDetail']['Beverage']['CustomDescription'];
      $beverage_servSize = $beverage['MenuItemProductDetail']['Prices']['0']['DisplayName']; 
      $beverage_price = $beverage['MenuItemProductDetail']['Prices']['0']['Price'];
      $beverage_glass = $beverage['MenuItemProductDetail']['Prices']['0']['Glassware'];
      $keg_size = $beverage['MenuItemProductDetail']['KegSize'];
      $oz_remaining = $beverage['MenuItemProductDetail']['EstimatedOzLeft'];
      $scale = 1.0;

      // % of keg remaining
      // Get Percentage out of 100
      if ( !empty($keg_size) ) { $percent = $oz_remaining  / $keg_size; } 
      else { $percent = 0; }

      // Limit to 100 percent (if more than the max is allowed)
      if ( $percent > 1 ) { $percent = 1; }     
      if ( $percent < 0 ) { $percent = .005; }     
      $percent_remaining = number_format($percent*100, 0);
      if ( $percent_remaining < 1 ) {$percent_remaining = "< 1";}

      //determine percent Left color
      // |-----------Red ---------------------------|   |-------Green--------------------| |Blue|
      $percent_left_color = (max(0,min(255,511 * (1-$percent))) * 65536) + (max(0,min(255,511 * $percent)) * 256) + 40;

      echo "<h2>".$beverage_name."</h2>";
      echo "<ul><li>Style: ".$beverage_style.'</li>';
      echo "<li>ABV: ".$beverage_abv.'%</li>';
      echo "<li>IBU: ".$beverage_ibu.'</li>';
      echo "<li>Serving size: ".$beverage_servSize."</li>";
      echo "<li>Price: $".$beverage_price."</li>";
      echo "<li>Glassware: ".$beverage_glass."</li>";
      echo "<li>Color: ".$beverage_color."</li>";
      echo "<li>Desc: ".$beverage_desc.'</li></ul>';

      echo '% Remaining: '.$percent_remaining;
    }

  ?> 
</body>
</html>