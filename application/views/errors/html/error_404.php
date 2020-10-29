<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="<?=SITE_URL?>assets/css/style.css">
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">
	body{
		height:100%;
		width:100%;
		overflow:hidden !important;
	}
	.backgroud_404 {
		position:absolute;
		height:100%;
		width:100%;
		
	}
	.backgroud_404:after {
		height:100%;
		width:100%;
		background-color:rgba(255, 255 , 255, 0.5);
		content:'';
		top:0px;;
		left:0px;
		position:absolute;
	}
	.backgroud_404 h1 {
		font-family: "Open Sans Extrabold";
		font-size:520px;
		color:#aaaaaa;
		text-align:center;
		height:400px;
		top:50%;
		line-height:370px;
		position:relative;
		transform:translateY(-50%);
		margin:0px;
	}
	.content_404 {
		height:100%;
		width:100%;
		position:absolute;
		z-index:1;
		overflow:hidden;
	}
	.content_404 p {
		font-family: "Open Sans Semibold";
		font-size:16px;
		color:#222222;
		text-align:center;
		top:50%;
		position:relative;
		transform:translateY(-50%);
		margin:0px;
	}
	.content_404 p a {
		color:#a5ce37;
		font-family: "Open Sans Extrabold";
	}
</style>
</head>
<body>
	<div id="container">
		<div class="backgroud_404"><h1>404</h1></div>
        <div class="content_404"><p>The page you are looking for is either missing or does not exist<br>
<a href="<?=SITE_URL?>">Go Back</a>, or head over to <a href="<?=SITE_URL?>"><?=SITE_URL?></a> to choose a new direction</p></div>
	</div>
</body>
</html>