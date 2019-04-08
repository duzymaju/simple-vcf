<?php

namespace SimpleVcf\Model;

use SimpleVcf\Tool\ToStringInterface;

interface ParamInterface extends ToStringInterface
{
    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     *
     * @param string|null $name name
     *
     * @return self
     */
    public function setName($name);

    /**
     * Get value
     *
     * @return string|null
     */
    public function getValue();

    /**
     * Set value
     *
     * @param string|null $value value
     *
     * @return self
     */
    public function setValue($value);
}
