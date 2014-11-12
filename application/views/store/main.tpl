<!DOCTYPE html> 
<html> 
<head>
	<meta charset="utf-8" />
	<title>Склад</title>
    <meta http-equiv="content-language" content="bg" />
	<meta name="author" content="Ivan Ivanov Georgiev" /> 
	<meta name="copyright" content="Targovishte Team" />
    
    <link rel="icon" type="image/gif" href="{$base_url}interface/favicon.jpg" />
    <link rel="stylesheet" type="text/css" href="{$base_url}css/global.css" />
    <link rel="stylesheet" type="text/css" href="{$base_url}css/store.css" />
	<script type="text/javascript" src="{$base_url}js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="{$base_url}js/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
	<script type="text/javascript" src="{$base_url}js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="{$base_url}js/store.js"></script>
    <script>var base_url = '{$base_url}';</script>
	{block name=js}{/block}
</head>
<body>
    <header id="top">
        <div class="container_12 clearfix">
            <div id="logo" class="grid_5">
                <h1><a href="{$base_url}store/">Маркет</a>
                    <span>Склад</span>
                </h1>
            </div>
            <div id="colorstyle" class="grid_4">
                {if $staff && $staff->type != 'club'}<span>Current balance: <strong>$ {$current_balance|number_format:2}</strong></span>{/if}
            </div>
            <div id="userinfo" class="grid_3">
                Добре дошли, 
                <a href="#">
                    <img src="{$base_url}interface/user-silhouette.png" />
                    {if $staff}{$staff->name}{else}{$interface.guest}{/if}
                </a>
            </div>
        </div>
    </header>
    <nav id="topmenu">
        <div class="container_12 clearfix">
            <div class="grid_12">
                {include file="store/top_menu.tpl"}
            </div>
        </div>
    </nav>
                
    <section id="content">
        {block name=body}{/block}
        <div id="loading"><img src="{$base_url}interface/loading.gif" alt="Loading" /></div>
    </section>
	
    <footer id="bottom">
        <section class="container_12 clearfix">
            <div class="grid_6"></div>
            <div class="grid_6 alignright">
                Copyrights © {$smarty.now|date_format:"Y"} Targovishte Team : Developed by Ivan Georgiev | All rights reserved<br/>
                Contact information: <a href="mailto:admin@targovishte.com">
                admin@targovishte.com</a>.
            </div>
        </section>
    </footer>
</body>
</html>