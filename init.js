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
            var original_method = codiad.collaborative.sendHeartbeat;

            amplify.subscribe("active.onFocus", function(filename) {
                codiad.FileUse.getRegisteredUsers(filename);
            });
        },
        //Shared method to get all the users registered on the current file.
        getRegisteredUsers: function(filename) {
            var _this = this;
            $.post(
                _this.controller,
                { action: 'getRegisteredUsers', filename: filename },
                function (data) {
                    var responseData = codiad.jsend.parse(data);

                    if(responseData.users.length > 0) {
                        if($("#users").length === 0) {
                            $("#current-mode").before('<a id="users" class="ico-wrapper"><span class="icon-user"></span>' + responseData.users.length + ' User(s)</a><div class="divider"></div>');
                            $("#users").click(function() {
                                codiad.modal.load(400, _this.dialog + '?action=users&filename=' + filename);
                            });
                        }
                    } else {
                        $("#users").next().remove();
                        $("#users").remove();
                    }
                }
            );
        },
        openSettings: function() {
            codiad.modal.load(400, this.dialog + '?action=settings');
        }
    };
})(this, jQuery);
