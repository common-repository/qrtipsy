(function($){
	var options = qrtipsy_options.options;
    jQuery('a.qrtipsy').qr({size: options.size, timeout: options.timeout, color: options.skin});
	
})(jQuery);