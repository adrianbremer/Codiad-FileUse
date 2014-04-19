<?php

    /*
    *  Copyright (c) Codiad & RustyGumbo, distributed
    *  as-is and without warranty under the MIT License. See
    *  [root]/license.txt for more. This information must remain intact.
    */

    require_once('../../common.php');
    require_once('class.fileuse.php');

    /* Object */ $FileUse = new FileUse();

    //////////////////////////////////////////////////////////////////
    // Verify Session or Key
    //////////////////////////////////////////////////////////////////

    checkSession();

    //////////////////////////////////////////////////////////////////
    // Get registered user count.
    //////////////////////////////////////////////////////////////////

    if($_GET['action']=='usercount'){
        $FileUse->username = $_SESSION['user'];
        $FileUse->path = $_GET['path'];
        $FileUse->GetUserCount();
    }
?>
