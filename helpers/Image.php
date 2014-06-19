<?php

//
// PARAMETERS
//

// Parameters need to be passed in through the URL's query string:

// image		absolute path of local image starting with "/" (e.g. /images/toast.jpg)
// width		maximum width of final image in pixels (e.g. 700)
// height		maximum height of final image in pixels (e.g. 700)
// color		(optional) background hex color for filling transparent PNGs (e.g. 900 or 16a942)
// cropratio	(optional) ratio of width to height to crop final image (e.g. 1:1 or 3:2)
// 				(optional) percent of the image to start the crop (e.g. 1:1:25 or 3:2:75) 
//						   only use from bottom to top (not horizontaly)
// rotate		(optional, 90, 180 or 270) rotation degrees
// nocache		(optional) does not read image from the cache
// quality		(optional, 0-100, default: 90) quality of output image

//
// EXAMPLES
//

// Resizing a JPEG:
// <img src="/image.php/image-name.jpg?width=100&amp;height=100&amp;image=path/to/image.jpg" alt="Don't forget your alt text" />

// Resizing and cropping a JPEG into a square:
// <img src="/image.php/image-name.jpg?width=100&amp;height=100&amp;cropratio=1:1&amp;image=path/to/image.jpg" alt="Don't forget your alt text" />

// Matting a PNG with #990000:
// <img src="/image.php/image-name.png?color=900&amp;image=path/to/image.png" alt="Don't forget your alt text" />

//
// Let's start this shit
//

define('MEMORY_TO_ALLOCATE', '100M');

class Image
{
	public	$source,
			$destination,
			$max_width,
			$max_height,
			$crop_ratio,
			$quality,
			$rotate,
			$color;
	
	private	$width,
			$height,
			$mime,
			$thumb_width,
			$thumb_height,
			$offset_x,
			$offset_y;
	
	function __construct($image_file, $destination=false, $max_width=false, $max_height=false, $crop_ratio=false, $quality=90, $rotate=false, $color_fill=false)
	{
		if (!file_exists($image_file))
			return false;
		
		$this->source = $image_file;
		$this->destination = !$destination ? $image_file: $destination;
		
		//if (!is_writable($this->destination))
		//	return false;
		
		$this->max_width = $max_width;
		$this->max_height = $max_height;
		$this->crop_ratio = $crop_ratio;
		$this->quality = $quality;
		$this->rotate = $rotate;
		$this->color = $color_fill;
		
		if ($this->initialize()) {
			$this->calculateRatio();
			$this->generate();
		}
	}
	
	function initialize()
	{
		// Ratio cropping
		$this->offset_x = 0;
		$this->offset_y = 0;
		
		$size = GetImageSize($this->source);
		$this->width = $size[0];
		$this->height = $size[1];
		$this->mime = $size['mime'];
		
		if (!$this->max_width && $this->max_height)
			$this->max_width = 99999999999999;
		else if ($this->max_width && !$this->max_height)
			$this->max_height = 99999999999999;
		else if ($this->color && !$this->max_width && !$this->max_height) {
			$this->max_width = $this->width;
			$this->max_height = $this->height;
		}
		
		// If we don't have a max width or max height, OR the image is smaller than both
		// we do not want to resize it, so we simply output the original image and exit
		if ((!$this->max_width && !$this->max_height) || (!$this->color && $this->max_width >= $this->width && $this->max_height >= $this->height))
		{
			copy($this->source, $this->destination);
			chmod($this->destination, 0755);
			return false;
		}
		
		return true;
	}
	
