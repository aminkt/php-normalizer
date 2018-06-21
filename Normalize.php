<?php

namespace aminkt\normalizer;

/**
 * Normalizer
 *
 * @author Amin keshavarz <Amin@keshavarz.pro>
 * @package \aminkt\normalizer
 */
class Normalize
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
     * @return string
     */
    public static function persianNumbers($number){
        $num = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

        $english = range(0, 9);
        $convertArabicNumbers = str_replace($arabic, $num, $number);
        $persianNumbers = str_replace($english, $num, $convertArabicNumbers);

        return $persianNumbers;
    }

    /**
     * Normalize IBAN number to standard same IR810140040000410019300608
     *
     * @param $iban
     *
     * @return string
     */
    public static function normalizeIBAN($iban)
    {
        $shaba = strtoupper($iban);
        $shaba = str_replace(' ', '', $shaba);
        $shaba = str_replace("\n", '', $shaba);
        return $shaba;
    }

    /**
     * Normailize card number.
     *
     * @param $cardNumber
     *
     * @return mixed
     */
    public static function normalizeCreditCardNumber($cardNumber)
    {
        return str_replace([' ', '-', '/', '_', '\\'], '', $cardNumber);
    }

    /**
     * Changes arabic letters with persian letters
     *
     * @param $attribute
     *
     * @return mixed
     *
     * @author Pooria Anvari <masonalex540@gmail.com>
     */
    public static function arabicToPersian($value)
    {
        $characters = [
            'ك' => 'ک',
            'دِ' => 'د',
            'بِ' => 'ب',
            'زِ' => 'ز',
            'ذِ' => 'ذ',
            'شِ' => 'ش',
            'سِ' => 'س',
            'ى' => 'ی',
            'ي' => 'ی',
            '١' => '۱',
            '٢' => '۲',
            '٣' => '۳',
            '٤' => '۴',
            '٥' => '۵',
            '٦' => '۶',
            '٧' => '۷',
            '٨' => '۸',
            '٩' => '۹',
            '٠' => '۰',
        ];

        return str_replace(array_keys($characters), array_values($characters), $value);
    }
}
