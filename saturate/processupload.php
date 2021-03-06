<noscript>
<div align="center"><a href="index.php">Go Back To Upload Form</a></div><!-- If javascript is disabled -->
</noscript>
<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

if(isset($_POST))
{
	 //Some Settings
	$ThumbSquareSize 		= 200; //Thumbnail will be 200x200
	$BigImageMaxSize 		= 500; //Image Maximum height or width
	$ThumbPrefix			= "thumb_"; //Normal thumb Prefix
	$DestinationDirectory	= 'uploads/'; //Upload Directory ends with / (slash)
	$Quality 				= 100;

	// check $_FILES['ImageFile'] array is not empty
	// "is_uploaded_file" Tells whether the file was uploaded via HTTP POST
	if(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name']))
	{
			die('Something went wrong with Upload!'); // output error when above checks fail.
	}
	
	// Random number for both file, will be added after image name
	$RandomNumber 	= rand(0, 9999999999); 

	// Elements (values) of $_FILES['ImageFile'] array
	//let's access these values by using their index position
	$ImageName 		= str_replace(' ','-',strtolower($_FILES['ImageFile']['name'])); 
	$ImageSize 		= $_FILES['ImageFile']['size']; // Obtain original image size
	$TempSrc	 	= $_FILES['ImageFile']['tmp_name']; // Tmp name of image file stored in PHP tmp folder
	$ImageType	 	= $_FILES['ImageFile']['type']; //Obtain file type, returns "image/png", image/jpeg, text/plain etc.

	//Let's use $ImageType variable to check wheather uploaded file is supported.
	//We use PHP SWITCH statement to check valid image format, PHP SWITCH is similar to IF/ELSE statements 
	//suitable if we want to compare the a variable with many different values
	switch(strtolower($ImageType))
	{
		case 'image/png':
			$CreatedImage =  imagecreatefrompng($_FILES['ImageFile']['tmp_name']);
			break;
		case 'image/gif':
			$CreatedImage =  imagecreatefromgif($_FILES['ImageFile']['tmp_name']);
			break;			
		case 'image/jpeg':
		case 'image/pjpeg':
			$CreatedImage = imagecreatefromjpeg($_FILES['ImageFile']['tmp_name']);
			break;
		default:
			die('Unsupported File!'); //output error and exit
	}
	
	//PHP getimagesize() function returns height-width from image file stored in PHP tmp folder.
	//Let's get first two values from image, width and height. list assign values to $CurWidth,$CurHeight
	list($CurWidth,$CurHeight)=getimagesize($TempSrc);
	//Get file extension from Image name, this will be re-added after random name
	$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
  	$ImageExt = str_replace('.','',$ImageExt);
	
	//remove extension from filename
	$ImageName 		= preg_replace("/\\.[^.\\s]{3,4}$/", "", $ImageName); 
	
	//Construct a new image name (with random number added) for our new image.
	$NewImageName = $ImageName.'-'.$RandomNumber.'.'.$ImageExt;
	//set the Destination Image
	$thumb_DestRandImageName 	= $DestinationDirectory.$ThumbPrefix.$NewImageName; //Thumb name
	$DestRandImageName 			= $DestinationDirectory.$NewImageName; //Name for Big Image
	
	
	//Resize image to our Specified Size by calling resizeImage function.
	if(resizeImage($CurWidth,$CurHeight,$BigImageMaxSize,$DestRandImageName,$CreatedImage,$Quality,$ImageType))
	{
		//Create a square Thumbnail right after, this time we are using cropImage() function
		if(!cropImage($CurWidth,$CurHeight,$ThumbSquareSize,$thumb_DestRandImageName,$CreatedImage,$Quality,$ImageType))
			{
				echo 'Error Creating thumbnail';			}
		/*
		At this point we have succesfully resized and created thumbnail image
		We can render image to user's browser or store information in the database
		For demo, we are going to output results on browser.
		*/
		echo '<table width="100%" border="0" cellpadding="4" cellspacing="0">';
		echo '<tr>';
		echo '<td align="center"><img id="image_output" src="uploads/'.$ThumbPrefix.$NewImageName.'" alt="Thumbnail"></td>';
		echo '</tr><tr>';
		//echo '<td align="center"><img id="image_output" src="uploads/'.$NewImageName.'" alt="Resized Image"></td>';
		echo '</tr>';
		echo '</table>';

		/*
		// Insert info into database table!
		mysql_query("INSERT INTO myImageTable (ImageName, ThumbName, ImgPath)
		VALUES ($DestRandImageName, $thumb_DestRandImageName, 'uploads/')");
		*/

	}else{
		die('Resize Error'); //output error
	}
}
	
// This function will proportionally resize image 
function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{
	//Check Image size is not 0
	if($CurWidth <= 0 || $CurHeight <= 0) 
	{
		return false;
	}
	
	//Construct a proportional size of new image
	$ImageScale      	= min($MaxSize/$CurWidth, $MaxSize/$CurHeight); 
	$NewWidth  			= ceil($ImageScale*$CurWidth);
	$NewHeight 			= ceil($ImageScale*$CurHeight);
	$NewCanves 			= imagecreatetruecolor($NewWidth, $NewHeight);
	
	// Resize Image
	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	//Destroy image, frees memory	
	if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
	return true;
	}

}

