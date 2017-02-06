<?php

$ret = exec('/home/coreworking/opt/bin/git reset --hard HEAD;', $out, $err);
$ret = exec('/home/coreworking/opt/bin/git add -u ../;', $out, $err);
$ret = exec('/home/coreworking/opt/bin/git commit -m "Upload files";', $out, $err);
$ret = exec(' /home/coreworking/opt/bin/git push origin master;', $out, $err);
if ($err) {
	echo ('Error : <br />');
	echo '<pre>'; 
	print($err);
}
else {
	echo '<pre>'; 
	print_r($out);die;
}

?>