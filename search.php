<?php
	require_once(__DIR__."/includes/session.php");
	require_once(__DIR__."/includes/connection.php"); 
	require_once(__DIR__."/includes/functions.php");
	require_once(__DIR__."/includes/constants.php");

?>

<?php

if (isset($_REQUEST['query'])) {

if(isset($_GET['chid']))

echo searchTest($_REQUEST['query'],$_GET['chid']);

}

?>