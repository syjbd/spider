<?php
/**
 * @desc PowerBallNet.php
 * @auhtor Wayne
 * @time 2023/11/6 17:10
 */
namespace dasher\spider\lib;

use dasher\payment\exception\SpiderException;
use QL\QueryList;

class PowerBallNet{

    protected $listApiUrl = 'https://www.powerball.net/numbers/';
    protected $detailApiUrl = 'https://www.powerball.net/numbers/{date}';

    protected function getHtml($url){
        return QueryList::get($url);
    }

    public function getPageList(){
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
}