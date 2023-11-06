<?php
/**
 * @desc powerBallCom.php
 * @auhtor Wayne
 * @time 2023/11/6 14:37
 */
namespace dasher\spider\lib;

use dasher\payment\exception\SpiderException;
use QL\QueryList;

class PowerBallCom{

    protected $listApiUrl = 'https://www.powerball.com/previous-results';
    protected $detailApiUrl = 'https://www.powerball.com/draw-result?gc=powerball&date={date}';


    protected function getHtml($url){
        return QueryList::get($url);
    }


    /**
     * @throws SpiderException
     */
    public function getPageList(){
        $ql = $this->getHtml($this->listApiUrl);
        $titleArr =  $ql->find('h5')->texts()->all();

        $res =  $ql->find('.game-ball-group')->htmls()->all();
        if(count($titleArr) != count($res)) throw new SpiderException('result count err!',-100);
        $resultData = [];
        $i = 0;
        foreach ($res as $powerHtml){
            $obj = QueryList::html($powerHtml);
            $item['result'] = $obj->find('.item-powerball')->texts()->all();
            $item['text'] = $titleArr[$i];
            $item['date'] = date('Ymd', strtotime($titleArr[$i]));
            $resultData[] = $item;
            $i++;
        }
        return $resultData;
    }
}