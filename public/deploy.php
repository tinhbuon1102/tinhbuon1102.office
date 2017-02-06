<?php

$ret = exec('/home/coreworking/opt/bin/git push origin master;', $out, $err);
if ($err) {
	echo ('Error : <br />');
	echo '<pre>'; 
	print($err);
	print_r($out);die;
}
else {
	echo '<pre>'; 
	print_r($out);die;
}

?>