<?php
function moneyFormat($amount) {
	@setlocale(LC_MONETARY, 'en_IN');
    $amount = function_exists('money_format') ? money_format('%!i', round($amount,2)) : number_format($amount,2, '.', '');
    return $amount;
}
?>