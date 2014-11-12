{if $message}
<div class="{$message->type}_message">
	{if $message->title}<h2>{$message->title}</h2>{/if}
	{if $message->body}<p>{$message->body}</p>{/if}
	{if $message->redirect>0}
	<p class="redirect">
		(ще бъдете прехвърлени след) {$message->redirect/1000|round} (секунди.)
		<script type="text/javascript">
			setTimeout("location.href='{if $message->url}{$message->url}{else}/{/if}';", {$message->redirect});
		</script>
	</p>
	{/if}
</div>
{/if}