//This function corps image to create exact square images, no matter what its original size!
function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{	 
	//Check Image size is not 0
	if($CurWidth <= 0 || $CurHeight <= 0) 
	{
		return false;
	}
	
		if($CurWidth>$CurHeight)
	{
		$y_offset = 0;
		$x_offset = ($CurWidth - $CurHeight) / 2;
		$square_size 	= $CurWidth - ($x_offset * 2);
	}else{
		$x_offset = 0;
		$y_offset = ($CurHeight - $CurWidth) / 2;
		$square_size = $CurHeight - ($y_offset * 2);
	}
	
	$NewCanves 	= imagecreatetruecolor($iSize, $iSize);	
	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	//Destroy image, frees memory	
	if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
	return true;

	}
	  
}
?>
<!-- Javascript code for image processing -->
<script> 
        $(document).ready(function(){
        $('#toggleDesaturate').click(function(){
            var imgObj = document.getElementById('image_output');
            
            if($.browser.msie){
                channelIE(imgObj);
            } else {
                imgObj.src = channel(imgObj);
            }           
        });
    });

   

     function channel(imgObj)
    {
     
		var kkj=document.getElementById("kkk");
var K=kkj.value;
	         var canvas = document.createElement('canvas');
        var canvasContext = canvas.getContext('2d');
        
        var imgW = imgObj.width;
        var imgH = imgObj.height;
        canvas.width = imgW;
        canvas.height = imgH;
        
        canvasContext.drawImage(imgObj, 0, 0);
        var imgPixels = canvasContext.getImageData(0, 0, imgW, imgH);
        var src = canvasContext.getImageData(0, 0, imgW, imgH);
		var src1 = canvasContext.getImageData(0, 0, imgW, imgH);
		//var h=0;
		//var s=0;
		//var v=0;
		
		
        for(var y = 0; y < imgPixels.height; y++){
            for(var x = 0; x < imgPixels.width; x++){
                
                var i = (y *imgPixels.width*4) + x*4  ;
				
		        
				var r= imgPixels.data[i];
				var g= imgPixels.data[i+1];
				var b= imgPixels.data[i+2];
				
		        var h, s, v;
                var mn, mx, d;

                mn = Math.min(r, g, b);
                mx = Math.max(r, g, b);
                d = mx - mn;
    
                v = mx;
                if( mx != 0 ){
                     s = d / mx;
				     if( r == mx ){
                        h = ( g - b ) / d;} 
                          else if( g == mx ){
                              h = 2 + ( b - r ) / d; }
                          else{
                               h = 4 + ( r - g ) / d; 

                               h *= 60; }   

                  if( h < 0 ){
                       h += 360;}
                
				}
				
				else {
                   s = 0;
                   h = -1;
                   
                     }
					 
            src.data[i]=h;
			src.data[i+1]=K;
			src.data[i+2]=v;
				
	         s=K;  
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	            
		   
		   
		   
		   var r1, g1, b1;
           
            if(s==0){
           var r1=Math.round(v);
		   var g1=Math.round(v);
		   var b1=Math.round(v);
           }
		   
		   else{
  
           var h1 = h * 6;
           if (h==1)  h1 = 0;
  
           var a = Math.floor( h1 );
           var a1 = v*(1-s);
           var a2 = v*(1-s*(h1-a));
           var a3 = v*(1-s*(1-(h1-a)));
		   
		   
  if(a==0){ 
    r1 = v; 
    g1 = a3; 
    b1 = a1;
  }else if(a==1){ 
    r1 = a2;
    g1 = v;
    b1 = a1;
  }else if(a==2){
    r1 = a1;
    g1 = v;
    b1 = a3
  }else if(a==3){
    r1 = a1;
    g1 = a2;
    b1 = v;
  }else if (a==4){
    r1 = a3;
    g1 = a1;
    b1 = v;
  }else{ 
    r1 = v;
    g1 = a1;
    b1 = a2
  }
  
  r1=Math.round(r1 );
  g1=Math.round(g1 );
  b1=Math.round(b1 );
	
	}
                
            src1.data[i]=r1;
			src1.data[i+1]=g1;
			src1.data[i+2]=b1;      
 
                  
				 
            }  
        }
        
        canvasContext.putImageData(src1, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
        return canvas.toDataURL();
    }
    </script> 