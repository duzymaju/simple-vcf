<?php

use PHPUnit\Framework\TestCase;
use SimpleVcf\Model\Field\Field;
use SimpleVcf\Model\Param;

final class FieldTest extends TestCase
{
    /** Test setters and getters */
    public function testSettersAndGetters()
    {
        $param1 = (new Param())->setName('A')->setValue('a');
        $param2 = (new Param())->setName('B')->setValue('b');
        $param3 = (new Param())->setName('C')->setValue('c');

        $field = new Field(100);
        $field
            ->setName('NAME')
            ->setValue('Value')
            ->setParams([ $param1, $param2 ])
            ->addParam($param3)
        ;
        $this->assertEquals('NAME', $field->getName());
        $this->assertEquals('Value', $field->getValue());
        $this->assertEquals([ $param1, $param2, $param3 ], $field->getParams());
    }

    /**
     * Test returning string
     *
     * @param string   $output          output
     * @param string   $name            name
     * @param string   $value           value
     * @param string[] $params          params
     * @param int      $lineLength      line length
     * @param int|null $firstLineLength first line length
     *
     * @dataProvider getContents
     */
    public function testReturningString($output, $name, $value, array $params = [], $lineLength = 100,
        $firstLineLength = null)
    {
        $field = new Field($lineLength, $firstLineLength);
        $field
            ->setName($name)
            ->setValue($value)
        ;
        foreach ($params as $paramName => $paramValue) {
            $param = new Param();
            $param
                ->setName($paramName)
                ->setValue($paramValue)
            ;
            $field->addParam($param);
        }
        $this->assertEquals($output, $field->toString());
    }

    /** Test returning multi-line string */
    public function getContents()
    {
        return [
            // returning short string
            [
                'NAME:Value',
                'NAME',
                'Value',
            ],
            // returning multi-line string without spaces
            [
                'VERY_LONG_NAME:VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_V
 eryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_Ver
 yLongValue',
                'VERY_LONG_NAME',
                'VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_' .
                'VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue_VeryLongValue',
            ],
            // returning short string with multi-byte chars
            [
                'NAME:Vąluę',
                'NAME',
                'Vąluę',
            ],
            // returning multi-line string with multi-byte chars
            [
                'VERY_LONG_NAME:VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_V
 ęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_Vęr
 yLongVąluę',
                'VERY_LONG_NAME',
                'VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_' .
                'VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę_VęryLongVąluę',
            ],
            // returning multi-line string with spaces
            [
                'NAME:Very long value very long value very long
  value very long value very long value very long
  value very long value very long value',
                'NAME',
                'Very long value very long value very long value very long value very long value very long value ' .
                'very long value very long value',
                [],
                50,
            ],
            // returning multi-line string with with multi-byte chars with spaces and shorter first line
            [
                'NAME:Vęry long vąluę vęry long
  vąluę vęry long vąluę vęry long vąluę vęry long
  vąluę vęry long vąluę vęry long vąluę vęry long
  vąluę',
                'NAME',
                'Vęry long vąluę vęry long vąluę vęry long vąluę vęry long vąluę vęry long vąluę vęry long vąluę ' .
                'vęry long vąluę vęry long vąluę',
                [],
                50,
                30,
            ],
            // returning multi-line string with with multi-byte chars with spaces and longer first line
            [
                'NAME:Vęry long vąluę vęry long vąluę vęry long vąluę vęry
  long vąluę vęry long vąluę vęry long vąluę vęry
  long vąluę vęry long vąluę',
                'NAME',
                'Vęry long vąluę vęry long vąluę vęry long vąluę vęry long vąluę vęry long vąluę vęry long vąluę ' .
                'vęry long vąluę vęry long vąluę',
                [],
                50,
                60,
            ],
            // returning short string with parameters
            [
                'NAME;PARAM_NAME_1="Param value";PARAM_NAME_2="Param;value";PARAM_NAME_3=Param_value:Value',
                'NAME',
                'Value',
                [
                    'PARAM_NAME_1' => 'Param value',
                    'PARAM_NAME_2' => 'Param;value',
                    'PARAM_NAME_3' => 'Param_value',
                ],
            ],
            // returning multi-line string with long parameter
            [
                'NAME;PARAM_NAME="Very long value very long
  value;very long value very long value;very long
  value very long value":Very short:value',
                'NAME',
                'Very short:value',
                [
                    'PARAM_NAME' => 'Very long value very long value;very long value very long value;very long value ' .
                        'very long value',
                ],
                50,
            ],
        ];
    }
}
