<?php

namespace SimpleVcf\Model;

use SimpleVcf\Model\Field\FieldInterface;
use SimpleVcf\Model\Field\NameField;

class Card implements CardInterface
{
    /** @var FieldInterface[] */
    private $fields = [];

    /** @var string|null */
    private $name;

    /** @var string|null */
    private $sum;

    /**
     * Get fields
     *
     * @return FieldInterface[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set fields
     *
     * @param FieldInterface[] $fields fields
     *
     * @return self
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
        $this->resetCaches($fields);

        return $this;
    }

    /**
     * Add field
     *
     * @param FieldInterface $field field
     *
     * @return self
     */
    public function addField(FieldInterface $field)
    {
        $this->fields[] = $field;
        $this->resetCaches([ $field ]);

        return $this;
    }

    /**
     * Is valid
     *
     * @return bool
     */
    public function isValid()
    {
        $fieldCounters = array_reduce($this->fields, function (array $counters, FieldInterface $field) {
            if (!array_key_exists($field->getName(), $counters)) {
                $counters[$field->getName()] = 0;
            }
            $counters[$field->getName()]++;

            return $counters;
        }, []);

        /** @var FieldInterface[] $requiredFields */
        $requiredFields = array_filter(FieldInterface::SPECIFIC_FIELDS, function ($className) {
            /** @var FieldInterface $className */
            return $className::isRequired();
        });
        foreach ($requiredFields as $requiredField) {
            $name = $requiredField::getStaticName();
            if (!array_key_exists($name, $fieldCounters) || $fieldCounters[$name] < 1) {
                return false;
            }
        }

        /** @var FieldInterface[] $singleFields */
        $singleFields = array_filter(FieldInterface::SPECIFIC_FIELDS, function ($className) {
            /** @var FieldInterface $className */
            return $className::isSingle();
        });
        foreach ($singleFields as $singleField) {
            $name = $singleField::getStaticName();
            if (array_key_exists($name, $fieldCounters) && $fieldCounters[$name] > 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName()
    {
        if (!isset($this->name)) {
            foreach ($this->fields as $field) {
                if ($field->getName() === NameField::getStaticName()) {
                    $this->name = $field->getValue();
                    break;
                }
            }
        }

        return $this->name;
    }

    /**
     * Get sum
     *
     * @return string|null
     */
    public function getSum()
    {
        if (!isset($this->sum)) {
            $this->sum = md5($this->toString());
        }

        return $this->sum;
    }

    /**
     * To string
     *
     * @return string
     */
    public function toString()
    {
        $rows = [];
        $rows[] = 'BEGIN:VCARD';
        foreach ($this->fields as $field) {
            $rows[] = $field->toString();
        }
        $rows[] = 'END:VCARD';
        return implode(PHP_EOL, $rows);
    }

    /**
     * Reset caches
     *
     * @param FieldInterface[] $newFields new fields
     *
     * @return self
     */
    private function resetCaches(array $newFields)
    {
        $this->sum = null;

        foreach ($newFields as $newField) {
            if ($newField->getName() === 'N') {
                $this->name = null;
            }
        }

        return $this;
    }
}
