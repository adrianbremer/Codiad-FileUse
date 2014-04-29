/*
*  Copyright (c) Codiad & RustyGumbo, distributed
*  as-is and without warranty under the MIT License. See
*  [root]/license.txt for more. This information must remain intact.
*/

(function(global, $){
    //Define core variables.
    var codiad = global.codiad,
        scripts = document.getElementsByTagName('script'),
        path = scripts[scripts.length-1].src.split('?')[0],
        curpath = path.split('/').slice(0, -1).join('/')+'/';

    //Instantiate the plugin.
    $(function() {
        codiad.FileUse.init();
    });

    //Declare the plugin properties and methods.
    codiad.FileUse = {
        //Controller path.
        controller: curpath + 'controller.php',
        
        //Dialog path.
        dialog: curpath + 'dialog.php',
        
        //User check interval
        interval: 3000,
        
        //Initialization function.
        init: function() {
            var _this = this;
            
            //Create the the div.
            $("#editor-bottom-bar").append('<div id="users" title="Other users viewing this file."><div class="divider"></div><a class="ico-wrapper"><span class="icon-users"></span><span id="user_count">?</span> User(s)</a></div>');
            
            //Hook the click event to show the users on the file.
            $("#users").click(function() {
                codiad.active.check(codiad.active.getPath());
            });
            
            //Subscribe to the active.onFocus event to execute on tab focus.
            amplify.subscribe("active.onFocus", function(path) {
                _this.getUserCount(path);
            });
			
            //Timer to check for user count.
            setInterval(function() {
                _this.getUserCount(codiad.active.getPath());
            }, _this.interval);
        },
        
        //Get the count of users registered on the file.
        getUserCount: function(path) {
            var _this = this;
            
            $.get(
                _this.controller + '?action=usercount&path=' + path,
                function(data) {
                    var /* Object */ responseData = codiad.jsend.parse(data);

                    $("#user_count").text(responseData.count);
                }
            );
        }
    };
})(this, jQuery);
