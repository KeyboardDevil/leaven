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
  <style>
    body {
      margin: 30px;
      font-family: sans-serif;
      font-size: 1.25em;
      background-image: url('uploadBack.gif');
      background-repeat: no-repeat;
    }
    p {
      
    }
    #UploadResults {
      border: 5px solid #0A2239;
      border-radius: 25px;
      padding: 20px 30px;
      width: 400px;
    }
    h1, h2, h3 {
      margin: .5em 0 .4em;
    }
  </style>
</head>

<body>
  <div id="UploadResults">
    <?php
      if (isset($_SESSION['admin'])) {
        require '../cms/beersDB.php';
        $uploadType = $_POST["UploadType"];
        $basename = '';
        $imagePath = '';
        if (isset($_POST["EmailDate"])) {$date = $_POST["EmailDate"];}
        if (isset($_POST["EmailSubj"])) {$title = $_POST["EmailSubj"];}
        if ($uploadType == 'menu') {$imagePath = 'MenuPDF';}
        if ($uploadType =='email') {$imagePath = 'EmailPDF';}
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES[$imagePath]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      
        // Allow certain file formats
        if($imageFileType != '' && $imageFileType != "pdf") {
          echo "<p>PDFs only!</p>";
          $uploadOk = 0;
        }
      
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          echo "<p class=\"error\">Your file was not uploaded.</p>";
          echo "<a href=\"index.php\">Try Again!</a>";
        // if everything is ok, try to upload file
        } else {
          $basename = "menu.pdf";
          $source = $_FILES[$imagePath]["tmp_name"];
          $destination = $target_dir.$basename;
          if (move_uploaded_file( $source, $destination )) {
          } else {
            echo "<p class=\"error\">Sorry, there was an error uploading your file.</p>";
            echo "<a href=\"index.php\">Try Again!</a>";
          }
        }
        
        // update db
        if ($uploadType == "email") {
          $updateSQL = 'INSERT INTO uploads (date, title, filename,uploadType) VALUES ("'.$date.'","'.$title.'","'.$basename.'","email");';
        }
        if ($uploadType == "menu") {
          $updateSQL = 'INSERT INTO uploads (date,title,filename,uploadType) VALUES ("none","none","'.$basename.'","menu");';
        }
        //echo "<h3>SQL:</h3> ".$updateSQL;
        if ($conn->query($updateSQL) === TRUE) {
        } else {
          echo "Error: " . $updateSQL . "<br>" . $conn->error;
        }
      }
    ?>
  </div>

</body>

</html>