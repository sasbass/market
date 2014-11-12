{extends file='store/main.tpl'}

{block name=body}	
    
<section class="container_12 claerfix">
<aside id="sidebar" class="grid_12">
    <div class="box">
        <h2>Профил на Касиера</h2>
        {include file="common/message.tpl"}
        <form action="{$base_url}store/users/" method="post">
            <div class="grid_4">
                <label>Име</label>
                <input name="data[first_name]" value="{$edit.first_name}" type="text" class="in"/>

                <label>Фамилия</label>
                <input name="data[last_name]" value="{$edit.last_name}" type="text" class="in"/>
            </div>
            
            <div class="grid_4">
                <label>Потребител</label>
                <input name="data[username]" value="{$edit.username}" type="text" class="in"/>

                <label>Парола</label>
                <input name="data[password]" value="" type="password" class="in"/>
            </div>
            <div class="clear"></div>
            <div class="grid_4">
                <input name="save" value="Запази промените" type="submit" class="button"/>
            </div>
        
        </form>
    <div class="clear"></div>
    </div>
</aside>
</section>
{/block}