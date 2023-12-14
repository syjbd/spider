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

    ];

    protected array $headers = [
        'Cache-Control' => 'no-store',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
    ];

    public function setConfig($config): QuerySpider
    {
        if(!empty($config))  $this->config = array_merge($this->config, $config);
        return $this;
    }

    public function setHeaders($headers=[]): QuerySpider
    {
        if(!$headers) $this->headers = $headers;
        return $this;
    }

    /**
     * @throws GuzzleException
     */
    protected function getHtml($url): QueryList
    {
        $client = new Client();
        if($this->headers){
            $this->config['headers'] = $this->headers;
        }
        if(strstr($url, '<ts>')){
            $t = microtime();
            $url = str_replace('<ts>', "?ts={$t}", $url);
        }
        $res = $client->request('GET', $url, $this->config)->getBody();
        return  (new \QL\QueryList)->html($res);
    }
}