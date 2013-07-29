<?php

    /*
    *  Copyright (c) Codiad & Kent Safranski (codiad.com), distributed
    *  as-is and without warranty under the MIT License. See
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
    // Get Action
    //////////////////////////////////////////////////////////////////

    if(!isset($_GET['action']) || empty($_GET['action'])) {
        exit(formatJSEND('error', 'No action specified'));
    }

    switch($_GET['action']){

        //////////////////////////////////////////////////////////////
        // List Users
        //////////////////////////////////////////////////////////////
        case 'users':
            ?>
            <label><?php i18n("Registered Users"); ?></label>
            <div id="user-list">
                <table width="100%">
                    <tr>
                        <th><?php i18n("Username"); ?></th>
                    </tr>
            <?php

            // Get projects JSON data
            $filename = $_GET['filename'];
            $usernames = getRegisteredUsersForFile($filename);
            
            if(count($usernames) == 0) {
                ?>
                    <tr>
                        <td>No users registered.</td>
                    </tr>
                <?php
            } else {
                foreach ($usernames as $user) {
                    ?>
                    <tr>
                        <td><?php echo $user; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </table>
            </div>
        	<button class="btn-right" onclick="codiad.modal.unload();return false;"><?php i18n("Close"); ?></button>
            <?php

            break;
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
