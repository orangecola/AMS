<?php 
include_once('config.php');
echo 'parent';
$user->getParents($user->getSoftware(1668)[1]);

echo 'child';
$user->getChildren($user->getSoftware(1666)[1]);
?>