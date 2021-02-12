<?php

namespace SimpleVcf\Model;

class Param implements ParamInterface
{
    /** @var string|null */
    private $name;

    /** @var string|null */
    private $value;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string|null $name name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get value
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value
     *
     * @param string|null $value value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * To string
     *
     * @return string
     */
    public function toString()
    {
        if (empty($this->value)) {
            return '';
        }

        $value = $this->hasSpecialChars() ? sprintf('"%s"', $this->value) : $this->value;

        return empty($this->name) ? $value : $this->name . '=' . $value;
    }

    /**
     * Has special chars
     *
     * @return bool
     */
    private function hasSpecialChars()
    {
        if (strpos($this->value, ';') !== false) {
            return true;
        }
        if (strpos($this->value, PHP_EOL) !== false) {
            return true;
        }
        if (strpos($this->value, ' ') !== false) {
            return true;
        }

        return false;
    }
}
