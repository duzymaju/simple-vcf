<?php

use PHPUnit\Framework\TestCase;
use SimpleVcf\Factory\CardFactory;
use SimpleVcf\Factory\CardListFactory;
use SimpleVcf\Model\Card;

final class CardListFactoryTest extends TestCase
{
    /** @var CardFactory|PHPUnit_Framework_MockObject_MockObject */
    private $cardFactoryMock;

    /** @before */
    public function setupMocks()
    {
        $this->cardFactoryMock = $this->createMock(CardFactory::class);
    }

    /**
     * Test creating card list
     *
     * @param bool       $omitInvalid  omit invalid
     * @param string[]   $input        input
     * @param string[][] $cardContents card contents
     * @param int        $cardsCounter cards counter
     *
     * @dataProvider getContents
     */
    public function testCreatingCardList($omitInvalid, array $input, array $cardContents, $cardsCounter)
    {
        $this->cardFactoryMock
            ->expects($this->exactly(count($cardContents)))
            ->method('create')
            ->withConsecutive(...array_map(function ($cardContent) {
                return [$cardContent];
            }, $cardContents))
            ->willReturnCallback(function ($cardContent) {
                return new CardStub(count($cardContent) > 0);
            })
        ;
        $factory = new CardListFactory($this->cardFactoryMock, $omitInvalid);
        $list = $factory->create($input);
        $this->assertEquals($cardsCounter, count($list->getCards()));
    }

    public function getContents()
    {
        return [
            // empty list
            [
                false,
                [],
                [],
                0,
            ],
            // three cards (one empty) with empty lines
            [
                false,
                [
                    '',
                    'BEGIN:VCARD',
                    'A',
                    'B',
                    '',
                    'C',
                    'END:VCARD',
                    'BEGIN:VCARD',
                    'END:VCARD',
                    'BEGIN:VCARD',
                    'D',
                    'END:VCARD',
                ],
                [
                    [
                        'A',
                        'B',
                        'C',
                    ],
                    [],
                    [
                        'D',
                    ],
                ],
                3,
            ],
            // three cards (one empty which will be omitted) with empty lines
            [
                true,
                [
                    '',
                    'BEGIN:VCARD',
                    'A',
                    'B',
                    '',
                    'C',
                    'END:VCARD',
                    'BEGIN:VCARD',
                    'END:VCARD',
                    'BEGIN:VCARD',
                    'D',
                    'END:VCARD',
                ],
                [
                    [
                        'A',
                        'B',
                        'C',
                    ],
                    [],
                    [
                        'D',
                    ],
                ],
                2,
            ],
            // card without end line
            [
                false,
                [
                    'BEGIN:VCARD',
                    'A',
                    '',
                ],
                [],
                0,
            ],
            // card without start line
            [
                false,
                [
                    'B',
                    'END:VCARD',
                    '',
                ],
                [],
                0,
            ],
            // cards, one of which has no end line
            [
                false,
                [
                    'BEGIN:VCARD',
                    'A',
                    'BEGIN:VCARD',
                    'B',
                    'END:VCARD',
                ],
                [
                    [
                        'B',
                    ],
                ],
                1,
            ],
        ];
    }
}

class CardStub extends Card
{
    private $isValid;

    public function __construct($isValid)
    {
        $this->isValid = $isValid;
    }

    public function isValid()
    {
        return $this->isValid;
    }
}
