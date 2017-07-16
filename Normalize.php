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
        if (preg_match('#^(\+?\d{1,3}|0|00\d{1,3})(\d{10})$#is', $mobile, $matches)) {
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

    /**
     * Convert persian and arabic numbers to english.
     *
     * @param string $number
     *
     * @return string
     */
    public static function englishNumbers($number){
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $number);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    /**
     * Convert english and arabic numbers to persian.
     *
     * @param string $number
     *
     * @return static
     */
    public static function persianNumbers($number){
        $num = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

        $english = range(0, 9);
        $convertArabicNumbers = str_replace($arabic, $num, $number);
        $persianNumbers = str_replace($english, $num, $convertArabicNumbers);

        return $persianNumbers;
    }
}
