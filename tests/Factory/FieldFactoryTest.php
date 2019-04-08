<?php

use PHPUnit\Framework\TestCase;
use SimpleVcf\Factory\FieldFactory;
use SimpleVcf\Factory\ParamFactory;
use SimpleVcf\Model\Param;

final class FieldFactoryTest extends TestCase
{
    /** @var ParamFactory|PHPUnit_Framework_MockObject_MockObject */
    private $paramFactoryMock;

    /** @before */
    public function setupMocks()
    {
        $this->paramFactoryMock = $this->createMock(ParamFactory::class);
    }

    /**
     * Test creating field
     *
     * @param string   $input           input
     * @param string   $class           class
     * @param string   $name            name
     * @param string   $value           value
     * @param string[] $params          params
     * @param int      $lineLength      line length
     * @param int|null $firstLineLength first line length
     *
     * @dataProvider getContents
     */
    public function testCreatingField($input, $class, $name, $value, array $params = [], $lineLength = 200,
        $firstLineLength = null)
    {
        $this->paramFactoryMock
            ->expects($this->exactly(count($params)))
            ->method('create')
            ->withConsecutive(...array_map(function ($param) {
                return [ $param ];
            }, $params))
            ->willReturn(new Param())
        ;
        $factory = new FieldFactory($this->paramFactoryMock, $lineLength, $firstLineLength);
        $field = $factory->create($input);
        $this->assertTrue($field instanceof $class);
        $this->assertEquals($name, $field->getName());
        $this->assertEquals(count($params), count($field->getParams()));
        $this->assertEquals($value, $field->getValue());
    }

    public function getContents()
    {
        return [
            // address field
            [
                'ADR:123;45;Example St.;Krakow;Malopolska;30-123;Poland',
                'SimpleVcf\Model\Field\AddressField',
                'ADR',
                '123;45;Example St.;Krakow;Malopolska;30-123;Poland',
            ],
            // birthday field
            [
                'BDAY:2017-08-29',
                'SimpleVcf\Model\Field\BirthdayField',
                'BDAY',
                '2017-08-29',
            ],
            // e-mail field
            [
                'EMAIL:john.doe@example.com',
                'SimpleVcf\Model\Field\EmailField',
                'EMAIL',
                'john.doe@example.com',
            ],
            // formatted name field
            [
                'FN:John Doe',
                'SimpleVcf\Model\Field\FormattedNameField',
                'FN',
                'John Doe',
            ],
            // name field
            [
                'N:Doe;John;Peter,Paul;Dr.;Jr.',
                'SimpleVcf\Model\Field\NameField',
                'N',
                'Doe;John;Peter,Paul;Dr.;Jr.',
            ],
            // photo URL field
            [
                'PHOTO;JPEG;MEDIATYPE=image/jpeg;VALUE=URI:https://example.com/photo.jpg',
                'SimpleVcf\Model\Field\PhotoField',
                'PHOTO',
                'https://example.com/photo.jpg',
                [
                    'JPEG',
                    'MEDIATYPE=image/jpeg',
                    'VALUE=URI',
                ]
            ],
            // base64 photo field
            [
                'PHOTO;ENCODING=B;TYPE=PNG:iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/' .
                    'PchI7wAAAABJRU5ErkJggg==',
                'SimpleVcf\Model\Field\PhotoField',
                'PHOTO',
                'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==',
                [
                    'ENCODING=B',
                    'TYPE=PNG',
                ]
            ],
            // telephone field
            [
                'TEL:+48123456789',
                'SimpleVcf\Model\Field\TelephoneField',
                'TEL',
                '+48123456789',
            ],
            // time zone field
            [
                'TZ:Europe/Warsaw',
                'SimpleVcf\Model\Field\TimeZoneField',
                'TZ',
                'Europe/Warsaw',
            ],
            // UID field
            [
                'UID:abc-123',
                'SimpleVcf\Model\Field\UidField',
                'UID',
                'abc-123',
            ],
            // URL field
            [
                'URL:https://example.com',
                'SimpleVcf\Model\Field\UrlField',
                'URL',
                'https://example.com',
            ],
            // version field
            [
                'VERSION:2.0',
                'SimpleVcf\Model\Field\VersionField',
                'VERSION',
                '2.0',
            ],
        ];
    }
}
