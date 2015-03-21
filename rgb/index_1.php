<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Disabling R,G or B.</title>
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
<p><h2>Procedure to disable channel: </h2>
	<br>1. Choose an image file first..<br>
	<br>2. Select your image and then click on upload.<br>
	<br>3. Adjust your RGB band (Left: RED Middle: BLUE Right: RED).<br>
	<br>4. Click on Sharpen Image button to see the effects.<br>
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
-webkit-appearance: slider-horizontal" min="10" max="30" id="kkk" value="20" step="10" onchange="channel(imgObj)" /><br>
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

