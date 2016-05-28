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

    public function testDeepAccess()
    {
        $data = [];

        $this->assertFalse(Utils::deepCheck('random.key', null));
        $this->assertNull(Utils::deepRead('random.key', null));

        $this->assertFalse(Utils::deepCheck('random.key', $data));

        Utils::deepWrite('random.key', $data, 'value');

        $this->assertSame(['random' => ['key' => 'value']], $data);

        $this->assertTrue(Utils::deepCheck('random.key', $data));

        $this->assertSame(['key' => 'value'], Utils::deepRead('random', $data));

        Utils::deepDelete('random.key', $data);

        $this->assertSame(['random' => []], $data);

        $this->assertNull(Utils::deepRead('random.key', $data));
        $this->assertSame(Utils::deepRead('random', $data), []);

        $this->assertFalse(Utils::deepCheck('random.key', $data));
        $this->assertTrue(Utils::deepCheck('random', $data));
        $this->assertSame([], Utils::deepRead('random', $data));

        Utils::deepDelete('random', $data);
        $this->assertFalse(Utils::deepCheck('random', $data));

        $this->assertNull(Utils::deepRead('random', $data));
    }


}
