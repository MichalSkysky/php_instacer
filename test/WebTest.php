<?php

/**
 * Created by PhpStorm.
 * User: Jodminster
 * Date: 31.05.2016
 * Time: 20:15
 */
class WebTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected $coverageScriptUrl = 'http://localhost/ccc/ccc.php';

    public $url = 'http://localhost/php_instancer/';

    public $browser = 'firefox';

    public function setUp()
    {
        $this->setBrowser($this->browser);
        $this->setBrowserUrl($this->url);
    }

    public function testPage()
    {
        $this->url($this->url);
        $this->assertSame('TITLE', $this->title());
        $this->assertContains('Test', $this->byTag('body')->text());
    }
}
