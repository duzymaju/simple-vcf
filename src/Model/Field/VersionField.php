<?php

namespace SimpleVcf\Model\Field;

class VersionField extends FieldAbstract
{
    /**
     * Get static name
     *
     * @return string
     */
    public static function getStaticName()
    {
        return 'VERSION';
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
