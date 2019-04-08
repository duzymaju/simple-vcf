<?php

namespace SimpleVcf\Model\Field;

class PhotoField extends FieldAbstract
{
    /**
     * Get static name
     *
     * @return string
     */
    public static function getStaticName()
    {
        return 'PHOTO';
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
