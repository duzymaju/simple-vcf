<?php

namespace SimpleVcf\Model\Field;

class NameField extends FieldAbstract
{
    /**
     * Get static name
     *
     * @return string
     */
    public static function getStaticName()
    {
        return 'N';
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
