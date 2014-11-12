<div class="grid_3">
<ul id="menu">
{foreach from=$menu item=item}
	<li>
		<a href="{$base_url}{$item.name}">
		<img width="12ppx" height="12px" alt="icon" src="{$base_url}interface/{$item.icon}"/>
		{$item.title}
		</a>
	{if $item.sub_menu}
	<ul>
		{foreach from=$item.sub_menu item=sub}
			<li>
			<a href="{$base_url}{$sub.name}">
			<img width="10ppx" height="10px" alt="icon" src="{$base_url}interface/{$sub.icon}"/>
			{$sub.title}
			</a>
		{/foreach}
	</ul>
	{/if}
	</li>
{/foreach}
</ul>
</div>