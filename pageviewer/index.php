<?php
define(base,realpath(dirname(__FILE__)));

require_once('includes/constants.php');
require_once('includes/helper.php');
require_once('app/model.php');
require_once('app/controller.php');
require_once('app/view.php');

$PageViewer=new PageViewer();
$PageViewerController=new PageViewerController($PageViewer);
if (isset($_GET['action'])) 
{
	$PageViewerController->{$_GET['action']}();
}
$PageViewerView=new PageViewerView($PageViewer);

echo $PageViewerView->output;
?>