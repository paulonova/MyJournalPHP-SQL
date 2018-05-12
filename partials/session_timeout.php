<?php

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    // last request was more than 15 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage

    header('location: /index.php?logout=Session is timed out, login again!');  
}

$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp