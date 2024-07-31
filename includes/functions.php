<?php

// Calculate new price based on the parameters
function bpu_calculate_new_price($current_price, $price_change, $change_type, $operation_type) {
    if ($change_type === 'percentage') {
        $price_change_amount = $current_price * ($price_change / 100);
    } else {
        $price_change_amount = $price_change;
    }

    if ($operation_type === 'reduce') {
        return max(0, $current_price - $price_change_amount);
    } else {
        return $current_price + $price_change_amount;
    }
}