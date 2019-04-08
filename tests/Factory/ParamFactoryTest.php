<?php

use PHPUnit\Framework\TestCase;
use SimpleVcf\Factory\ParamFactory;

final class ParamFactoryTest extends TestCase
{
    /**
     * Test creating param
     *
     * @param bool        $defaultName default name
     * @param string      $content     content
     * @param string|null $name        name
     * @param string|null $value       value
     * @param string      $result      result
     *
     * @testWith [false, "ABC", null, "ABC", "ABC"]
     *           [false, "TYPE=ABC", null, "ABC", "ABC"]
     *           [false, "DEF=ABC", "DEF", "ABC", "DEF=ABC"]
     *           [true, "ABC", "TYPE", "ABC", "TYPE=ABC"]
     *           [true, "TYPE=ABC", "TYPE", "ABC", "TYPE=ABC"]
     *           [true, "DEF=ABC", "DEF", "ABC", "DEF=ABC"]
     */
    public function testCreatingParam($defaultName, $content, $name, $value, $result)
    {
        $factory = new ParamFactory($defaultName);
        $param = $factory->create($content);
        $this->assertEquals($name, $param->getName());
        $this->assertEquals($value, $param->getValue());
        $this->assertEquals($result, $param->toString());
    }
}
