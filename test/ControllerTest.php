<?php

/**
 * @codeCoverageIgnore
 */
class ControllerTest extends PHPUnit_Framework_TestCase {

    function dataGetShortName() {
        return [
            ['Test'],
            ['Minsk'],
            ['Wurst'],
        ];
    }

    /**
     * @dataProvider dataGetShortName
     */
    public function testGetShortName($name) {
        /** @var Controller $controller */
        $controller = $this->getMockForAbstractClass('Controller', [], $name.'Controller', false);

        $this->assertSame($name, $controller->getShortName());
    }
}
