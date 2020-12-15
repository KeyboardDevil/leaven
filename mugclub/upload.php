<?php
  session_start();
?>
<!doctype html>
<!-- #####################
  Mug Club 1.0 ADMIN upload
#########################-->
<html lang="en">
<head>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="EXPIRES" CONTENT="0">
  <link href="https://www.leavenbrewing.com/favicon.ico" rel="shortcut icon">
  <title>Leaven Brewing MUG CLUB Upload</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
  <link href="mugclub.css" rel="stylesheet">
</head>

<body>
  <?php
    require 'beersDB.php';
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["EmailPDF"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $date = $_POST["EmailDate"];
    $title = $_POST["EmailSubj"];

    if (isset($date) && isset($title)) {
      // Check if file already exists
      if (file_exists($target_file)) {
        echo "<p class=\"error\">Sorry, that file name already exists. RENAME your email.</p>";
        $uploadOk = 0;
      }

      // Allow certain file formats
      if($fileType != "pdf") {
        echo "<p class=\"error\">Sorry, only PDF files are allowed.</p>";
        $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        echo "<p class=\"error\">Your file was not uploaded.</p>";
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["EmailPDF"]["tmp_name"], $target_file)) {
          echo "The file ". htmlspecialchars( basename( $_FILES["EmailPDF"]["name"])). " has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      }
      // update db
      $updateSQL = 'INSERT into uploads (date, title, file)
                    values ('.$date.','.$title.','.$target_file.');';
      if ($conn->query($updateSQL) === TRUE) {
      } else {
        echo "Error: " . $updateSQL . "<br>" . $conn->error;
      }
    }
  ?>

</body>

</html>