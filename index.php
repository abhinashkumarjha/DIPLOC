<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>DIPOLC : Home </title>
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script src="cufon-yui.js" type="text/javascript"></script>
		<script src="BabelSans_500.font.js" type="text/javascript"></script>
		<script src="jquery.easing.1.3_menu.js" type="text/javascript"></script>
		<script>
$(document).ready(function() {

	var div = $('#nav_menu_lab');
	var start = $(div).offset().top;

	$.event.add(window, "scroll", function() {
		var p = $(window).scrollTop();
		$(div).css('position',((p)>start) ? 'fixed' : 'static');
		$(div).css('top',((p)>start) ? '0px' : '');
	});

});

</script>
		<script type="text/javascript">
			$(function() {
				Cufon.replace('a, span').CSS.ready(function() {
					var $menu 		= $("#slidingMenu");
					
					/**
					* the first item in the menu, 
					* which is selected by default
					*/
					var $selected	= $menu.find('li:first');
					
					/**
					* this is the absolute element,
					* that is going to move across the menu items
					* it has the width of the selected item
					* and the top is the distance from the item to the top
					*/
					var $moving		= $('<li />',{
						className	: 'move',
						top			: $selected[0].offsetTop + 'px',
						width		: $selected[0].offsetWidth + 'px'
					});
					
					/**
					* each sliding div (descriptions) will have the same top
					* as the corresponding item in the menu
					*/
					$('#slidingMenuDesc > div').each(function(i){
						var $this = $(this);
						$this.css('top',$menu.find('li:nth-child('+parseInt(i+2)+')')[0].offsetTop + 'px');
					});
					
					/**
					* append the absolute div to the menu;
					* when we mouse out from the menu 
					* the absolute div moves to the top (like innitially);
					* when hovering the items of the menu, we move it to its position 
					*/
					$menu.bind('mouseleave',function(){
							moveTo($selected,400);
						  })
						 .append($moving)
						 .find('li')
						 .not('.move')
						 .bind('mouseenter',function(){
							var $this = $(this);
							var offsetLeft = $this.offset().left - 20;
							//slide in the description
							$('#slidingMenuDesc > div:nth-child('+ parseInt($this.index()) +')').stop(true).animate({'width':offsetLeft+'px'},400, 'easeOutExpo');
							//move the absolute div to this item
							moveTo($this,400);
						  })
						  .bind('mouseleave',function(){
							var $this = $(this);
							var offsetLeft = $this.offset().left - 20;
							//slide out the description
							$('#slidingMenuDesc > div:nth-child('+ parseInt($this.index()) +')').stop(true).animate({'width':'0px'},400, 'easeOutExpo');
						  });;
					
					/**
					* moves the absolute div, 
					* with a certain speed, 
					* to the position of $elem
					*/
					function moveTo($elem,speed){
						$moving.stop(true).animate({
							top		: $elem[0].offsetTop + 'px',
							width	: $elem[0].offsetWidth + 'px'
						}, speed, 'easeOutExpo');
					}
				}) ;
			});
		</script>
		<style>
          span.reference_menu{
              position:fixed;
              left:10px;
              bottom:10px;
              font-size:14px;
          }
          span.reference_menu a{
              color:#aaa;
              text-decoration:none;
          }
          #nav_menu_lab {
			float: right;
			z-index: 40;
			position: relative;
			height: 40px;
			background: #2183c4;
			display: block;
			width: 100%;
	
}
		#navslide_lab {
			float: right;
			margin-right: 40px;
			margin-top: 20px;
			z-index: 10;

}
		#navslide_lab li {
			float: left;
			margin-left: 40px;
			margin-right: 30px;
			margin-top: -9px;
			text-decoration: none;
			list-style: none;
			font-family: "proxima-nova", "Helvetica", sans-serif;
			text-transform: uppercase;

}
		#navslide_lab a {
			color: white;
			text-decoration: none;
			font-weight: bolder;
		}
         </style>
	</head>
	<body>
	<p style="font-size: 30px; margin-left: 20px; font-family: arial; color: white; opacity: 0.8;;">
		Digital Image Processing Online Learning Centre (DIPOLC) <br>
	</p>
	<div id="nav_menu_lab"> 
		<ul id="navslide_lab">
            <li><a href="index.php" target="_top">Home</a></li>
		    <li><a href="contact.html" target="_top">Contact Us</a></li>
		</ul>
	</div>
	<div id="content">	
	    <div id="slidingMenuDesc" class="slidingMenuDesc">		
			<div><span>Convert the image from RGB to Grayscale  </span></div>
			<div><span>Make your image look brighter than before </span></div>
			<div><span>Change your image's contrast </span></div>
			<div><span>Saturate your image with this tool </span></div>
			<div><span>See the sharpening effect on your image </span></div>
			<div><span>Disabling R G or B channel on a colour image </span></div>
			<div><span>Application of Gaussian Filter on the image </span></div>
			<div><span>Detecting the edges of your image </span></div>
			<div><span>Apply Embossing effect on your image </span></div>
			<div><span>Application of Median Filter on an image having noise </span></div>
			<div><span>Bilateral Filter application an image </span></div>
			<div><span>Scaling your image by BILINEAR or NEAREST NEIGHBOUR </span></div>
			<div><span>Swirl your image using this technique </span></div>
			<br><br><br><br>
		<!--	<div><span>1st random effect on your image </span></div>
			<div><span>2nd random effect on your image </span></div>
			<div><span>3rd random effect on your image </span></div>
			<div><span>4th random effect on your image </span></div>
			<div><span>5th random effect on your image </span></div>  -->
		</div>	
		<ul id="slidingMenu" class="slidingMenu">
			<li><a href="">List of Tutorials</a></li>
			<li><a href="grayscale/index.php">Gray Scale</a></li>
			<li><a href="brightness/index.php">Brightness</a></li>
			<li><a href="contrast/index.php">Contrast</a></li>
			<li><a href="saturate/index.php">Saturation</a></li>
			<li><a href="sharpening/index.php">Sharpening</a></li>
			<li><a href="rgb/index.php">RGB Band</a></li>
			<li><a href="gaussian_filter/index.php">Gaussian Blurring</a></li>
			<li><a href="edge_detection/index.php">Edge Detection</a></li>
			<li><a href="embossing/index.php">Embossing</a></li>
			<li><a href="median_smoothing/index.php">Median Smoothing</a></li>
			<li><a href="bilateral_filtering/index.php">Bilateral Filtering</a></li>
			<li><a href="interpolation/index.php">Interpolation</a></li>
			<li><a href="swirl/index.php">Swirl Effect</a></li>
	<!--		<li><a href="special_effect_1/index.php">Special Effect 1</a></li>
			<li><a href="special_effect_2/index.php">Special Effect 2</a></li>
			<li><a href="special_effect_3/index.php">Special Effect 3</a></li>
			<li><a href="special_effect_4/index.php">Special Effect 4</a></li>
			<li><a href="special_effect_5/index.php">Special Effect 5</a></li>  -->
		</ul>
    </div>		
  <!--  <div id="footer" align="center">		
        <hr color='#FFF'>
         last updated March 2015, &copy All rights reserved
    </div> -->
</body>
</html>