	function calculateRatio()
	{		
		$cropRatio = explode(':', (string) $this->crop_ratio);
		if (count($cropRatio) >= 2)
		{
			$ratioComputed     = $this->width / $this->height;
			$cropRatioComputed = (float) $cropRatio[0] / (float) $cropRatio[1];
			
			if ($ratioComputed < $cropRatioComputed)
			{ // Image is too tall so we will crop the top and bottom
				$origHeight     = $this->height;
				$this->height   = $this->width / $cropRatioComputed;
				$this->offset_y = ($origHeight - $this->height) / (isset($cropRatio[2]) ? round(100 / (int)$cropRatio[2]): 2);
			}
			else if ($ratioComputed > $cropRatioComputed)
			{ // Image is too wide so we will crop off the left and right sides
				$origWidth      = $this->width;
				$this->width    = $this->height * $cropRatioComputed;
				$this->offset_x = ($origWidth - $this->width) / 2; // always crop centered
			}
		}
		
		// Setting up the ratios needed for resizing. We will compare these below to determine how to
		// resize the image (based on height or based on width)
		$xRatio = $this->max_width / $this->width;
		$yRatio = $this->max_height / $this->height;
		
		if ($xRatio * $this->height < $this->max_height) // Resize the image based on width
		{
			$this->thumb_height = ceil($xRatio * $this->height);
			$this->thumb_width  = $this->max_width;
		}
		else // Resize the image based on height
		{
			$this->thumb_width  = ceil($yRatio * $this->width);
		 	$this->thumb_height = $this->max_height;
		}

	}
	
