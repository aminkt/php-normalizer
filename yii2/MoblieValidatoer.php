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
class MoblieValidatoer extends StringValidator
{
    public $strategy = Normalize::STRATEGY_BY_COUNTRY_CODE;

    public $prefix = '98';


    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;

        $normalaized = Normalize::normalizeMobile($value, $this->strategy, $this->prefix);
        if($normalaized){
            $model->$attribute = $normalaized;
        }else{
            $this->addError($model, $attribute, "شماره همراه وارد شده صحصیح نیست.");
        }
    }

    /**
     * @inheritdoc
     */
    public function validateValue($value)
    {
        $normalaized = Normalize::normalizeMobile($value, $this->strategy, $this->prefix);
        return $normalaized ? null : ["شماره همراه وارد شده صحصیح نیست.", []];
    }
}