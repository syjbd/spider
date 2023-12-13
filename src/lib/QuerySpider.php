<?php
/**
 * @desc QuerySpider.php
 * @auhtor Wayne
 * @time 2023/12/5 14:43
 */
namespace dasher\spider\lib;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use QL\QueryList;

class QuerySpider{

    protected array $config = [
        'verify' => false,
        'http_errors' => false,
        'timeout' => 30,
        'headers' =>[
            'Cache-Control' => 'no-cache',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ]
    ];

    public function setConfig($config): QuerySpider
    {
        $this->config = array_merge($this->config, $config);
        return $this;
    }

    /**
     * @throws GuzzleException
     */
    protected function getHtml($url): QueryList
    {
        $client = new Client();
        $res = $client->request('GET', $url, $this->config)->getBody();
        return  (new \QL\QueryList)->html($res);
    }
}