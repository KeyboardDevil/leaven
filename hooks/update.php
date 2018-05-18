<?php
  // Set Variables
  $LOCAL_ROOT         = "/home/keyboarddevil";
  $LOCAL_REPO_NAME    = "leavenbrewing";
  $LOCAL_REPO         = "{$LOCAL_ROOT}/{$LOCAL_REPO_NAME}";
  $REMOTE_REPO        = "git@github.com:KeyboardDevil/leaven.git";
  $BRANCH             = "master";

  $key = $_REQUEST["key"];
  $strHash = hash('sha256', $key);
  if ( $strHash == "719685ae8455e25dcce5557bee7639638ed02bc7644c3fcd4c6009054fe626f0" && $_POST["payload"] ) {
    // Only respond to POST requests from Github

    $payload = json_decode($_REQUEST["payload"]);
    $branch = $payload->ref;
    if ($branch == "refs/heads/master") {
      if(file_exists($LOCAL_REPO) ) {
        // If there is already a repo, just run a git pull to grab the latest changes
        $output = shell_exec("cd {$LOCAL_REPO} && git pull origin master");
        $status = shell_exec("cd {$LOCAL_REPO} && git rev-parse --short HEAD");
        file_put_contents("webhook.log", print_r($payload, TRUE) . "\n$output\nCurrent hash is $status\n#############################\n", FILE_APPEND);
        die("done " . mktime());
      } else {
        // If the repo does not exist, then clone it into the parent directory
        $output = shell_exec("cd {$LOCAL_ROOT} && git clone {$REMOTE_REPO}");
        $status = shell_exec("cd {$LOCAL_REPO} && git rev-parse --short HEAD");
        file_put_contents("webhook.log", print_r($payload, TRUE) . "\n$output\nCurrent hash is $status\n#############################\n", FILE_APPEND);
        die("done " . mktime());
      }
    }
  }
?>