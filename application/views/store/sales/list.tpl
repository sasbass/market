{extends file='store/main.tpl'}
{block name=js}
<link rel="stylesheet" href="{$base_url}css/jquery-ui.css">
<script src="{$base_url}js/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
    $("#checked").click(function(){
        if($(this).is(":checked")){
            $('input.check').prop( "checked", true );
        } else {
            $('input.check').prop( "checked", false );
        }
    });
    
	$(".datepicker").datetimepicker({
		//monthNames: ['Януари','Февруари','Март','Април','Май','Юни','Юли','Август','Септември','Октомври','Ноември','Декември'],
		monthNamesShort: ['Ян','Фев','Март','Апр','Май','Юни','Юли','Авг','Сеп','Окт','Ное','Дек'],
		dayNamesMin: ['Не','По','Вт','Ср','Че','Пе','Съ'],
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '{$first_year}:{$smarty.now|date_format:"%Y"}',
		timeFormat: 'HH:mm:ss',
		stepHour: 2,
		stepMinute: 10,
		stepSecond: 10,
		currentText: "Текущо",
		closeText: "ОК",
		timeText: "Време",
		hourText: "Час",
		minuteText: "Минути",
		secondText: "Секунди",
        firstDay: 1
	});
});

</script>
{/block}
{block name=body}	
    
<section class="container_12 claerfix">
<aside id="sidebar" class="grid_12">
    <div class="box">
        <h2>Списък покупки</h2>
        
        {include file="store/menu.tpl"}
        <form action="{$base_url}store/sales/" method="post">
        <div class="grid_8" style="width:72%;">
            <div class="grid_3 green-line-right">
                    <p>Филтрирайте покупките за определен период</p>
                    <label>от</label>
                    <input name="date[from]" value="{$date_from}" type="text" class="in datepicker"/><br/><br/>

                    <label>до</label>
                    <input name="date[to]" value="{$date_to}" type="text" class="in datepicker"/><br/><br/>

                    <input name="go" value="ФИЛТРИРАЙ" type="submit" class="button small"/><br/>
                    
                    
                
            </div>
            <div class="grid_3 green-line-right">
                <p>Създайте фактура от избраните от вас покупки</p>
                <label for="company">Изберете фирма</label>
                <select name="company_id" id="company">
                    <option value="ch">-- Частно лице --</option>
                    <option value="0">-- Нова фирма --</option>
                    {foreach from=$campanies item=item}
                        <option value="{$item->id}">{$item->name}</option>
                    {/foreach}
                </select>
                <input name="invoice" value="Създай фактура" type="submit" class="button"/><br/>
            </div>
            <div class="grid_2" style="float:right; width: 25%;">
                <h2>Данни за периода</h2>
                <table cellspacing="0" cellpadding="4" class="std" style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>Различни продукти:</td>
                            <td><strong>{$total.unic_count_product}</strong> бр.</td>
                        </tr>
                        <tr>
                            <td>Общо продукти:</td>
                            <td><strong>{$total.data->count_product}</strong> бр.</td>
                        </tr>
                         <tr>
                            <td>Оборот:</td>
                            <td><strong>{$total.data->total}</strong> лв.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
        <dvi class="clear"></dvi><br/>

        {if $list}
            {*<form action="{$base_url}store/sales/" method="post">
                <fieldset>
                    <label for="search">Търси</label>
                    <input id="search" name="search[result]" value="" type="text" class="in short"/>
                    <input name="search[go]" value="Търси" type="submit" class="bt"/>
                </fieldset>
            </form>*}
            <table cellpadding="4" cellspacing="0" border="0" class="tbl" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Арт.&#x2116;</th>
                        <th>Баркод &#x2116;</th>
                        <th>Артикул</th>
                        <th>Кол.</th>
                        <th>Стойност</th>
                        <th>
                            <input name="checkbox" type="checkbox" id="checked"/>
                        </th>
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
                        <td style="width: 11%;">{$item->quantity}</td>
                        <td>{$item->market_price} лв.</td>
                        <td>
                            <input {if $check == $item->sid}checked="checked"{/if} class="check" name="check[]" value="{$item->sid}" type="checkbox"/>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
            {else}
            <h4>Списъка с артикули е празен!</h4>
            {/if}
        </div>
    </form>
    <div class="clear"></div>
    </div>
</aside>
</section>
        
<div id="dialog-message" title="" class="hidden"></div>
            
{include file="common/message_dialog.tpl"}
{/block}