(function($){
	
	var main = $('#qr_main'),
		globalForm = $("#qr_global_options"),
		bar = $('#qr_main_buttons_bar'),
		clearMessage = 0,
		dirty = false,
		lastEditedValues = '',
		options = qrtipsy_options.options,
		pluginUrl = qrtipsy_options.pluginUrl,
		ajaxUrl = qrtipsy_options.ajaxUrl,
		ajaxNonce = qrtipsy_options.nonce,
		toolTipConf = {
			content: {
				attr: 'data-help'
			},
			position: {
				at: 'top center', 
				my: 'bottom center'
			},
			style: {
				classes: 'ui-tooltip-rounded ui-tooltip-shadow ui-tooltip-tipsy'
			}
		};
				
	function tabHandler(e,ui) {
			var id = ui.panel.id;
			bar
				.find("a")
					.show()
					.filter("a[data-hide~="+id+"]")
						.hide()
					.end()
					.filter("a[data-show]")
						.hide()
					.end()
					.filter("a[data-show~="+id+"]")
						.show()
					.end()
				.end();
			$("#"+id).prepend(bar);
	}
	
	/*--Tabset and Skin Handler--*/
	function globalHandler(e) {
		var skin = globalForm.find("input[name=skin]:checked").val();
		if (!$("#qr_skin_"+skin).hasClass("qr_active")) {
			$("#qr_global_skin_preview img").removeClass("qr_last_active");
			$("#qr_global_skin_preview img.qr_active").addClass("qr_last_active").removeClass("qr_active");
			$("#qr_skin_"+skin).stop().fadeTo(0,0).addClass("qr_active").fadeTo(300,1);
		}
		
		actionShowAdvanced(globalForm.find("input[name=advanced]:checked").val() == "enabled");
		
		return false;
	}
	/*--End of Tabs and Skin Handler--*/
	
	function actionShowAdvanced(show) {
		main.find(".qr_advanced_section")[show ? "show" : "hide"]();
	}
	
	globalForm.bind("change",globalHandler);
	
	$(".qr_admin")
				.find(".qr_tabs")
					.show()
					.tabs({show:tabHandler})
				.end()
				.find(".qr_button")
					.button()
				.end()
				.find(".qr_radio")
					.buttonset()
				.end()
				.find(".qr_buttons_bar a")
					.bind("click",'')
				.end();
	
	/*--Size Slider--*/
	$( '#qr_size_slider' ).slider({
		range: 'min',
		value: options.size,
		min: 80,
		max: 150,
		step: 1,
		slide: function( event, ui ) {
			$( '#qr_global_size' ).val( ui.value );
			$( '#qr_size_value' ).val( ui.value );
		}
	});
	$('#qr_size_value').val( $('#qr_size_slider').slider('value') );

	/*--Timeout Slider--*/
	$( '#qr_timeout_slider' ).slider({
		range: 'min',
		value: options.timeout,
		min: 500,
		max: 2000,
		step: 5,
		slide: function( event, ui ) {
			$( '#qr_global_timeout' ).val( ui.value );
			$( '#qr_timeout_value' ).val( ui.value );
		}
	});
	$('#qr_timeout_value').val( $('#qr_timeout_slider').slider('value') );
	
	function message(msg,cls,spinner,persist) {
		$("#qr_message_text").removeClass("ok warn").addClass(cls).html(msg);
		$("#qr_loading_spinner")[spinner ? "show" : "hide"]();
		clearTimeout(clearMessage);
		if (!persist) {
			clearMessage = setTimeout(defaultMessage, 3000);
		}
	}
		
	function defaultMessage() {
		message("","",false,false);
	}
	
	function getAllOptions() {		
		return form2object('qr_global_options');	
	}
		
	function actionSave() {
		$("#qr_main_save").button('disable');
		message("Saving configuration ....","",true,true);
		save();
	}
	
	function save() {
					
		jQuery.post(
			ajaxUrl,
			{
				'action' : 'qrSaveOptions',
				'options' : JSON.stringify( getAllOptions() ),
				'qr_admin_nonce' : ajaxNonce
			},
			saved
		);
		
	}
	
	function saved(response) {
		if (response && response.ok) {
			console.log(response);
			message("Configuration saved","ok");
			dirty = false;
			lastEditedValues = JSON.stringify(getAllOptions());
		} else {
			alert(response);
			console.log(response);
			message("Error while saving data","warn");
		}
		$("#qr_main_save").button('enable');
	}
	
	$('a[rel=save]').on('click', function(){
		console.log('getAllOptions() : ' + JSON.stringify(getAllOptions()));
		actionSave();
	});
	
	$('a[data-help],label[data-help]', main ).qtip( toolTipConf );

	$("#qr_documentation table").addClass( "widefat" );
	$("#qr_documentation table tr td:first-child").addClass( "parameter" );
	$("#qr_documentation table tr:even").addClass( "even" );
	
})(jQuery);	