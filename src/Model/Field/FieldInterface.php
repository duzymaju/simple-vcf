<?php

namespace SimpleVcf\Model\Field;

use SimpleVcf\Model\ParamInterface;
use SimpleVcf\Tool\ToStringInterface;

interface FieldInterface extends ToStringInterface
{
    /** @var string[] */
    const SPECIFIC_FIELDS = [
        AddressField::class,
        BirthdayField::class,
        EmailField::class,
        FormattedNameField::class,
        NameField::class,
        PhotoField::class,
        TelephoneField::class,
        TimeZoneField::class,
        UidField::class,
        UrlField::class,
        VersionField::class,
    ];

    /**
     * Construct
     *
     * @param int      $lineLength      line length
     * @param int|null $firstLineLength first line length
     */
    public function __construct($lineLength, $firstLineLength = null);

    /**
     * Get static name
     *
     * @return string
     */
    public static function getStaticName();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Is required
     *
     * @return bool
     */
    public static function isRequired();

    /**
     * Is single
     *
     * @return bool
     */
    public static function isSingle();

    /**
     * Get params
     *
     * @return ParamInterface[]
     */
    public function getParams();

    /**
     * Set params
     *
     * @param ParamInterface[] $params params
     *
     * @return self
     */
    public function setParams(array $params);

    /**
     * Add param
     *
     * @param ParamInterface $param param
     *
     * @return self
     */
    public function addParam(ParamInterface $param);

    /**
     * Get value
     *
     * @return string|null
     */
    public function getValue();

    /**
     * Set value
     *
     * @param string $value value
     *
     * @return self
     */
    public function setValue($value);
}
