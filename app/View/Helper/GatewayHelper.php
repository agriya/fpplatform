<?php
class GatewayHelper extends AppHelper {
    var $helpers = array('Form', 'Html');

	function feesAddedAmount($amount, $gateway){
		//Gateway fees in percentage for all payment
		$gateway_fees = array('paypal' => '2.9');
		if (empty($gateway_fees[$gateway])) {
			trigger_error('*** dev1framework: Invalid payment gateway name passed', E_USER_ERROR);
		}
		return (((((100*$gateway_fees[$gateway])/(100-$gateway_fees[$gateway]))/100) * $amount) + $amount);
	}    
}
?>