<?php
header('Content-type: application/x-javascript');
$qrtipsypop = ( isset( $_GET['qrtipsypop'] ) ) ? "?qrtipsypop={$_GET['qrtipsypop']}" : '';
$params = ( isset( $_GET['pluginUrl'] ) ) ? "{$qrtipsypop}&pluginUrl={$_GET['pluginUrl']}" : '';
/* Start qrtipsy.mce_plugin.js */
?>
(function() {
	tinymce.create('tinymce.plugins.QRTIPSYPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceQRTIPSY', function() {
				ed.windowManager.open({
					file : url + '/qrtipsy.mcepop.php<?php echo $params; ?>',
					width : 740 + parseInt(ed.getLang('qrtipsy.delta_width', 0)),
					height : 370 + parseInt(ed.getLang('qrtipsy.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('qrtipsy', {title : 'qrtipsy Plugin for Wordpress: Insert qrtipsy', cmd : 'mceQRTIPSY', image : url + '/images/logo.png'});
		},

		getInfo : function() {
			return {
				longname : 'qrtipsy',
				author : 'Agnel Waghela',
				authorurl : 'http://agnelwaghela.wordpress.com/',
				infourl : 'http://agnelwaghela.site90.net/qrtipsy',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('qrtipsy', tinymce.plugins.QRTIPSYPlugin);
})();
<?php /* End qrtipsy.mce_plugin.js */ ?>