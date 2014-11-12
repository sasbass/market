<!DOCTYPE html> 
<html> 
<head>
	<meta charset="utf-8" />
    <title>Продажби</title>
	<meta http-equiv="content-language" content="{$lang|default:'bg'}" />
    
	<meta name="author" content="Ivan Ivanov Georgiev" /> 
	<meta name="copyright" content="Targovishte.com Team" />
    <link rel="icon" type="image/gif" href="{$base_url}interface/favicon.jpg" />
    <link rel="stylesheet" type="text/css" href="{$base_url}css/global.css" />
    <link rel="stylesheet" type="text/css" href="{$base_url}css/sales.css" />
	<script type="text/javascript" src="{$base_url}js/jquery-ui-1.10.3/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="{$base_url}js/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
	<script type="text/javascript" src="{$base_url}js/sales.js"></script>
	{block name=head}{/block}
</head>
<body>
	<div class="container_12 {if $isLogin}content{/if}">
	<div id="header">{block name=header}{/block}</div>
	{block name=body}{/block}
	<div id="footer">{block name=footer}{/block}</div>
	</div>
</body>
</html>