{capture name=path}{l s='Pay by your Dhpay' mod='dhpay'}{/capture}
<h2>{l s='CONFIRM YOUR ORDER' mod='dhpay'}</h2>
{assign var='current_step' value='dhpay'}
{include file="$tpl_dir./order-steps.tpl"}

<h3>{l s='Pay by Dhpay' mod='dhpay'}</h3>
<p>
	<img src="{$this_path}logo.png" alt="{l s='Pay by Dhpay' mod='dhpay'}" style="float:left; margin: 0px 10px 5px 0px;" />
	{l s='You have chosen to pay by Dhpay.' mod='dhpay'}
</p>
<p style="margin-top:20px;">
	{l s='Your order has been generated, and the cart has been emptied.' mod='dhpay'}
	<br />
	{l s='Here is a short summary of your order:' mod='dhpay'}
</p>
<p>
	- {l s='The total amount of your order is' mod='dhpay'}
	<span id="amount" class="price">{displayPrice price=$v_amount}</span>
</p>
{$form_content}