<?php

class Html_TagTest extends PHPUnit_Framework_TestCase
{
    function testRender()
    {
        $this->assertSame('<head test="asd"><meta charset="UTF-8"></head>', (new Html_Tag('head'))
            ->addAttribute(new Html_Attribute('test', 'asd'))
            ->addChild((new Html_Tag('meta'))
                ->addAttribute(new Html_Attribute('charset', 'UTF-8'))
            )
            ->render()
        );
    }
}
