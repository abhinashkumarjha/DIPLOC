<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image Embossing.</title>
<style>
input[type=range]:first-of-type {
  width: 200px;
}
</style>
<script src="https://raw.github.com/fryn/html5slider/master/html5slider.js"></script>
<script>
onload = function() {
  var $ = function(id) { return document.getElementById(id); };
  $('kkk').oninput = function() { $('uno').innerHTML = this.value; };
  $('kkk').oninput();
  $('two').oninput = function() { $('dos').innerHTML = this.value; };
  $('two').oninput();
  $('mms').innerHTML =
    ['min: ' + $('two').min,
     'max: ' + $('two').max,
     'step: ' + $('two').step].join(', ');
};
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<link href="style/style_choose.css" type="text/css" rel="stylesheet"/>
<script src="js/Fancy File Inputs.js" type="text/javascript" ></script>
 <script> 
        $(document).ready(function() { 
			$('#UploadForm').on('submit', function(e) {
				e.preventDefault();
				$('#SubmitButton').attr('disabled', ''); // disable upload button
				//show uploading message
				$("#output").html('<div style="padding:10px"><img src="images/ajax-loader.gif" alt="Please Wait"/> <span>Uploading...</span></div>');
				$(this).ajaxSubmit({
					target: '#output',
					success:  afterSuccess //call function after success
				});
			});
        }); 

		function afterSuccess()  { 
			$('#UploadForm').resetForm();  // reset form
			$('#SubmitButton').removeAttr('disabled'); //enable submit button

		} 
    </script> 

 <link href="style/style.css" rel="stylesheet" type="text/css" />
 
</head>

<body>
<br>
<div id="subcontent">
<p><h2>Procedure to emboss the image: </h2>
	<br>1. Choose an image file first.<br>
	<br>2. Select your image and then click on upload.<br>
	<br>3. Adjust your range (Left: UPPER SIDE EMBOSSING Right: LOWER SIDE EMBOSSING).<br>
	<br>4. Click on Emboss Image button to see the effects.<br>
	<br>5. Click on Reset button to start a fresh operation. </p>
</div>
<br>
<br>
<div align="center">
  <form action="processupload.php" method="post" enctype="multipart/form-data" id="UploadForm">
	<span class="file-wrapper">
<input name="ImageFile" type="file" id="photo"/><br>
	<span class="button">Click Here To Choose Image</span>
</span>
<br>
<br>
<span class="file-wrapper">
<input type="submit"  id="photo_1" />
<span class="button">Click Here To Upload Image</span>

</span>
<br><br>
<input type="range" style="width: 200px; height: 25px; 
-webkit-appearance: slider-horizontal" min="10" max="20" id="kkk" value="15" step="5" onchange="channel(imgObj)" />
<div id="uno">&nbsp;</div>
</form>
<div id="output"></div>

 <form>
 	<span class="file-wrapper">
 	<input id="toggleDesaturate" type="button" value="CONVERT TO GRAYSCALE IMAGE"><br>
 	<span class="button">APPLY EFFECT</span>
</span>

 		<span class="file-wrapper">
		<input type="button"  value="CLICK HERE TO RESET IMAGE" onClick="window.location.reload()">
		<span class="button">RESET IMAGE</span>
</span>
		</form>
</div>	



</body>
</html>

