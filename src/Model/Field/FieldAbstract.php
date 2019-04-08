<?php

namespace SimpleVcf\Model\Field;

use SimpleVcf\Model\ParamInterface;

abstract class FieldAbstract implements FieldInterface
{
    /** @var int */
    private $lineLength;

    /** @var int */
    private $firstLineLength;

    /** @var ParamInterface[] */
    private $params = [];

    /** @var string|null */
    private $value;

    /**
     * Construct
     *
     * @param int      $lineLength      line length
     * @param int|null $firstLineLength first line length
     */
    public function __construct($lineLength, $firstLineLength = null)
    {
        $this->lineLength = $lineLength;
        $this->firstLineLength = is_int($firstLineLength) ? $firstLineLength : $lineLength;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return static::getStaticName();
    }

    /**
     * Get params
     *
     * @return ParamInterface[]
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set params
     *
     * @param ParamInterface[] $params params
     *
     * @return self
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Add param
     *
     * @param ParamInterface $param param
     *
     * @return self
     */
    public function addParam(ParamInterface $param)
    {
        $this->params[] = $param;

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
     * @param string $value value
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
        $field = $this->getMultiLineField($this->getName() . $this->getParamsString() . ':' . $this->value);

        return $field;
    }

    /**
     * Get params string
     *
     * @return string
     */
    protected function getParamsString()
    {
        $paramsString = array_map(function (ParamInterface $param) {
            return ';' . $param->toString();
        }, $this->params);

        return implode('', $paramsString);
    }

    /**
     * Get multi line field
     *
     * @param string $field field
     *
     * @return string
     */
    protected function getMultiLineField($field)
    {
        $length = mb_strlen($field);
        if ($length <= $this->firstLineLength) {
            return $field;
        }

        $multiLineField = $this->getLine($field, $this->firstLineLength);
        do {
            $multiLineField .= PHP_EOL . ' ' . $this->getLine($field, $this->lineLength);
        } while ($field !== '');

        return $multiLineField;
    }

    /**
     * Get line
     *
     * @param string $text       text
     * @param int    $lineLength line length
     *
     * @return string
     */
    private function getLine(&$text, $lineLength)
    {
        $length = mb_strlen($text);
        if ($length <= $lineLength) {
            $line = $text;
            $text = '';

            return $line;
        }

        $part = mb_substr($text, 0, $lineLength);

        $fromLastSpace = mb_substr($text, $lineLength, 1) === ' ' ? '' : mb_strrchr($part, ' ');
        if ($fromLastSpace === false) {
            $line = $part;
            $text = mb_substr($text, $lineLength);

            return $line;
        }

        $cut = $lineLength - mb_strlen($fromLastSpace);
        $line = mb_substr($text, 0, $cut);
        $text = mb_substr($text, $cut);

        return $line;
    }
}
