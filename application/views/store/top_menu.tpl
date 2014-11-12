{if $isLogin}
<ul id="mainmenu">
    <li><a href="{$base_url}store/index/" {if $page == ''}class="current"{/if}>Начало</a></li>
    <li><a href="{$base_url}store/settings/" {if $page == 'settings'}class="current"{/if}>Настройики</a></li>
    <li><a href="{$base_url}store/users/" {if $page == 'users'}class="current"{/if}>Профил</a></li>
</ul>
<ul id="usermenu">
    <li><a href="{$base_url}store/index/logout/">Изход</a></li>
</ul>
{/if}