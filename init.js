(function(global, $){
    //Define core variables.
    var codiad = global.codiad;

    //Instantiate the plugin.
    $(function() {
        codiad.FileUse.init();
    });

    //Declare the plugin properties and methods.
    codiad.FileUse = {
        init: function() {
            //Test alert.
            alert("Loaded...");
        }
    };
})(this, jQuery);
