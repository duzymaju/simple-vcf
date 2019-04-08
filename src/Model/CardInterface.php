<?php

namespace SimpleVcf\Model;

use SimpleVcf\Model\Field\FieldInterface;
use SimpleVcf\Tool\ToStringInterface;

interface CardInterface extends ToStringInterface
{
    /**
     * Get fields
     *
     * @return FieldInterface[]
     */
    public function getFields();

    /**
     * Set fields
     *
     * @param FieldInterface[] $fields fields
     *
     * @return self
     */
    public function setFields(array $fields);

    /**
     * Add field
     *
     * @param FieldInterface $field field
     *
     * @return self
     */
    public function addField(FieldInterface $field);

    /**
     * Is valid
     *
     * @return bool
     */
    public function isValid();

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get sum
     *
     * @return string|null
     */
    public function getSum();
}
