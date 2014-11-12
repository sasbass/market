{extends file='store/main.tpl'}
{block name=body}	
{include file="store/menu.tpl"}
<div class="grid_9">
<h2>Приемане на стока</h2>
<form action="{$base_url}store/index/{$action}/" method="post">
	<fieldset>
	{include file="common/message.tpl"}
		<label for="campanies_id">Фирма снабдител <strong><em>*</em></strong></label>
		<select name="campanies_id" id="campanies_id">
			<option value="">-- Изберете фирма --</option>
			{foreach from=$campanies item=item}
			<option value="{$item->id}" {if $item->id == $edit->campanies_id}selected="selected"{/if} >{$item->name}</option>
			{/foreach}
		</select>
		<button formaction="{$base_url}store/campanies/add/">Добави нова фирма</button>
		<br/>
		
		<label for="name">Име на артикул <strong><em>*</em></strong></label>
		<input id="name" name="name" value="{$edit->name}" type="text" class="in"/><br/>
	
		<label for="barcode">Баркод на артикул <strong><em>*</em></strong></label>
		<input id="barcode" name="barcode" value="{$edit->barcode}" type="text" class="in"/><br/>
		
		<label for="quality_in">Количество <strong><em>*</em></strong></label>
		<input id="quality_in" name="quality_in" value="{$edit->quality_in}" type="text" class="in"/><br/>
		
		<label for="delivery_price">Доставна цена <strong><em>*</em></strong></label>
		<input id="delivery_price" name="delivery_price" value="{$edit->delivery_price}" type="text" class="in"/><br/>
		
		<label for="market_price">Цена в обекта <strong><em>*</em></strong></label>
		<input id="market_price" name="market_price" value="{$edit->market_price}" type="text" class="in"/><br/>
		
		<label for="description">Допълнително описание</label><br/>
		<textarea id="description" rows="10" cols="50" name="description">{$edit->description}</textarea><br/>
	
		<input name="add" value="{if $action == 'add'}ДОБАВИ АРТИКУЛ{else}ЗАПАЗИ ПРОМЕНИТЕ{/if}" type="submit" class="bt"/>
	</fieldset>
</form>
</div>
{/block}