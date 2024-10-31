<!--Start tsepop.htm-->
<!DOCTYPE html>
<html>
<head>
	<title>QrTipsy</title>

<script type="text/javascript" src="<?php echo $_GET['qrtipsypop']; ?>"></script>
<script src="//code.jquery.com/jquery.min.js"></script>
<script src="<?php echo $_GET['pluginUrl'] . 'js/jqueryui.js' ?>"></script>
<script src="<?php echo $_GET['pluginUrl'] . 'js/jsonlib.js' ?>"></script>

<link rel="stylesheet" href="<?php echo $_GET['pluginUrl'] . 'css/bootstrap.css' ?>" />
<link rel="stylesheet" href="<?php echo $_GET['pluginUrl'] . 'css/bootstrap-responsive.css' ?>" />
</head>
<body>
	<div class="container">		
		<form class="form-horizontal qrtipsypop">
			<fieldset>
				<div id="legend" class="">
					<legend class="">Fill it, hit Insert shortcode and there you Go!</legend>
				</div>
				<div class="alert alert-error hidden">
					<!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
					<strong>Oh snap!</strong> Change a few things up and try submitting again.
				</div>
				<div class="control-group">
					<!-- Text input-->
					<label class="control-label" for="input01">Text</label>
					<div class="controls">
						<input type="text" placeholder="Link Text" class="input span3 text">
					<p class="help-block">Enter the Link Text</p>
					</div>
				</div>
				<div class="control-group">
					<!-- Text input-->
					<label class="control-label" for="input01">URL</label>
					<div class="controls">
						<input type="text" placeholder="http://www.example.com/follow_me" class="input span3 href">
					<p class="help-block">Enter the URL/Link.</p>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<a class="GSC btn"><i class="icon-qrcode"></i> Insert Shortcode</a>
						<a class="btn btn-inverse" id="popCancel">Cancel</a>
					</div>
				</div>
				
			</fieldset>
		</form>
	
	<script type="text/javascript">
	
		var QRTIPSYDialog = {
			
			init : function( ed ) {
				tinyMCEPopup.resizeToInnerSize();
			},

			insert : function insertTSE( code ) {
				tinyMCEPopup.execCommand( 'mceInsertContent', false, code );
				tinyMCEPopup.close();
			}
		};
		
		tinyMCEPopup.onInit.add( QRTIPSYDialog.init, QRTIPSYDialog );
	
		(function($){
			
			$('a').on('click', function(e){
				e.preventDefault();
			});

			function googlurl(url, cb) {
			  jsonlib.fetch({
				url: 'https://www.googleapis.com/urlshortener/v1/url',
				header: 'Content-Type: application/json',
				data: JSON.stringify({longUrl: url})
			  }, function (m) {
				var result = null;
				try {
				  result = JSON.parse(m.content).id;
				  if (typeof result != 'string') result = null;
				} catch (e) {
				  result = null;
				}
				cb(result);
			  });
			}
			//googlurl(longUrl , function(s) { $('div.')("<BR>Short Url: "+s); });*/
			
			/*
			 * $.getJSON('http://call.jsonlib.com/fetch?url=https://www.googleapis.com/urlshortener/v1/url&header=Content-Type:%20application/json&data={longUrl:"'+url+'"}', function(r){ console.log(JSON.parse(r.content).id); })
			 */
			
			$('.GSC').on('click', function() {
				var href = ( $('.href').val() )? $('.href').val() : '';
				var text = ( $('.text').val() )? $('.text').val() : '';

				if( href && text ) {
					googlurl( href, function(r) {
						if( r !=null ) {
							QRTIPSYDialog.insert( '[qrtipsy href=' + r + ']' + text + '[/qrtipsy]' );
						}
						else {
							$('.alert').removeClass('hidden');
						}
					});
				}
				else {
					$('.alert').removeClass('hidden');
				}
			});
			
			$('#popCancel').on('click', function(e){
				tinyMCEPopup.close();
			});
		})(jQuery);

	</script>
</body>
</html>

<?php /* End tsepop.htm */ ?>