<?php
/**
 * @desc PowerBallNet.php
 * @auhtor Wayne
 * @time 2023/11/6 17:10
 */
namespace dasher\spider\lib\power_ball;

use QL\QueryList;

class PowerBallNet{

    protected string $listApiUrl = 'https://www.powerball.net/numbers/';
    protected string $detailApiUrl = 'https://www.powerball.net/numbers/{date}';

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

    public function getPageDetail($date): array
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
        return [
            'date'      => date('Ymd', strtotime($date)),
            'result'    => $res,
        ];
    }

    public function getResult($date): array
    {
        return $this->getPageDetail($date);
    }
}