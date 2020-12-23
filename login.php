<?php
// #####################
// Check submitted password
// against hashed value
// #####################

$loginInvalid = false;

if (isset($_POST["password"])) {	
	$password = $_POST["password"];
	$strHash = hash('sha256', $password);
	$strHashCheck = 'b6a437f10a2cc76ec6934b66f3962ae5d722ce564976539e52e4f1e784175eed';
	if ($strHash == $strHashCheck) {
    $_SESSION['lbmc'] = "yup";
  }
  else {
    // that's not right!
    $loginInvalid = true;
  }
}
if (isset($_POST["adminPass"])) {
	$adminPass = $_POST["adminPass"];
	$strHash = hash('sha256', $adminPass);
	$strHashCheck = 'e722be612d2a0cc7ba92b7eefadeec45650ab30b42ee36072c27b8364f34d53f';
	if ($strHash == $strHashCheck) {
    $_SESSION['admin'] = "hellsyeah";
  }
  else {
    // that's not right!
    echo ("<script>window.location.href='index.php';</script>");
  }
}
if (isset($_POST["logOut"])) {
  // log out and send them home
  session_destroy();
  echo ("<script>window.location.href='../index.php';</script>");
}

?>