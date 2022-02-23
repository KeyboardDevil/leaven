<?php
function updateRepo($LOCAL_REPO) {
    // If there is already a repo, just run a git pull to grab the latest changes
    $output = null;
    $return_val = null;
    exec("cd {$LOCAL_REPO} && git pull origin master 2>&1", $output, $return_val);
    echo "<br />output: $output";
    file_put_contents("webhook.log", "\n#############################\ngit pull origin master output:\n$output", FILE_APPEND);
    $status = shell_exec("cd {$LOCAL_REPO} && git rev-parse --short HEAD 2>&1");
    echo "<br />status: $status";
    echo "<br />root: $LOCAL_ROOT";
    file_put_contents("webhook.log", "\nCurrent hash is $status\n#############################\n", FILE_APPEND);
    die("done " . mktime());
}
// Set Variables
$LOCAL_ROOT = "/home/keyboarddevil";
$LOCAL_REPO_NAME = "leavenbrewing";
$LOCAL_REPO = "{$LOCAL_ROOT}/{$LOCAL_REPO_NAME}";

$key = $_REQUEST["key"];
$strHash = hash('sha256', $key);
if ($strHash == "719685ae8455e25dcce5557bee7639638ed02bc7644c3fcd4c6009054fe626f0") {
    updateRepo($LOCAL_REPO);
}
?>