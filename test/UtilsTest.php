<?php

class UtilsTest extends PHPUnit_Framework_TestCase {
    function dataToArray() {
        return [
            ['string', ['string']],
            [false, [false]],
            [null, []],
            [[1, 2, 3], [1, 2, 3]]
        ];
    }

    /**
     * @dataProvider dataToArray
     * @param mixed $actual
     * @param array $expected
     */
    public function testToArray($actual, $expected) {
        $this->assertSame(Utils::toArray($actual), $expected);
    }
}
