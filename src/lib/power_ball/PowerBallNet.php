<?php
/**
 * @desc PowerBallNet.php
 * @auhtor Wayne
 * @time 2023/11/6 17:10
 */
namespace dasher\spider\lib\power_ball;

use dasher\spider\lib\QuerySpider;
use QL\QueryList;

class PowerBallNet extends QuerySpider {

    protected string $listApiUrl = 'https://www.powerball.net/numbers/';
    protected string $detailApiUrl = 'https://www.powerball.net/numbers/{date}';
    protected string $indexUrl = 'https://www.powerball.net/';

    protected function getHtml($url): QueryList
    {
        return (new \QL\QueryList)->get($url);
    }

    public function getPageList(): array
    {
        $ql = $this->getHtml($this->listApiUrl);
        $res =  $ql->find('.marginBottomMed')->htmls()->all();
        $resultData = [];
        $rules = [
            'title' => ['.date','text'],
            'html' => ['ul','html'],
        ];
        foreach ($res as $powerHtml){
            $obj = QueryList::html($powerHtml);
            $item = $obj->rules($rules)->query()->getData();
            $result = $obj->find('.ball')->texts()->all();
            $result = array_slice($result,0,5);
            $bigResult = $obj->find('.powerball')->texts();
            $result[] = $bigResult[0];
            $resultData[] = [
                'text' => $item['title'],
                'date' =>  date('Ymd', strtotime($item['title'])),
                'result' => $result,
            ];
        }
        return $resultData;
    }

    public function getPageDetailResult($date): array
    {
        if(!$date){
            $date = date('Y-m-d', time());
        }else{
            $date = date('Y-m-d', strtotime($date));
        }
        $url = str_replace('{date}', $date, $this->detailApiUrl);
        $ql = $this->getHtml($url);
        $res =  $ql->find('#ballsAscending .balls .ball')->texts();
        $res[] = $ql->find('#ballsAscending .balls .powerball')->text();
        $payoutTableHtml = $ql->find('.payoutTable')->htmls();
        $payout = [];
        foreach ($payoutTableHtml as $key => $html){
            $trList = QueryList::html($html)->find('tbody tr')->htmls();
            $payout[$key] = [];
            foreach ($trList as $item){
                $val['name'] =  QueryList::html($item)->find('.PrizeName')->text();
                $val['Prize'] =  QueryList::html($item)->find('.right')->text();
                $payout[$key] = $val;
            }
        }

        return [
            'date'      => date('Ymd', strtotime($date)),
            'result'    => $res,
            'payout'    => $payout
        ];
    }

    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->indexUrl);
        $dateText = $ql->find('.jackpotMain .date')->text();
        $balls = $ql->find('.jackpotMain ul:eq(0) .ball')->texts()->all();
        $balls[] = $ql->find('.jackpotMain ul:eq(0) .powerball')->text();
        $balls[] = $ql->find('.jackpotMain ul:eq(0) .power-play')->text();
        return [
            'date'      => date('Ymd', strtotime($dateText)),
            'result'    => $balls,
        ];
    }
}