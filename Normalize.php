<?php

namespace aminkt\normalizer;

/**
 * This is just an example.
 */
class Normalize extends \Normalizer
{
    const STRATEGY_BY_ZERO = 1;
    const STRATEGY_BY_COUNTRY_CODER = 2;

    /**
     * Normalize mobile number.
     *
     * @param string    $mobile         Mobile number.
     * @param integer   $strategy       Strategy of normalization.
     *
     * @return string Mobile normalized
     */
    public static function normalizeMobile($mobile, $strategy=self::STRATEGY_BY_COUNTRY_CODER){

    }
}
