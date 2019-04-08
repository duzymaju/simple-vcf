<?php

namespace SimpleVcf\Factory;

use SimpleVcf\Model\Field\Field;
use SimpleVcf\Model\Field\FieldInterface;

class FieldFactory
{
    /** @var ParamFactory */
    private $paramFactory;

    /** @var int */
    private $lineLength;

    /** @var int|null */
    private $firstLineLength;

    /**
     * Construct
     *
     * @param ParamFactory $paramFactory    param factory
     * @param int          $lineLength      line length
     * @param int|null     $firstLineLength first line length
     */
    public function __construct(ParamFactory $paramFactory, $lineLength, $firstLineLength = null)
    {
        $this->paramFactory = $paramFactory;
        $this->lineLength = $lineLength;
        $this->firstLineLength = $firstLineLength === $lineLength ? null : $firstLineLength;
    }

    /**
     * Create
     *
     * @param string $content content
     *
     * @return FieldInterface
     */
    public function create($content)
    {
        $parts = explode(':', $content);
        $nameParts = explode(';', array_shift($parts));
        // @TODO: Support param values surrounded by quotation marks ", ' and `
        $name = strtoupper(array_shift($nameParts));

        $field = $this->createField($name);
        $field->setParams(array_map(function ($data) {
            return $this->paramFactory->create(trim($data));
        }, $nameParts));
        $field->setValue(implode(':', $parts));

        return $field;
    }

    /**
     * Create field
     *
     * @param string $name name
     *
     * @return FieldInterface
     */
    private function createField($name)
    {
        /** @var FieldInterface $className */
        foreach (FieldInterface::SPECIFIC_FIELDS as $className) {
            if ($className::getStaticName() === $name) {
                return new $className($this->lineLength, $this->firstLineLength);
            }
        }

        $field = new Field($this->lineLength);
        $field->setName($name);

        return $field;
    }
}
