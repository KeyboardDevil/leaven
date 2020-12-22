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
  <title>Leaven Brewing Admin Upload</title>
</head>

<body>
  <?php
    $uploadType = $_POST["UploadType"];
    echo ("Upload type: ".$uploadType);
    require '../cms/beersDB.php';
    echo ("Past the require");
    $target_dir = "uploads/";
    $file_name = basename($_FILES["EmailPDF"]["name"]);
    $target_file = $target_dir . basename($_FILES["EmailPDF"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if ($uploadType == "email") {
      $date = $_POST["EmailDate"];
      $title = $_POST["EmailSubj"];
    }

    if (isset($date) && isset($title)) {
      echo "<h3>Date and Title:</h3> ".$date." / ".$title;
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
      else { echo "<h3>File is a PDF</h3>"; }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        echo "<p class=\"error\">Your file was not uploaded.</p>";
      // if everything is ok, try to upload file
      } else {
        echo "<h3>Move the file</h3> ".$target_file;
        if ($uploadType == 'email') {
          if (move_uploaded_file($_FILES["EmailPDF"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["EmailPDF"]["name"])). " has been uploaded.";
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }
        else if ($uploadType == 'menu') {
          if (move_uploaded_file($_FILES["MenuPDF"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["MenuPDF"]["name"])). " has been uploaded.";
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }
        else {
          echo "Upload TYPE not found. Uh oh!";
        }
      }
      // update db
      if ($uploadType == "email") {
        $updateSQL = 'INSERT INTO uploads (date, title, filename,uploadType) VALUES ("'.$date.'","'.$title.'","'.$file_name.'","email");';
      }
      if ($uploadType == "menu") {
        $updateSQL = 'INSERT INTO uploads (menu,uploadType) VALUES ("'.$file_name.'","menu");';
      }
      echo "<h3>SQL:</h3> ".$updateSQL;
      if ($conn->query($updateSQL) === TRUE) {
      } else {
        echo "Error: " . $updateSQL . "<br>" . $conn->error;
      }
    }
  ?>

</body>

</html>