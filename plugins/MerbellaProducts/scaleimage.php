<?
$height=$_GET['height'];
$width=$_GET['width'];
$imagefilename = base64_decode($_GET['image']);
$size = getimagesize($imagefilename);
$aspectratio = $size[0]/$size[1];
//print_r($size);
//echo $imagefilename;
if (($height=="")&&($width=="")){
	// No Height or Width given, returning image at original Size
	header('Content-Type: '.$size['mime']);
	readfile ($imagefilename);
}
switch ( $size[2] ) {
      case IMAGETYPE_GIF:
//	echo "gif";
        $source = imagecreatefromgif($imagefilename);
      break;
      case IMAGETYPE_JPEG:
//	echo "jpg";
        $source = imagecreatefromjpeg($imagefilename);
      break;
      case IMAGETYPE_PNG:
//	echo "png";
        $source = imagecreatefrompng($imagefilename);
      break;
      default:
        return false;
}
//exit;	
if ((($height=="")&&($width<>""))||(($height<>"")&&($width==""))){
	header('Content-Type: image/png');
	if ($height==""){
		$newheight = $width/$aspectratio;
		$newwidth=$width;
	}else{
		$newheight=$height;
		$newwidth=$height*$aspectratio;
	}
	if ($size[2] == IMAGETYPE_PNG) {
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		imagealphablending($thumb, false);
		imagesavealpha($thumb,true);
		$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
		imagefilledrectangle($thumb, 0, 0, $newwidth, $newheight, $transparent);
	}else {
		$thumb = imagecreatetruecolor($newwidth, $newheight);
	}
	imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $size[0], $size[1]);
	imagepng($thumb);
	//Only one dimension given.  Scaling and maintaining aspect ratio
}
if (($height<>"")&&($width<>"")){
	//Both height and width given.  Scaling and Cropping to desired size)
	header('Content-Type: image/png');
	$newheight=$height;
	$newwidth=$height*$aspectratio;
	if ($size[2] == IMAGETYPE_PNG) {
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		imagealphablending($thumb, false);
		imagesavealpha($thumb,true);
		$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
		imagefilledrectangle($thumb, 0, 0, $newwidth, $newheight, $transparent);
	}else {
		$thumb = imagecreatetruecolor($newwidth, $newheight);
	}
	imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $size[0], $size[1]);
	//$Thumb is now our scaled image.  Now we need to crop it.  Cropping should be done from the center line
	$XmiddleOfImage = floor($newwidth/2);
	$YmiddleOfImage = floor($newheight/2);
	$XStartCropPoint = $XmiddleOfImage-($width/2);
	$XStopCropPoint = $XmiddleOfImage+($width/2);
	$YStartCropPoint = $YmiddleOfImage-($height/2);
	$YStopCropPoint = $YmiddleOfImage+($height/2);
	if ($size[2] == IMAGETYPE_PNG) {
		$thumb2 = imagecreatetruecolor($width, $height);
		imagealphablending($thumb2, false);
		imagesavealpha($thumb2,true);
		$transparent = imagecolorallocatealpha($thumb2, 255, 255, 255, 127);
		imagefilledrectangle($thumb2, 0, 0, $width, $height, $transparent);
	}else {
		$thumb2 = imagecreatetruecolor($width, $height);
	}

	imagecopy($thumb2, $thumb, 0, 0, $XStartCropPoint, $YStartCropPoint, $newwidth, $newheight);
	
imagepng($thumb2);
}
