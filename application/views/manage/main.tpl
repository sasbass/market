<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Администриране</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="{$lang|default:'bg'}" />
	<meta name="robots" content="index, follow, all" />
	<meta name="revisit-after" content="1 hour" />
	<meta name="keywords" content="{$page.keywords}" />
	<meta name="description" content="{$page.description}" />
	<meta http-equiv="Cache-control" content="public" />
	<meta name="author" content="Ivan Ivanov Georgiev" /> 
	<meta name="copyright" content="AvantX Technology Alliance" />
	<meta name="distribution" content="global" />
	<meta name="rating" content="general" />
    <link rel="icon" type="image/gif" href="{$base_url}interface/favicon.jpg" />
    <link rel="stylesheet" type="text/css" href="{$base_url}css/global.css" />
	<script type="text/javascript" src="{$base_url}js/jquery-ui-1.10.3/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="{$base_url}js/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
	<script type="text/javascript" src="{$base_url}js/manage.js"></script>
</head>
<body>
	<div id="header">{block name=header}{/block}</div>
	<div class="container_12">{block name=body}{/block}</div>
	<div id="footer">{block name=footer}{/block}</div>
</body>
</html>