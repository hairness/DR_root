<?php 
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//the name of the passed image
	//example would be:   http://myapplication.com/image.php?i=photo.jpg
	if(isset($_POST['filename'])){
	$src = $_POST['filename'];
	} else {
	$src = $_GET['i'];
	}
		
	//folder where the images are 
	$src_folder = '/designradar.net/wp-content/uploads/objects/';
	
	//folder where the thumbnails will be saved to
	//you may need to chmod 775 or 777 this folder
	$thumb_folder = '/designradar.net/wp-content/uploads/objects/thumbnails/'; 
		
		require_once('inc/imagemanipulation.php'); // class.Images
		
		$objImage = new ImageManipulation($src_folder . $src);
		if ( $objImage->imageok ) {
			$objImage->setCrop($_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);
			$objImage->saveThumb($src_folder . 'thumbnail-' .$src);
			var_dump();
		} else {
			echo 'Error!';
		}
	}
	
	
	

?>

<html>
	<head>
		<title>Jcrop Application Demo</title>
		<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="js/jcrop/jquery.Jcrop.min.js"></script>
		<script type="text/javascript" src="js/jquery.application.js"></script>
		
		<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="js/jcrop/jquery.Jcrop.css" media="screen" />
		
	</head>
	
	
	<body>
			
		<div id="body">
		<h2><?php echo $src; ?></h2>
	  
	  <?php 
	  	
	  	//display original image information
	  	list($imgwidth, $imgheight, $imgtype, $imgattr) = getimagesize($src_folder . $src);
			echo '<p><a href="'.$src_folder . $src .'" >Original Image</a>: '.$imgwidth.' x '.$imgheight.'<br />';
	  	
	  	//display current thumbnail information if exists
		  if (file_exists($src_folder . 'thumbnail-' . $src)) {
				list($thwidth, $thheight, $thtype, $athttr) = getimagesize($src_folder . urlencode('thumbnail-'.$src));
				echo '<a href="'.$src_folder . 'thumbnail-'. $src .'" >Current Thumbnail</a>:  '.$thwidth.' x '.$thheight .'</p>';
			} else {
				echo 'Current Thumbnail: <em>none</em></p>';
			}
		?>
		
		<!-- image for Jcrop -->
		<img src="<?php echo $src_folder . $src; ?>" id="cropbox" />

		<!-- selection dimentions -->
		<div id="handw" class="toggle" >Selection Dimentions<br /><span id="picw"></span> x <span id="pich"></span></div>
 
    <!-- form that Jcrop fills in -->
    <form id="jcropform" action="image.php?i=<?php echo $src; ?>" method="post" onsubmit="return checkCoords();">
      <input type="hidden" id="x" name="x" />
      <input type="hidden" id="y" name="y" />
      <input type="hidden" id="w" name="w" />
      <input type="hidden" id="h" name="h" />
      <input type="submit" class="submit" value="Create Thumbnail" /> 
      &nbsp; <span class="small"><em>ctrl-Q</em> or <em>command-Q</em> for square</span>
    </form>
	
		<p>Demo for <a href="http://www.cagintranet.com/archive/how-to-use-jcrop-from-within-an-application/">How to use Jcrop from within an Application</a></p>
	
		</div>

</body>
</html>