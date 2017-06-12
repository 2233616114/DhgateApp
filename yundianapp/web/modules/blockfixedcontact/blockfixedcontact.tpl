<!-- Block blockfixedcontact -->

<div id="blockfixedcontact">
    <ul class="right_list_ul">
        {*<li class="right_list_li">*}
            {*<p style="margin-right: -40px; opacity: 0;">My Cart</p>*}
            {*<div><a href="/index.php?controller=order"><img src="./img/skype.png"/></a></div>*}
        {*</li>*}
        {if isset($block_fixedcontact_email) && $block_fixedcontact_email}
            <li class="right_list_li">
                <p style="margin-right: -40px; opacity: 0;">Contact Us</p>
                <div><a href="mailto:{$block_fixedcontact_email}"><span class="email"></span></a></div>
            </li>
        {/if}
		{if isset($block_fixedcontact_skype) && $block_fixedcontact_skype}
			<li class="right_list_li">
				<p style="margin-right: -40px; opacity: 0;">skype online</p>
				<div><a href="skype:{$block_fixedcontact_skype}?chat"><span class="skype"></span></a></div>
			</li>
		{/if}
        {*<li class="right_list_li">*}
            {*<p style="margin-right: -40px; opacity: 0;">Online Chat</p>*}
            {*<div><a href="http://api1.pop800.com/chat/190779?l=en" target="_blank"><img src="./img/skype.png"/></a></div>*}
        {*</li>*}
        {*<li>*}
            {*<p></p>*}
            {*<div style="margin-top: 40px;"><span class="top"></span></div>*}
        {*</li>*}
    </ul>
</div>

<!-- /Block blockfixedcontact -->
