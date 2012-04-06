jQuery(document).ready(function($) {
        function load(num) {
            $('#content').load(num +".html");
        }

        $.history.init(function(url) {
                load(url == "" ? "accueil" : url);
            });

        $('#ajax-links a').live('click', function(e) {
                var url = $(this).attr('href');
                url = url.replace(/^.*#/, '');
                $.history.load(url);
                return false;
            });
    });