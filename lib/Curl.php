<?php

class Curl
{
    protected $_url;

    protected $_randomUserAgent = true;

    protected $_randomIp = true;

    protected $_delay = false;

    static $timeout = 0;

    protected static $_userAgents = [
        'firefox' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1',
        'safari' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A',
        'chrome' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
        // 'opera' => 'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16',
        // 'msie' => 'Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko',
    ];

    public $options = [
        CURLOPT_ENCODING => '',
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_AUTOREFERER => true
    ];

    public function __construct($url = null, $options = [])
    {
        $this->_url = ltrim($url, '/ ');
        $this->options = $options + $this->options;
    }

    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    public function exec()
    {
        $ch = curl_init($this->_url);

        if ($this->_randomUserAgent) {
            $this->setOption(CURLOPT_USERAGENT, self::$_userAgents[array_rand(self::$_userAgents)]);
        }

        if ($this->_randomIp) {
            $ip = rand(1, 254) . '.' . rand(1, 254) . '.' . rand(1, 254) . '.' . rand(1, 254);
            $this->setOption(CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
        }

        foreach ($this->options as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        if ($this->_delay) {
            time() == self::$timeout && sleep(.1);
        }

        $result = curl_exec($ch);
        self::$timeout = time();

        curl_close($ch);

        return isset($this->options[CURLOPT_BINARYTRANSFER]) && $this->options[CURLOPT_BINARYTRANSFER] ? $result : utf8_encode($result);
    }

    function __toString()
    {
        return $this->exec();
    }


}
