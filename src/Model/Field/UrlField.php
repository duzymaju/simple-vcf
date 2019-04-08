<?php

namespace SimpleVcf\Model\Field;

class UrlField extends FieldAbstract
{
    /**
     * Get static name
     *
     * @return string
     */
    public static function getStaticName()
    {
        return 'URL';
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
