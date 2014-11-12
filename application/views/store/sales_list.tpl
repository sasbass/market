{extends file='store/main.tpl'}
{block name=js}
<script type="text/javascript">
$(document).ready(function(){
	$(".datepicker").datepicker({
		//monthNames: ['Януари','Февруари','Март','Април','Май','Юни','Юли','Август','Септември','Октомври','Ноември','Декември'],
		monthNamesShort: ['Ян','Фев','Март','Апр','Май','Юни','Юли','Авг','Сеп','Окт','Ное','Дек'],
		dayNamesMin: ['Не','По','Вт','Ср','Че','Пе','Съ'],
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '{$first_year}:{$smarty.now|date_format:"%Y"}'
	});
});
</script>
{/block}
{block name=body}	
{include file="store/menu.tpl"}
<div class="grid_9">
<div class="grid_5">
<form action="" method="post">
<fieldset>
	<p>Филтрирайте покупките за определен период</p>
	<label>от</label>
	<input name="from" value="" type="text" class="in short datepicker"/>
	
	<label>до</label>
	<input name="to" value="" type="text" class="in short datepicker"/>
	
	<input name="go" value="ФИЛТРИРАЙ" type="submit" class="bt"/>
</fieldset>
</form>
</div>

<div class="grid_3">
<p style="text-align: right;">Оборот: <strong>{$total->total}</strong> лв.</p>
</div>
<dvi class="clear"></dvi>

{if $list}
	<h2>Списък покупки</h2>
	<table cellpadding="4" cellspacing="0" border="0" class="tbl">
		<thead>
			<tr>
				<td>Арт.&#x2116;</td>
				<td>Баркод &#x2116;</td>
				<th>Артикул</th>
				<th>Кол.</th>
				<th>Стойност</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$list item=item}
			<tr>
				<td style="width: 12%;">
				{$item->id}
				<input name="id[]" value="{$item->id}" type="hidden"/>
				</td>
				<td style="width: 29%;">{$item->barcode}</td>
				<td style="width: 25%;">{$item->name}</td>
				<td style="width: 11%;">{$item->amount}</td>
				<td>{$item->market_price} лв.</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
	{else}
	<h4>Списъка с артикули е празен!</h4>
	{/if}
</div>
{/block}