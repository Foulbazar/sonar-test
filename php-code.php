<?php

if( isset($_POST['Submit']) ) {
    // Get input
    $target = trim($_REQUEST['ip']);

    // Set whitelist (only allow digits and dots for IP addresses)
    $whitelistPattern = '/^[\d\.]+$/';

    if (!preg_match($whitelistPattern, $target)) {
        die("Invalid input.");
    }

    // Determine OS and execute the ping command safely.
    if(stristr(php_uname('s'), 'Windows NT')) {
        // Windows
        $cmd = escapeshellarg($target);
        $result = shell_exec("ping {$cmd}");
    } else {
        // *nix
        $cmd = escapeshellarg($target);
        $result = shell_exec("ping -c 4 {$cmd}");
    }

    if ($result === false) {
        die("Failed to execute command.");
    }

    // Escape output for HTML
    $htmlOutput = "<pre>" . htmlspecialchars($result, ENT_QUOTES, 'UTF-8') . "</pre>";

    // Output the result
    echo $htmlOutput;
}

?>
