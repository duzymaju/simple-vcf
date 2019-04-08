<?php

namespace SimpleVcf\Model\Field;

class AddressField extends FieldAbstract
{
    /**
     * Get static name
     *
     * @return string
     */
    public static function getStaticName()
    {
        return 'ADR';
    }

    /**
     * Is required
     *
     * @return bool
     */
    public static function isRequired()
    {
        return false;
    }

    /**
     * Is single
     *
     * @return bool
     */
    public static function isSingle()
    {
        return false;
    }
}
