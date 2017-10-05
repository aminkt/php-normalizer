<?php

namespace aminkt\normalizer;

/**
 * Validator
 *
 * @author Amin keshavarz <Amin@keshavarz.pro>
 * @since OCTOBER 5, 2017
 *
 * @package \aminkt\normalizer
 */
class Validation
{
    /**
     * Validate and normalaize shaba number.
     *
     * @author Amin keshavarz <Amin@keshavarz.pro>
     * @since OCTOBER 5, 2017
     *
     * @return boolean
     */
    public static function checkIBAN($iban)
    {
        $iban = strtolower(Normalize::normalizeIBAN($iban));
        $Countries = array('ir' => '26', 'al' => 28, 'ad' => 24, 'at' => 20, 'az' => 28, 'bh' => 22, 'be' => 16, 'ba' => 20, 'br' => 29, 'bg' => 22, 'cr' => 21, 'hr' => 21, 'cy' => 28, 'cz' => 24, 'dk' => 18, 'do' => 28, 'ee' => 20, 'fo' => 18, 'fi' => 18, 'fr' => 27, 'ge' => 22, 'de' => 22, 'gi' => 23, 'gr' => 27, 'gl' => 18, 'gt' => 28, 'hu' => 28, 'is' => 26, 'ie' => 22, 'il' => 23, 'it' => 27, 'jo' => 30, 'kz' => 20, 'kw' => 30, 'lv' => 21, 'lb' => 28, 'li' => 21, 'lt' => 20, 'lu' => 20, 'mk' => 19, 'mt' => 31, 'mr' => 27, 'mu' => 30, 'mc' => 27, 'md' => 24, 'me' => 22, 'nl' => 18, 'no' => 15, 'pk' => 24, 'ps' => 29, 'pl' => 28, 'pt' => 25, 'qa' => 29, 'ro' => 24, 'sm' => 27, 'sa' => 24, 'rs' => 22, 'sk' => 24, 'si' => 19, 'es' => 24, 'se' => 24, 'ch' => 21, 'tn' => 24, 'tr' => 26, 'ae' => 23, 'gb' => 22, 'vg' => 24);
        $Chars = array('a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18, 'j' => 19, 'k' => 20, 'l' => 21, 'm' => 22, 'n' => 23, 'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29, 'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34, 'z' => 35);

        $countryCode = substr($iban, 0, 2);
        if (self::isNotPersian($iban) and isset($Countries[$countryCode]) and strlen($iban) == $Countries[$countryCode]) {

            $MovedChar = substr($iban, 4) . substr($iban, 0, 4);
            $MovedCharArray = str_split($MovedChar);
            $NewString = "";

            foreach ($MovedCharArray AS $key => $value) {
                if (!is_numeric($MovedCharArray[$key])) {
                    $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
                }
                $NewString .= $MovedCharArray[$key];
            }

            if (bcmod($NewString, '97') == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * validate persian alphabet and space
     *
     * @param $value
     *
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     *
     * @since May 21, 2016
     *
     * @return boolean
     */
    public static function alpha($value)
    {
        return (bool)preg_match("/^[\x{600}-\x{6FF}\x{200c}\x{064b}\x{064d}\x{064c}\x{064e}\x{064f}\x{0650}\x{0651}\s]+$/u", $value);
    }

    /**
     * validate persian number
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since May 21, 2016
     * @return boolean
     */
    public static function num($value)
    {
        return (bool)preg_match('/^[\x{6F0}-\x{6F9}]+$/u', $value);
    }

    /**
     * validate persian alphabet, number and space
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since May 21, 2016
     * @return boolean
     */
    public static function alphaNum($value)
    {
        return (bool)preg_match('/^[\x{600}-\x{6FF}\x{200c}\x{064b}\x{064d}\x{064c}\x{064e}\x{064f}\x{0650}\x{0651}\s]+$/u', $value);
    }

    /**
     * validate mobile number
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since May 21, 2016
     * @return boolean
     */
    public static function iranMobile($value)
    {
        if ((bool)preg_match('/^(((98)|(\+98)|(0098)|0)(9){1}[0-9]{9})+$/', $value) || (bool)preg_match('/^(9){1}[0-9]{9}+$/', $value))
            return true;
        return false;
    }

    /**
     * validate sheba number
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since May 21, 2016
     * @return boolean
     */
    public static function sheba($value)
    {
        $ibanReplaceValues = array();

        if (!self::isNotPersian($value))
            return false;

        if (!empty($value)) {
            $value = preg_replace('/[\W_]+/', '', strtoupper($value));
            if ((4 > strlen($value) || strlen($value) > 34) || (is_numeric($value [0]) || is_numeric($value [1])) || (!is_numeric($value [2]) || !is_numeric($value [3]))) {
                return false;
            }
            $ibanReplaceChars = range('A', 'Z');
            foreach (range(10, 35) as $tempvalue) {
                $ibanReplaceValues[] = strval($tempvalue);
            }
            $tmpIBAN = substr($value, 4) . substr($value, 0, 4);
            $tmpIBAN = str_replace($ibanReplaceChars, $ibanReplaceValues, $tmpIBAN);
            $tmpValue = intval(substr($tmpIBAN, 0, 1));
            for ($i = 1; $i < strlen($tmpIBAN); $i++) {
                $tmpValue *= 10;
                $tmpValue += intval(substr($tmpIBAN, $i, 1));
                $tmpValue %= 97;
            }
            if ($tmpValue != 1) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * validate meliCode number
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since May 21, 2016
     * @return boolean
     */
    public static function nationalCode($value)
    {
        if (!preg_match('/^\d{8,10}$/', $value) || preg_match('/^[0]{10}|[1]{10}|[2]{10}|[3]{10}|[4]{10}|[5]{10}|[6]{10}|[7]{10}|[8]{10}|[9]{10}$/', $value)) {
            return false;
        }
        $sub = 0;
        if (strlen($value) == 8) {
            $value = '00' . $value;
        } elseif (strlen($value) == 9) {
            $value = '0' . $value;
        }
        for ($i = 0; $i <= 8; $i++) {
            $sub = $sub + ($value[$i] * (10 - $i));
        }
        if (($sub % 11) < 2) {
            $control = ($sub % 11);
        } else {
            $control = 11 - ($sub % 11);
        }
        if ($value[9] == $control) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * validate string that is not contain persian alphabet and number
     *
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     *
     * @since June 13, 2016
     * @return boolean
     */
    public static function isNotPersian($value)
    {
        if (is_string($value)) {
            $status = (bool)preg_match("/[\x{600}-\x{6FF}]/u", $value);
            return !$status;
        }
        return false;
    }

    /**
     * validate number to be unsigned
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since July 22, 2016
     * @return boolean
     */
    public static function unSignedNum($value)
    {
        return (bool)preg_match('/^\d+$/', $value);
    }

    /**
     * validate Url
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since Agu 17, 2016
     * @return boolean
     */
    public static function url($value)
    {
        return (bool)preg_match("/^(HTTP|http(s)?:\/\/(www\.)?[A-Za-z0-9]+([\-\.]{1,2}[A-Za-z0-9]+)*\.[A-Za-z]{2,40}(:[0-9]{1,40})?(\/.*)?)$/", $value);
    }

    /**
     * validate Domain
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since Agu 17, 2016
     * @return boolean
     */
    public static function domain($value)
    {
        return (bool)preg_match("/^((www\.)?(\*\.)?[A-Za-z0-9]+([\-\.]{1,2}[A-Za-z0-9]+)*\.[A-Za-z]{2,40}(:[0-9]{1,40})?(\/.*)?)$/", $value);
    }


    /**
     * iran phone number
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since Agu 24, 2016
     * @return boolean
     */
    public static function iranPhone($value)
    {
        return (bool)preg_match('/^[2-9][0-9]{7}+$/', $value);
    }

    /**
     * payment card number validation
     * depending on 'http://www.aliarash.com/article/creditcart/credit-debit-cart.htm' article
     *
     * @param $value
     * @author Mojtaba Anisi <geevepahlavan@yahoo.com>
     * @since Oct 1, 2016
     * @return boolean
     */
    static function cardNumber($value)
    {
        $value = Normalize::normalizeCreditCardNumber($value);
        if (!preg_match('/^\d{16}$/', $value)) {
            return false;
        }
        $sum = 0;
        for ($position = 1; $position <= 16; $position++) {
            $temp = $value[$position - 1];
            $temp = $position % 2 === 0 ? $temp : $temp * 2;
            $temp = $temp > 9 ? $temp - 9 : $temp;
            $sum += $temp;
        }
        return (bool)($sum % 10 === 0);
    }

    /**
     * validate Iran postal code format
     *
     * @param $value
     * @author Shahrokh Niakan <sh.niakan@anetwork.ir>
     * @since Apr 5, 2017
     * @return boolean
     */
    public static function iranPostalCode($value)
    {
        return (bool)preg_match("/^(\d{5}-?\d{5})$/", $value);
    }
}
