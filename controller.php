<?php

    /*
    *  Copyright (c) Codiad (codiad.com) & Florent Galland & Luc Verdier,
    *  distributed as-is and without warranty under the MIT License. See
    *  [root]/license.txt for more. This information must remain intact.
    */

    require_once('../../common.php');
    require_once('../../lib/file_db.php');

    //////////////////////////////////////////////////////////////////
    // Verify Session or Key
    //////////////////////////////////////////////////////////////////

    checkSession();

    //////////////////////////////////////////////////////////////////
    // Initialize Data Base
    //////////////////////////////////////////////////////////////////

    $collaborativeDataBase = new file_db(BASE_PATH . '/data/collaborative');

    function &getDB() {
        global $collaborativeDataBase;
        return $collaborativeDataBase;
    }

    //////////////////////////////////////////////////////////////////
    // Post Action
    //////////////////////////////////////////////////////////////////

    if(!isset($_POST['action']) || empty($_POST['action'])) {
        exit(formatJSEND('error', 'No action specified'));
    }

    switch ($_POST['action']) {
    case 'getRegisteredUsers':
        /* Get an object containing all the users registered to the given file.
         * The data corresponding to the current user is omitted. */
        if(!isset($_POST['filename']) || empty($_POST['filename'])) {
            exit(formatJSEND('error', 'No filename specified in getRegisteredUsers'));
        }

        $filename = $_POST['filename'];
        $data["users"] = getRegisteredUsersForFile($filename);

        echo formatJSEND('success', $data);
        break;
        
    case 'checkForOtherUsers':
        /* Get an object containing all the users registered to the given file.
         * The data corresponding to the current user is omitted. */
        if(!isset($_POST['filename']) || empty($_POST['filename'])) {
            exit(formatJSEND('error', 'No filename specified in checkForOtherUsers'));
        }

        $filename = $_POST['filename'];

        $returnData = array();
        $otherUsers = 0;
        $users = getRegisteredUsersForFile($filename);
        foreach ($users as $user) {
            if ($user !== $_SESSION['user']) {
                $otherUsers++;
            }
        }
        
        $returnData[] = $otherUsers;

        echo formatJSEND('success', $returnData);
        break;

    default:
        exit(formatJSEND('error', 'Unknown Action ' . $_POST['action']));
    }

    /* $filename must contain only the basename of the file. */
    function &getRegisteredUsersForFile($filename) {
        $usernames = array();
        $query = array('user' => '*', 'filename' => $filename);
        $entries = getDB()->select($query, 'registered');
        
        foreach($entries as $entry) {
            $user = $entry->get_field('user');
            $usernames[] = $user;
        }
        return $usernames;
    }
?>