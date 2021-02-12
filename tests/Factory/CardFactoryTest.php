<?php

use PHPUnit\Framework\TestCase;
use SimpleVcf\Factory\CardFactory;
use SimpleVcf\Factory\FieldFactory;
use SimpleVcf\Model\Field\Field;

final class CardFactoryTest extends TestCase
{
    /** @var FieldFactory|PHPUnit_Framework_MockObject_MockObject */
    private $fieldFactoryMock;

    /** @before */
    public function setupMocks()
    {
        $this->fieldFactoryMock = $this->createMock(FieldFactory::class);
    }

    /**
     * Test creating card
     *
     * @param string[]   $input         input
     * @param string[][] $fieldContents field contents
     *
     * @dataProvider getContents
     */
    public function testCreating(array $input, array $fieldContents)
    {
        $this->fieldFactoryMock
            ->expects($this->exactly(count($fieldContents)))
            ->method('create')
            ->withConsecutive(...array_map(function ($fieldContent) {
                return [$fieldContent];
            }, $fieldContents))
            ->willReturn(new Field(100))
        ;
        $factory = new CardFactory($this->fieldFactoryMock);
        $card = $factory->create($input);
        $this->assertEquals(count($fieldContents), count($card->getFields()));
    }

    public function getContents()
    {
        return [
            // empty card
            [
                [],
                [],
            ],
            // card with random field
            [
                [
                    'abcdefg',
                ],
                [
                    'abcdefg',
                ],
            ],
            // card with single-line field
            [
                [
                    'ABC:Def',
                ],
                [
                    'ABC:Def',
                ],
            ],
            // card with multi-line fields
            [
                [
                    'ABC:def',
                    ' ghi',
                    '',
                    ' jkl',
                    '',
                    'DEF:ghi',
                    '',
                    ' ',
                    'GHI:jkl',
                    '  mno',
                    'JKL:mno',
                    'MNO:prs',
                ],
                [
                    'ABC:defghijkl',
                    'DEF:ghi',
                    'GHI:jkl mno',
                    'JKL:mno',
                    'MNO:prs',
                ],
            ],
            // card with multi-byte, single-line field
            [
                [
                    'ABC:ąćę',
                ],
                [
                    'ABC:ąćę',
                ],
            ],
            // card with multi-byte, multi-line field
            [
                [
                    'ABC:ąćę',
                    '  łńó',
                    ' śźż',
                ],
                [
                    'ABC:ąćę łńóśźż',
                ],
            ],
        ];
    }
}
