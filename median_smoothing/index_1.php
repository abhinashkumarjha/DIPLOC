<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smoothing..</title>
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
<p><h2>Procedure to apply Median Filter: </h2>
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
	<br>

<div id="sample">
	<b>Note:</b> You need to make a proper selection of image in order to see the effects. See the example below to understand the process.
	<br>
	<p style="margin-left: 44px">Below is a sample input image which has salt and pepper noise in it. Click on Filter Sample to see the effect.</p><br>
	<div id="image_procedure"><form><img src="images/lenasal.png" id="image_sample">
		<div id="buttons">

			<span class="file-wrapper">
 	<input id="toggleDesaturate_1" type="button" value="CONVERT TO GRAYSCALE IMAGE"><br>
 	<span class="button">APPLY EFFECT</span>
</span>
	<br> <br>
 		<span class="file-wrapper">
		<input type="button"  value="CLICK HERE TO RESET IMAGE" onClick="window.location.reload()">
		<span class="button">RESET IMAGE</span>
</span>
	</div>
		</div>

		<script>
			 $(document).ready(function(){
        $('#toggleDesaturate_1').click(function(){
            var imgObj = document.getElementById('image_sample');
            
            if($.browser.msie){
                medianImageIE(imgObj);
            } else {
                imgObj.src = medianImage(imgObj);
            }           
        });
		
    });

   

    function medianImage(imgObj)
    {   
	    //var q=prompt("Input no btw 0 to 1 for fraction of noice u want to add.","Enter the number here");
	    var canvas = document.createElement('canvas');
        var canvasContext = canvas.getContext('2d');
        
        var imgW = imgObj.width;
        var imgH = imgObj.height;
        canvas.width = imgW;
        canvas.height = imgH;
        
        canvasContext.drawImage(imgObj, 0, 0);
        var imgPixels = canvasContext.getImageData(0, 0, imgW, imgH);
		var src = canvasContext.getImageData(0, 0, imgW, imgH);		
		
		var a=new Array(9); 
		var b=new Array(9);
		var c=new Array(9);
		
		/*for(var y = 1; y < imgPixels.height-1; y++){
            for(var x = 1; x < imgPixels.width-1; x++){
                var i = (y * 4) * imgPixels.width + x * 4;
				var temp = Math.random();
				if(temp<q)
				{ 
				    temp=Math.random();
				    if(temp<0.5)
                    {
                        imgPixels.data[i]=255;
                        imgPixels.data[i+1]=255;
                        imgPixels.data[i+2]=255;
                    }
                    else
                    {
                        imgPixels.data[i]=0;
                        imgPixels.data[i+1]=0;
                        imgPixels.data[i+2]=0;
                    } 					
				}
			}
        }*/
		
		 for(y = 1; y < imgPixels.height-1; y++){
            for(x = 1; x < imgPixels.width-1; x++){
                var i = (y * 4) * imgPixels.width + x * 4; 		
				if((imgPixels.data[i]==255 && imgPixels.data[i+1]==255 && imgPixels.data[i+2]==255) ||(imgPixels.data[i]==0 && imgPixels.data[i+1]==0 && imgPixels.data[i+2]==0))
				{
				//RED
				var a = new Array(9);
				var b = new Array(9);
				var c = new Array(9);
				//for Red
                a[0]=src.data[i-((imgPixels.width-1)*4)-4];
		        a[1]=src.data[i -(imgPixels.width-1)*4];
		        a[2]=src.data[i -((imgPixels.width-1)*4)+4];
		        a[3]=src.data[i-4];
		        a[4]=imgPixels.data[i];
		        a[5]=imgPixels.data[i +4];
		        a[6]=imgPixels.data[i +((imgPixels.width-1)*4)-4];
		        a[7]=imgPixels.data[i +((imgPixels.width-1)*4)];
	          	a[8]=imgPixels.data[i +((imgPixels.width-1)*4)+4];
				
                //for Green
				b[0]=src.data[i-((imgPixels.width-1)*4)-4+1];
		        b[1]=src.data[i -(imgPixels.width-1)*4+1];
		        b[2]=src.data[i -((imgPixels.width-1)*4)+4+1];
		        b[3]=src.data[i-4+1];
		        b[4]=imgPixels.data[i+1];
		        b[5]=imgPixels.data[i +4+1];
		        b[6]=imgPixels.data[i +((imgPixels.width-1)*4)-4+1];
		        b[7]=imgPixels.data[i +((imgPixels.width-1)*4+1)];
	          	b[8]=imgPixels.data[i +((imgPixels.width-1)*4)+4+1];
                
				//for Blue
				c[0]=src.data[i-((imgPixels.width-1)*4)-4+2];
		        c[1]=src.data[i -(imgPixels.width-1)*4+2];
		        c[2]=src.data[i -((imgPixels.width-1)*4)+4+2];
		        c[3]=src.data[i-4+2];
		        c[4]=imgPixels.data[i+2];
		        c[5]=imgPixels.data[i +4+2];
		        c[6]=imgPixels.data[i +((imgPixels.width-1)*4)-4+2];
		        c[7]=imgPixels.data[i +((imgPixels.width-1)*4)+2];
	          	c[8]=imgPixels.data[i +((imgPixels.width-1)*4)+4+2];
				
                //arranging in ascending order
                 a.sort(function(a,b){return a-b});				
                b.sort(function(a,b){return a-b});
				c.sort(function(a,b){return a-b});
				
				    src.data[i]=a[4];
					src.data[i+1]=b[4];
					src.data[i+2]=c[4];
				}
                
            }
        }
      
        canvasContext.putImageData(src, 0, 0, 0, 0, src.width, src.height);
        return canvas.toDataURL();
    }
    </script>
	</div>
</div>

</body>
</html>

