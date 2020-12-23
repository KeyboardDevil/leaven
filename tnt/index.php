<?php
  // generate unique id for cachebust from boobies to boobiesboobies, #notSorry
  $shesBusty = hash("ripemd320",random_int(8008135,80081358008135));
?>
<!doctype html>
<!-- #####################
  TNT Menu redirector 1.0
#########################-->
<html lang="en">
<head>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="EXPIRES" CONTENT="0">
  <link href="https://www.leavenbrewing.com/favicon.ico" rel="shortcut icon">
  <title>TacoNotTaco @ Leaven Brewing</title>
</head>

<body>
  <script>
    window.location.href="menu.pdf?c=<?php echo ($shesBusty); ?>"</script>
</body>
</html>