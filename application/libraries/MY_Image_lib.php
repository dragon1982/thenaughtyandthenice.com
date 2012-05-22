<?php
Class MY_Image_lib extends CI_Image_lib{
	
	
	/**
	 * Sterge ce nu e in dimensiuni
	 * @param $src
	 * @param $dst
	 * @param $dstx
	 * @param $dsty
	 * @return unknown_type
	 */
	function crop_delete()
	{
		$src = $this->source_image;
		$dst = $this->source_image;
		$dstx = $this->width;
		$dsty = $this->height;
		
		// $src = original image location
		// $dst = destination image location
		// $dstx = user defined width of image
		// $dsty = user defined height of image
		$allowedExtensions = 'jpg jpeg gif png';
	
		$name = explode(".", $src);
		$currentExtensions = strtolower($name[count($name)-1]);
		$extensions = explode(" ", $allowedExtensions);
		
		$extensionOK = FALSE;
		
		for($i = 0; count($extensions) > $i; $i = $i + 1) {
			if ($extensions[$i] == $currentExtensions) {
				$extensionOK = 1;
				$fileExtension = $extensions[$i];
				break;
			}
		}
	
		if ($extensionOK) {
			$size = getImageSize($this->source_folder . $src);
			$width = $size[0];
			$height = $size[1];
	
			if ($width >= $dstx AND $height >= $dsty) {
				$proportion_X = $width / $dstx;
				$proportion_Y = $height / $dsty;
	
				if ($proportion_X > $proportion_Y) {
					$proportion = $proportion_Y;
				} else {
					$proportion = $proportion_X ;
				}
				$target['width'] = $dstx * $proportion;
				$target['height'] = $dsty * $proportion;
	
				$original['diagonal_center'] =
				round(sqrt(($width * $width) + ($height * $height)) / 2);
				$target['diagonal_center'] =
				round(sqrt(($target['width'] * $target['width']) +
				($target['height'] * $target['height'])) / 2);
	
				$crop = round($original['diagonal_center'] - $target['diagonal_center']);
	
				if ($proportion_X < $proportion_Y) {
					$target['x'] = 0;
					$target['y'] = round((($height / 2) * $crop) / $target['diagonal_center']);
				} else {
					$target['x'] = round((($width / 2) * $crop) / $target['diagonal_center']);
					$target['y'] = 0;
				}
	
				if ($fileExtension == "jpg" OR $fileExtension == 'jpeg') {
					$from = @imagecreatefromjpeg($this->source_folder . $src);
				} elseif ($fileExtension == "gif") {
					$from = @ImageCreateFromGIF($this->source_folder . $src);
				} elseif ($fileExtension == 'png') {
					$from = @imageCreateFromPNG($this->source_folder . $src);
				}
				
	
				$new = ImageCreateTrueColor ($dstx, $dsty);
	
				imagecopyresampled ($new, $from, 0, 0, $target['x'],
				$target['y'], $dstx, $dsty, $target['width'], $target['height']);
	
				if ($fileExtension == "jpg" OR $fileExtension == 'jpeg') {
					return imagejpeg($new, $this->source_folder . $dst, 70);
				} elseif ($fileExtension == "gif") {
					return imagegif($new, $this->source_folder . $dst);
				} elseif ($fileExtension == 'png') {
					return imagepng($new, $this->source_folder . $dst);
				}
			}
	
		} else {
			@unlink($src);
		}
	}
	
}