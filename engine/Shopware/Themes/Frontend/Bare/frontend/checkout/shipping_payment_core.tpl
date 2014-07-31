{* Error messages *}
{block name='frontend_account_payment_error_messages'}
    {include file="frontend/register/error_message.tpl" error_messages=$sErrorMessages}
{/block}

<div class="confirm--outer-container">
    <form id="shippingPaymentForm" name="shippingPaymentForm" method="post" action="{url controller='checkout' action='saveShippingPayment' sTarget='checkout' sTargetAction='index'}" class="payment">

		{* Action top *}
		{block name='frontend_checkout_shipping_payment_core_buttons'}
			<div class="confirm--actions table--actions block">
				<input type="submit" value="{s namespace='frontend/checkout/shipping_payment' name='NextButton'}Weiter{/s}" class="btn btn--primary right main--actions" />
			</div>
		{/block}

		{* Payment and shipping information *}
        <div class="shipping-payment--information">

            {* Payment method *}
            <div class="confirm--inner-container block">
                {block name='frontend_checkout_shipping_payment_core_payment_fields'}
                    {include file='frontend/checkout/change_payment.tpl'}
                {/block}
            </div>

            {* Shipping method *}
            {if $sDispatches|count}
                <div class="confirm--inner-container block">
                    {block name='frontend_checkout_shipping_payment_core_shipping_fields'}
                        {include file="frontend/checkout/change_shipping.tpl"}
                    {/block}
                </div>
            {/if}
        </div>
    </form>

    {* Cart values *}
    <div class="confirm--inner-container block">
        {block name='frontend_checkout_shipping_payment_core_footer'}
            {include file="frontend/checkout/cart_footer.tpl"}
        {/block}
    </div>


    {* Action bottom *}
    {block name='frontend_checkout_shipping_payment_core_buttons'}
        <div class="confirm--actions table--actions block">
            <input type="submit" form="shippingPaymentForm" value="{s namespace='frontend/checkout/shipping_payment' name='NextButton'}Weiter{/s}" class="btn btn--primary right main--actions" />
        </div>
    {/block}

	{* Benefit and services footer *}
	{block name="frontend_checkout_footer"}
		{include file="frontend/checkout/table_footer.tpl"}
	{/block}
</div>
