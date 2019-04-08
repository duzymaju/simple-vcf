<?php

namespace SimpleVcf\Factory;

use SimpleVcf\Model\Param;
use SimpleVcf\Model\ParamInterface;

class ParamFactory
{
    /** @var bool */
    private $useDefaultName;

    /**
     * Construct
     *v
     * @param bool $useDefaultName use default name
     */
    public function __construct($useDefaultName)
    {
        $this->useDefaultName = $useDefaultName;
    }

    /**
     * Create
     *
     * @param string $content content
     *
     * @return ParamInterface
     */
    public function create($content)
    {
        $param = new Param();
        $parts = explode('=', $content);
        $name = count($parts) > 1 ? strtoupper(array_shift($parts)) : null;
        $param->setName(empty($name) || $name === 'TYPE' ? ($this->useDefaultName ? 'TYPE' : null) : $name);
        $param->setValue(strtoupper(implode('=', $parts)));

        return $param;
    }
}
