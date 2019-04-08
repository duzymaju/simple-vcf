<?php

namespace SimpleVcf\Model\Field;

class FormattedNameField extends FieldAbstract
{
    /**
     * Get static name
     *
     * @return string
     */
    public static function getStaticName()
    {
        return 'FN';
    }

    /**
     * Is required
     *
     * @return bool
     */
    public static function isRequired()
    {
        return true;
    }

    /**
     * Is single
     *
     * @return bool
     */
    public static function isSingle()
    {
        return true;
    }
}
