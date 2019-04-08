<?php

namespace SimpleVcf\Model\Field;

class Field extends FieldAbstract
{
    /** @var string|null */
    private $name;

    /**
     * Get static name
     *
     * @return string
     */
    public static function getStaticName()
    {
        return '';
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
