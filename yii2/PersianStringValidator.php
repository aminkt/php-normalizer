<?php

namespace aminkt\normalizer\yii2;

use aminkt\normalizer\Normalize;
use aminkt\normalizer\Validation;
use yii\validators\StringValidator;

/**
 * Validate string to not an arrabic string.
 *
 * Class PersianStringValidator
 *
 * @package aminkt\normalizer\yii2
 */
class PersianStringValidator extends StringValidator
{
    /**
     * Set this attribute true to not throw an error and fix string.
     * If set to false an arror will add and validation become fail.
     * @var bool
     */
    public $normalize = true;

    /**
     * If set true all numbers will convert to english.
     * @var bool
     */
    public $convertToEnglishNumber = false;

    /**
     * If set true all numbers will convert to persian.
     * @var bool
     */
    public $convertToPersianNumber = false;

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        parent::validateAttribute($model, $attribute);
        $value = $model->$attribute;

        if($this->normalize){
            if($this->convertToEnglishNumber){
                $this->$attribute = Normalize::englishNumbers($value);
            }
            if($this->convertToPersianNumber){
                $this->$attribute = Normalize::persianNumbers($value);
            }
            $model->$attribute = Normalize::arabicToPersian($value);
        }else{

            if(Validation::isNotPersian($value)){
                $this->addError($model, $attribute, "کاراکتر های وارد شده باید فارسی باشند.");
            }

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
            if($this->strpos_array($value, $characters)){
                $this->addError($model, $attribute, "بعضی از مقادیر ورودی به زبان عربی میباشد.");
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function validateValue($value)
    {
        $return = parent::validateValue($value);
        
        if($return !== null){
            return $return;
        }

        if(Validation::isNotPersian($value)){
            return ["کاراکتر های وارد شده باید فارسی باشند."];
        }

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
        
        if($this->strpos_array($value, $characters)){
            return ["بعضی از مقادیر ورودی به زبان عربی میباشد."];
        }

        return null;
    }

    private function strpos_array($haystack, $needles) {
        if ( is_array($needles) ) {
            foreach ($needles as $str) {
                if ( is_array($str) ) {
                    $pos = strpos_array($haystack, $str);
                } else {
                    $pos = strpos($haystack, $str);
                }
                if ($pos !== FALSE) {
                    return $pos;
                }
            }
        } else {
            return strpos($haystack, $needles);
        }
    }
}