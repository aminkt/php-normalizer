<?php

namespace aminkt\normalizer;

/**
 * This is just an example.
 */
class Normalize extends \Normalizer
{
    const STRATEGY_BY_ZERO = 1;
    const STRATEGY_BY_COUNTRY_CODE = 2;

    /**
     * Normalize mobile number.
     *
     * @param string $mobile Mobile number.
     * @param integer $strategy Strategy of normalization.
     * @param string|null $countryCode Use as country code if not setted by default number.
     *
     * @return bool|string Mobile normalized or false if can't normalize mobile.
     */
    public static function normalizeMobile($mobile, $strategy = self::STRATEGY_BY_COUNTRY_CODE, $countryCode = '98')
    {
        if (preg_match('#(\+?98|0)(\d{10})$#is', $mobile, $matches)) {
            $phone = $matches[2];
            $cc = $matches[1];

            if ($strategy == self::STRATEGY_BY_COUNTRY_CODE) {
                if ($cc != 0) {
                    return str_replace('+', '', $cc) . $phone;
                } else {
                    return $countryCode . $phone;
                }
            } elseif ($strategy == self::STRATEGY_BY_ZERO) {
                return '0' . $phone;
            }
        }
        return false;
    }
}