	function generate()
	{
		// We don't want to run out of memory
		ini_set('memory_limit', MEMORY_TO_ALLOCATE);
		
		// Set up a blank canvas for our resized image (destination)
		$dst = imagecreatetruecolor($this->thumb_width, $this->thumb_height);
		
		// Set up the appropriate image handling functions based on the original image's mime type
		switch ($this->mime)
		{
			case 'image/gif':
				// We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
				// This is maybe not the ideal solution, but IE6 can suck it
				$creationFunction = 'ImageCreateFromGif';
				$outputFunction   = 'ImagePng';
				$this->mime       = 'image/png'; // We need to convert GIFs to PNGs
				$doSharpen        = false;
				$this->quality    = round(10 - ($this->quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
			break;
			
			case 'image/x-png':
			case 'image/png':
				$creationFunction = 'ImageCreateFromPng';
				$outputFunction   = 'ImagePng';
				$doSharpen        = false;
				$this->quality    = round(10 - ($this->quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
			break;
			
			default:
				$creationFunction = 'ImageCreateFromJpeg';
				$outputFunction   = 'ImageJpeg';
				$doSharpen        = true;
			break;
		}
		
		// Read in the original image
		$src = $creationFunction($this->source);
		
		if ($this->mime == 'image/png')
		{
			if (!$this->color)
			{
				// If this is a GIF or a PNG, we need to set up transparency
				imagealphablending($dst, false);
				imagesavealpha($dst, true);
			}
			else
			{
				// Fill the background with the specified color for matting purposes
				if ($this->color[0] == '#')
					$this->color = substr($this->color, 1);
				
				$background = false;
				
				if (strlen($this->color) == 6)
					$background	= imagecolorallocate($dst, hexdec($this->color[0].$this->color[1]), hexdec($this->color[2].$this->color[3]), hexdec($this->color[4].$this->color[5]));
				else if (strlen($this->color) == 3)
					$background	= imagecolorallocate($dst, hexdec($this->color[0].$this->color[0]), hexdec($this->color[1].$this->color[1]), hexdec($this->color[2].$this->color[2]));
				
				if ($background)
					imagefill($dst, 0, 0, $background);
			}
		}
		
		// Resample the original image into the resized canvas we set up earlier
		ImageCopyResampled($dst, $src, 0, 0, $this->offset_x, $this->offset_y, $this->thumb_width, $this->thumb_height, $this->width, $this->height);
		
		if ($doSharpen)
		{
			// Sharpen the image based on two things:
			//	(1) the difference between the original size and the final size
			//	(2) the final size
			$sharpness = $this->_findSharp($this->width, $this->thumb_width);
			
			$sharpenMatrix = array(
				array(-1, -2, -1),
				array(-2, $sharpness + 12, -2),
				array(-1, -2, -1)
			);
			
			//$divisor = $sharpness;
			//$offset  = 0;
			imageconvolution($dst, $sharpenMatrix, $sharpness, 0);
		}
		
		// Rotation
		if ($this->rotate && in_array($this->rotate, array(90, 180, 270)))
		{
			$dst = imagerotate($dst, $this->rotate, 0);
		}
		
		// Write the resized image to the cache
		$outputFunction($dst, $this->destination, $this->quality);
		
		// Clean up the memory
		imagedestroy($src);
		imagedestroy($dst);
	}
	
	function _findSharp($orig, $final) // function from Ryan Rud (http://adryrun.com)
	{
		$final	= $final * (750.0 / $orig);
		$a		= 52;
		$b		= -0.27810650887573124;
		$c		= .00047337278106508946;
		
		$result = $a + $b * $final + $c * $final * $final;
		
		return max(round($result), 0);
	}
	
	// params:
	//		watermark   path of the watermark png file
	//		dest_x      the x destination from left if positive and right if negative
	//		dest_y      the y destination from top if positive and bottom if negative
	//		to   		path of the image to add the watermark on it
	function addWatermark($watermark, $dest_x, $dest_y, $to=false)
	{
		if (!$to)
			$to = $this->destination;
		
		$watermark = imagecreatefrompng($watermark);
		
		imagealphablending($watermark, false);
	    imagesavealpha($watermark, true);
	
		$watermark_width = imagesx($watermark);
		$watermark_height = imagesy($watermark);
		
		$image = imagecreatetruecolor($watermark_width, $watermark_height);
		$image = imagecreatefromjpeg($to);
		$size = getimagesize($to);
		
		if ($dest_x < 0)
			$dest_x = $size[0] - $watermark_width - abs($dest_x);
		
		if ($dest_y < 0)
			$dest_y = $size[1] - $watermark_height - abs($dest_y);
		
		imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);
		imagejpeg($image, $to, 100);
		
		imagedestroy($image);
		imagedestroy($watermark);
	}
	
} // end Image class


if (!function_exists('imageconvolution'))
{
	function imageconvolution($src, $filter, $filter_div, $offset){
		if ($src == null) return 0;
	 
		$sx = imagesx($src);
		$sy = imagesy($src);
		$srcback = ImageCreateTrueColor ($sx, $sy);
		ImageAlphaBlending($srcback, false);
		ImageAlphaBlending($src, false);
		ImageCopy($srcback, $src,0,0,0,0,$sx,$sy);

		if ($srcback == null) return 0;
	 
		for ($y=0; $y<$sy; ++$y){
			for($x=0; $x<$sx; ++$x){
				$new_r = $new_g = $new_b = 0;
				$alpha = imagecolorat($srcback, @$pxl[0], @$pxl[1]);
				$new_a = ($alpha >> 24);
	 
				for ($j=0; $j<3; ++$j) {
					$yv = min(max($y - 1 + $j, 0), $sy - 1);
					for ($i=0; $i<3; ++$i) {
							$pxl = array(min(max($x - 1 + $i, 0), $sx - 1), $yv);
						$rgb = imagecolorat($srcback, $pxl[0], $pxl[1]);
						$new_r += (($rgb >> 16) & 0xFF) * $filter[$j][$i];
						$new_g += (($rgb >> 8) & 0xFF) * $filter[$j][$i];
						$new_b += ($rgb & 0xFF) * $filter[$j][$i];
						$new_a += ((0x7F000000 & $rgb) >> 24) * $filter[$j][$i];
					}
				}
	 
				$new_r = ($new_r/$filter_div)+$offset;
				$new_g = ($new_g/$filter_div)+$offset;
				$new_b = ($new_b/$filter_div)+$offset;
				$new_a = ($new_a/$filter_div)+$offset;
	 
				$new_r = ($new_r > 255)? 255 : (($new_r < 0)? 0:$new_r);
				$new_g = ($new_g > 255)? 255 : (($new_g < 0)? 0:$new_g);
				$new_b = ($new_b > 255)? 255 : (($new_b < 0)? 0:$new_b);
				$new_a = ($new_a > 127)? 127 : (($new_a < 0)? 0:$new_a);
	 
				$new_pxl = ImageColorAllocateAlpha($src, (int)$new_r, (int)$new_g, (int)$new_b, $new_a);
				if ($new_pxl == -1) {
					$new_pxl = ImageColorClosestAlpha($src, (int)$new_r, (int)$new_g, (int)$new_b, $new_a);
				}
				if (($y >= 0) && ($y < $sy)) {
					imagesetpixel($src, $x, $y, $new_pxl);
				}
			}
		}
	
		imagedestroy($srcback);
		return 1;
	}
	
}

function round_image($source, $destination)
{
	$size = getimagesize($source);
	
	$width = $size[0];
	$height = $size[1];
	
	switch ($size[2])
	{
		case IMAGETYPE_JPEG: $source = imagecreatefromjpeg($source); break;
		case IMAGETYPE_GIF : $source = imagecreatefromgif($source); break;
		case IMAGETYPE_PNG : $source = imagecreatefrompng($source); break;
		default:
			return false; // not supported image format
	}
	
	// Turn off alpha blending and set alpha flag
	imagealphablending($source, false);
	imagesavealpha($source, true);
	
	$transparent = imagecolorallocatealpha($source, 255, 255, 255, 127);
	
	// to work with the array of pixel
	$width--;
	$height--;
	
	// corner - top left
	imagesetpixel($source, 0, 0, $transparent);
	imagesetpixel($source, 1, 0, $transparent);
	imagesetpixel($source, 0, 1, $transparent);
	
	// corner - top right
	imagesetpixel($source, $width, 0, $transparent);
	imagesetpixel($source, $width-1, 0, $transparent);
	imagesetpixel($source, $width, 1, $transparent);
	
	// corner - top right
	imagesetpixel($source, $width, $height, $transparent);
	imagesetpixel($source, $width-1, $height, $transparent);
	imagesetpixel($source, $width, $height-1, $transparent);
	
	// corner - bottom left
	imagesetpixel($source, 0, $height, $transparent);
	imagesetpixel($source, 1, $height, $transparent);
	imagesetpixel($source, 0, $height-1, $transparent);
	
	// array of position for the 60% alpha
	$arr = array(
		array(2       , 0),
		array($width-2, 0),
		array(0       , 2),
		array($width  , 2),
		array(0       , $height-2),
		array($width  , $height-2),
		array(2       , $height),
		array($width-2, $height)
	);
	
	foreach ($arr as $pos) {
		$color = imagecolorat($source, $pos[0], $pos[1]);
		$color = imagecolorsforindex($source, $color);
		$transparent = imagecolorallocatealpha($source, $color['red'],  $color['green'],  $color['blue'], 50);
		
		imagesetpixel($source, $pos[0], $pos[1], $transparent);
	}

	$return = imagepng($source, $destination);
	
	imagedestroy($source);
	
	return $return;
}
/*
function rough_round_image($source, $destination, $corner=5)
{
	$size = getimagesize($source);
	
	$width = $size[0];
	$height = $size[1];
	
	switch ($size[2])
	{
		case IMAGETYPE_JPEG: $source = imagecreatefromjpeg($source); break;
		case IMAGETYPE_GIF : $source = imagecreatefromgif($source); break;
		case IMAGETYPE_PNG : $source = imagecreatefrompng($source); break;
		default:
			return false; // not supported image format
	}
	
	
	// do the transparent rounded corner
	$found = false;
	$palette = imagecreatetruecolor($width, $height); 
	while ($found == false) {
		
		$r = rand(0, 255);
		$g = rand(0, 255);
		$b = rand(0, 255);
		
		if (imagecolorexact($source, $r, $g, $b) != (-1)) {
			$color = imagecolorallocate($palette, $r, $g, $b);
			$found = true;
		}
	}

	//draw corners
	imagearc($source, $corner-1, $corner-1, $corner*2, $corner*2, 180, 270, $color);
	imagefilltoborder($source, 0, 0, $color, $color);

	imagearc($source, $width-$corner, $corner-1, $corner*2, $corner*2, 270, 0, $color);
	imagefilltoborder($source, $width, 0, $color, $color);

	imagearc($source, $corner-1, $height-$corner, $corner*2, $corner*2, 90, 180, $color);
	imagefilltoborder($source, 0, $height, $color, $color);

	imagearc($source, $width-$corner, $height-$corner, $corner*2, $corner*2, 0, 90, $color);
	imagefilltoborder($source, $height, $height, $color, $color);

	imagecolortransparent($source, $color); //make corners transparent

	$return = imagepng($source, $destination);
	
	imagedestroy($source);
	
	return $return;
}*/