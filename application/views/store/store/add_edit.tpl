{extends file='store/main.tpl'}
{block name=js}
    <script>
       $(document).ready(function(){
            $("#store").on('submit',function(event){
                if(!$("#quality_in").val()) {
                    event.preventDefault();
                }
                
                $("#quality_in").focus();
            });
       });
    </script>
{/block}
{block name=body}	
<section class="container_12 claerfix">
<aside id="sidebar" class="grid_12">
    <div class="box">
        <h2>Приемане на стока</h2>
        
        {include file="store/menu.tpl"}
        <div class="grid_8" style="width:72%;">
            <form id="store" action="{$base_url}store/index/{$action}/" method="post">
                <fieldset>
                {include file="common/message.tpl"}
                    
                    <button formaction="{$base_url}store/campanies/add/" class="button small">Добави нова фирма</button>
                    <br/><br/>
                    <label for="campanies_id">Фирма снабдител <strong><em>*</em></strong></label>
                    <select name="campanies_id" id="campanies_id">
                        <option value="">-- Изберете фирма --</option>
                        {foreach from=$campanies item=item}
                        <option value="{$item->id}" {if $item->id == $edit->campanies_id}selected="selected"{/if} >{$item->name}</option>
                        {/foreach}
                    </select>
                    
                    <label for="name">Име на артикул <strong><em>*</em></strong></label>
                    <input id="name" name="name" value="{$edit->name}" type="text" class="in"/><br/>

                    <label for="barcode">Баркод на артикул <strong><em>*</em></strong></label>
                    <input id="barcode" name="barcode" value="{$edit->barcode}" type="text" class="in"/><br/>
                     <br/>
                    
                    <label for="quality_in">{if $uri == 'edit'}Общо прието количество до момента{else}Количество <strong><em>*</em></strong>{/if}</label>
                    
                    <input {if $uri == 'edit'} disabled="disabled"{/if} id="quality_in" name="quality_in" value="{$edit->quality_in}" type="text" class="in"/><br/>
                    
                {if $uri == 'edit'}
                    
                    <label>Наличност в склада</label>
                    <input  {if $uri == 'edit'} disabled="disabled"{/if} id="quality_in" value="{$edit->quantity_current}" type="text" class="in"/><br/>
                    
                    <label for="quantity_current">Ново количество <strong><em>*</em></strong></label>
                    <input id="quantity_current" name="quantity_current" value="" type="text" class="in"/><br/>
                {/if}
                <br/>
                    <label for="delivery_price">Доставна цена <strong><em>*</em></strong></label>
                    <input id="delivery_price" name="delivery_price" value="{$edit->delivery_price}" type="text" class="in"/><br/>

                    <label for="market_price">Цена в обекта <strong><em>*</em></strong></label>
                    <input id="market_price" name="market_price" value="{$edit->market_price}" type="text" class="in"/><br/>

                    <label for="description">Допълнително описание</label><br/>
                    <textarea id="description" rows="10" cols="50" name="description">{$edit->description}</textarea><br/>

                   {* <input name="invoice[one]" value="1" type="checkbox"/>
                    <label>Желая да се създаде единична фактура за тази стока.</label>*}
                    <br/>

                    <br/>
                    <input name="add" value="{if $action == 'add'}ДОБАВИ АРТИКУЛ{else}ЗАПАЗИ ПРОМЕНИТЕ{/if}" type="submit" class="button small"/>
                </fieldset>
            </form>
        </div>
    <div class="clear"></div>
    </div>
</aside>
</section>
{/block}