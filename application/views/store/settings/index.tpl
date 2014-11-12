{extends file='store/main.tpl'}

{block name=body}	
    
<section class="container_12 claerfix">
<aside id="sidebar" class="grid_12">
    <div class="box">
        <h2>Настройки</h2>
        
        <form action="{$base_url}store/settings/save/" method="post">
       
            {foreach from=$settings item=item}
                <div class="grid_4">
                <label for="{$item->name}">{$item->label}</label>
                <input id="{$item->name}" name="var[{$item->name}]" value="{$item->value}" type="{$item->type}" class="in"/>
                </div>
            {/foreach}
            <br/>
            
            <hr/>
            <div class="grid_4">
            <input name="save" value="Запази промените" type="submit" class="button"/>
            </div>
            <div class="clear"></div><br/>
        </form>
    <div class="clear"></div>
    </div>
</aside>
</section>
{/block}