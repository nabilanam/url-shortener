<?php

namespace Tests\Unit;

use App\Services\UrlShortener;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{

    /* @var UrlShortener */
    private $shortener;

    public function setUp()
    {
        $this->shortener = new UrlShortener();
    }

    public function testBaseIsSixtyTwo()
    {
        $expected = 62;
        $found = $this->shortener->getBase();

        self::assertEquals($expected, $found);
    }

    public function testEncoding()
    {
        $expected = [1, 33];
        $found = $this->shortener->encode(95);

        self::assertEquals($expected, $found);
    }

    public function testWrap()
    {
        $expected = 'Bh';
        $found = $this->shortener->wrap([1, 33]);

        self::assertEquals($expected, $found);
    }

    public function testDecoding()
    {
        $expected = [33, 1];
        $found = $this->shortener->decode('Bh');

        self::assertEquals($expected, $found);
    }

    public function testUnwrap()
    {
        $expected = 95;
        $found = $this->shortener->unwrap([33, 1]);

        self::assertEquals($expected, $found);
    }
}
