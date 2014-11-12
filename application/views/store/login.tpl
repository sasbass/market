{extends file="store/main.tpl"}
{block name='js'}
    <script>animateMessage(3500);</script>
{/block}
{block name=body}
    <section class="container_12 claerfix">
        <section class="grid_4 push_4" id="login">
            <div class="box">
                <h2><img src="{$base_url}interface/login.png" width="24px">ВХОД СКЛАД</h2>
                <form action="{$base_url}store/index/login/" method="post">
                    <input pattern="[a-zA-Z0-9]+" placeholder="Потребител" tabindex="1" type="text" name="store" id="store" value="" class="in"  autofocus required/>
                    <input placeholder="Парола" tabindex="2" type="password" name="password" id="password" class="in" required/> 
                    <div class="clear"></div>
                    <input tabindex="3" type="submit" name="login" value="ВХОД" class="button small"/>
                    {include file="common/message.tpl"}
                </form>
            </div>
        </section>
    </section>
{/block}