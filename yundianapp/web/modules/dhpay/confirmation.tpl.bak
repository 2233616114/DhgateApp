{if $status == 'ok'}
	<p>{l s='Your order on' mod='dhpay'} <span class="bold">{$shop_name}</span> {l s='is complete.' mod='dhpay'}
		<br /><br />
		{l s='You have chosen the Alipay method.' mod='alipay'}
		<br /><br />{l s='Thank you for your purchase!' mod='dhpay'}</span>
		<br /><br /><span class="bold">{l s='Your order will be sent very soon.' mod='dhpay'}</span>
		<br /><br />{l s='For any questions or for further information, please contact our' mod='dhpay'} <a href="{$link->getPageLink('contact-form.php', true)}">{l s='customer support' mod='dhpay'}</a>.
	</p>
{else}
	<p class="warning">
		{l s='We noticed a problem with your order. If you think this is an error, you can contact our' mod='dhpay'}
		<a href="{$link->getPageLink('contact-form.php', true)}">{l s='customer support' mod='dhpay'}</a>.
	</p>
{/if}
