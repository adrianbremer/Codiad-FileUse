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
        //Initialization function.
        init: function() {
            var _this = this;
            
            //Subscribe to the active.onFocus event to execute on tab focus.
            amplify.subscribe("active.onFocus", function(path) {
                _this.getUserCount(path);
            });
        },
        //Get the count of users registered on the file.
        getUserCount: function(path) {
            var _this = this;
            
			$.get(
				_this.controller + '?action=usercount&path=' + path,
				function(data) {
					var /* Object */ responseData = codiad.jsend.parse(data);
					
					//Remove the div to restore it.
					$("#users").remove();
					
					//Create the the div.
                    $("#current-mode").before('<span id="users" title="Other users viewing this file."><a class="ico-wrapper"><span class="icon-user"></span>' + responseData.count + ' User(s)</a><div class="divider"></div></span>');
                    
                    //Hook the click event to show the active.check() message.
                    $("#users").click(function() {
                    	_this.getUserCount(path);
                        codiad.active.check(path);
					});
				}
			);
        }
    };
})(this, jQuery);
