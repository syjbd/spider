<?php
/**
 * @desc QueryListTest.php
 * @auhtor Wayne
 * @time 2023/12/5 11:30
 */

use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use QL\QueryList;

class QueryListTest extends TestCase
{

    public function testProxy(){
        $url = "https://httpbin.org/ip";
        $proxies = 'https://20.111.54.16:8123';
        $proxies = "socks5://192.111.137.34:18765";
        $client = new \GuzzleHttp\Client([
                RequestOptions::PROXY => $proxies,
                RequestOptions::VERIFY => false, # disable SSL certificate validation
                RequestOptions::TIMEOUT => 30, # timeout of 30 seconds
            ]);
        $html = $client->get($url)->getBody()->getContents();
        var_dump((string)$html);
        var_dump(QueryList::get($url,null, ['proxy'=>$proxies])->getHtml());
//
//        $proxy = 'tcp://localhost:8125'; // 替换为你的代理服务器地址
//        $client = new Client([
//            'proxy' => $proxy,
//        ]);
//        $response = $client->request('GET', 'http://httpbin.org/get');
    }

}