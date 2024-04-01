<?php
/**
 * @desc Official.php
 * @auhtor Wayne
 * @time 2024/3/21 9:45
 */
namespace dasher\spider\lib\phl;
use dasher\spider\exception\SpiderException;
use dasher\spider\Helper;
use dasher\spider\lib\QuerySpider;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Official extends QuerySpider {

    protected string $todayUrl = "https://elotto.pcso.gov.ph/lgw/pl/numeros/today_games?_=<t>";
    protected string $historyUrl = 'https://elotto.pcso.gov.ph/lgw/pl/draw/win_order_prize_summaries?gameCode=<gameCode>&startTime=<startTime>&endTime=<endTime>&page=<page>&size=<size>&_=<t>';
    protected string $gameUrl = "https://elotto.pcso.gov.ph/lgw/pl/numeros/near?gameId=<gameId>";
    protected string $futureUlr = "https://elotto.pcso.gov.ph/lgw/pl/numeros/recent?gameId=<gameId>&count=<count>";

    public function getContent($url){

        $options = [
            RequestOptions::VERIFY => false, # disable SSL certificate validation
            RequestOptions::TIMEOUT => 30, # timeout of 30 seconds
            RequestOptions::HEADERS => [
               'authority' => 'elotto.pcso.gov.ph',
                'accept' => 'application/json, text/plain, */*',
                'accept-language' => 'zh-CN,zh;q=0.9,en;q=0.8,zh-TW;q=0.7,pt;q=0.6',
                'language' => 'EN',
                'merchant' => 'pcsoelotto',
                'referer' => 'https://elotto.pcso.gov.ph/web/',
                'sec-ch-ua' => 'Chromium";v="122", "Not(A:Brand";v="24", "Google Chrome";v="122"',
                'sec-ch-ua-mobile' => '?0',
                'sec-ch-ua-platform' => 'Windows',
                'sec-fetch-dest' => 'empty',
                'sec-fetch-mode' => 'cors',
                'sec-fetch-site' => 'same-origin',
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'x-gateway-version' => '509',
            ]
        ];
        if(!empty($this->proxy)) $options[RequestOptions::PROXY] = $this->proxy;
        $client= new Client($options);
        $response = $client->get($url);
        if($response->getStatusCode() == 200) {
            $content = (string)$response->getBody();
            return json_decode($content, true);
        }else{
            throw new SpiderException('Phl lotto GuzzleHttp err!');
        }
    }

    /**
     * @throws SpiderException
     */
    public function getGameContent($id){
        $url = str_replace('<gameId>', $id, $this->gameUrl);
        return $this->getContent($url);
    }

    /**
     * @throws SpiderException
     */
    public function getTodayContent(){
        $url = str_replace('<t>', Helper::currentTimeMillis(), $this->todayUrl);
        return $this->getContent($url);
    }

    /**
     * @throws SpiderException
     */
    public function getHistoryContent($data){
        $t = Helper::currentTimeMillis();
        $startTime  = !empty($data['start_time']) ? $data['start_time'] : strtotime(date('Ymd', time()-86400*7)) * 1000;
        $endTime    = !empty($data['end_time']) ? $data['end_time'] : strtotime(date('Ymd', time()+86400)) * 1000 -1;
        $page       = !empty($data['page']) ? $data['page'] : 0;
        $size       = !empty($data['size']) ? $data['size'] : 5;
        $gameCode   = !empty($data['game_code']) ? $data['game_code'] : 'all';
        $url = str_replace(['<startTime>','<endTime>','<page>','<size>','<gameCode>','<t>'], [$startTime,$endTime,$page,$size,$gameCode,$t], $this->historyUrl);
        return $this->getContent($url);
    }

    public function getFutureContent($data){
        $gameId = !empty($data['game_id']) ? $data['game_id'] : 38111;
        $count = !empty($data['count']) ? $data['count'] : 100;
        $url = str_replace(['<gameId>','<count>'], [$gameId,$count], $this->futureUlr);
        return $this->getContent($url);
    }

}