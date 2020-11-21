$.config = {
	router: false,
    routerFilter: function($link) {
        var href = $($link).attr('href');
        if (window.__wxjs_environment === 'miniprogram' && href.substring(0, 5) == 'http:') {
        	$($link).attr('href', href.replace(/http:/, "https:"));
        }
        return true;
    }
};