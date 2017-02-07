<?php
if(!session_id())
	session_start();


$file_formats = array("jpg", "jpeg", "png", "gif", "bmp");

if (isset($_POST['upload_type']) && $_POST['upload_type'] == 'cover')
{
	$filepath = dirname(__FILE__) . "/images/covers/";
	$prefix = 'cover_';
}
elseif (isset($_POST['upload_type']) && $_POST['upload_type'] == 'portfolio')
{
	$filepath = dirname(__FILE__) . "/images/rentuser/portfolio/";
	$prefix = 'portfolio_';
}
elseif (isset($_POST['upload_type']) && $_POST['upload_type'] == 'space')
{
	$filepath = dirname(__FILE__) . "/images/space/tmp/";
	$prefix = 'space_';
}
elseif (isset($_POST['upload_type']) && $_POST['upload_type'] == 'logo')
{
	$filepath = dirname(__FILE__) . "/images/user/";
	$prefix = 'logo_';
}
else
{
	$filepath = dirname(__FILE__) . "/images/avatars/tmp/";
	$prefix = 'avatar_';
}
$preview_width = "400";
$preview_height = "300";


if ($_POST['submitbtn']=="Upload") {

	if (!file_exists($filepath))
	{
		mkdir($filepath, 0777);
	}
	
 if ($_POST['imagefile_input'])
 {
 	//Edit exiting picture
 	$filename = basename($_POST['imagefile_input']);
 	copy($_POST['imagefile_input'], $filepath . $filename);
 	exit($filename);
 }
 
 $name = $_FILES['imagefile']['name']; // filename to get file's extension
 $size = $_FILES['imagefile']['size'];

 if (strlen($name)) {
 	$extension = substr($name, strrpos($name, '.')+1);
 	if (in_array(strtolower($extension), $file_formats)) { // check it if it's a valid format or not
 		if ($size < (4096 * 1024)) { // check it if it's bigger than 2 mb or no
 			//@TODO change this to avatar user id
 			$oriPrefix = $prefix;
 			$prefix .= isset($_POST['image-id']) ? ($_POST['image-id'] .'_') : '';
 			$imagename = $prefix . uniqid() . "." . $extension;
 			$tmp = $_FILES['imagefile']['tmp_name'];
 				if (move_uploaded_file($tmp, $filepath . $imagename)) {
 					if ($prefix == 'cover')
 					{
 						//@TODO remove this when go live
 						$_SESSION['cover_image'] = $imagename;
 					}
 					
 					// Return imagename as object with width/height
 					if (in_array($oriPrefix, array('avatar_', 'space_', 'logo_')))
 					{
 						$imageSize = getimagesize($filepath . $imagename);
 						$imagename = json_encode(array('name' => $imagename, 'size' => $imageSize));
 					}
 						
					echo $imagename;
 				} else {
 					echo "Could not move the file";
 				}
 		} else {
 			echo "Your image size is bigger than 4MB";
 		}
 	} else {
 			echo "Invalid file format";
 	}
 } else {
 	echo "Please select image!";
 }
 exit();
}
 
?>