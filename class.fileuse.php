<?php

    /*
    *  Copyright (c) Codiad & RustyGumbo, distributed
    *  as-is and without warranty under the MIT License. See
    *  [root]/license.txt for more. This information must remain intact.
    */
    
    require_once('../../common.php');
    
    class FileUse extends Common {
    
        //////////////////////////////////////////////////////////////////
        // PROPERTIES
        //////////////////////////////////////////////////////////////////
    
        public /* String */ $username   = "";
        public /* String */ $path       = "";
        public /* String */ $new_path   = "";
        public /* Array */ $actives     = "";
    
        //////////////////////////////////////////////////////////////////
        // METHODS
        //////////////////////////////////////////////////////////////////
    
        // -----------------------------||----------------------------- //
    
        //////////////////////////////////////////////////////////////////
        // Construct
        //////////////////////////////////////////////////////////////////
    
        public function __construct(){
            $this->actives = getJSON('active.php');
        }
    
        //////////////////////////////////////////////////////////////////
        // Get the number of registered users on a file.
        //////////////////////////////////////////////////////////////////
    
        public /*JSON */ function GetUserCount(){
            /* Array */ $cur_users  = array();
            
            foreach($this->actives as $data){
                if(is_array($data) && isset($data['username']) && $data['username']!=$this->username && $data['path']==$this->path){
                    $cur_users[] = $data['username'];
                }
            }
            
            /* Prepare the return data. */
            /* Array */ $data = array();
            $data['count'] = count($cur_users);
            
            echo formatJSEND("success", $data);
        }
    }
?>