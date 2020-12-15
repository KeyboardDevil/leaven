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
	$strHashCheck = 'a3ca38ef0e8554b39ce6fd34b011f9aa197cda1f17e2b08b1816142c4bc67199';
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