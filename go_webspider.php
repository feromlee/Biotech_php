<?php
ignore_user_abort();
$cmd="C:\Webspider\webspider.exe";
execInBackground($cmd);

function execInBackground($cmd) {

if (substr(php_uname(), 0, 7) == "Windows"){

pclose(popen("start /B ". $cmd, "r"));

}

else { //linux

exec($cmd . " > /dev/null &");

}

}

?>
