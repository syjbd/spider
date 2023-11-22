<?php
/**
 * @desc powerBallCom.php
 * @auhtor Wayne
 * @time 2023/11/6 14:37
 */
namespace dasher\spider\lib\power_ball;

use dasher\spider\exception\SpiderException;
use QL\QueryList;

class PowerBallCom{

    protected string $listApiUrl = 'https://www.powerball.com/previous-results';
    protected string $detailApiUrl = 'https://www.powerball.com/draw-result?gc=powerball&date={date}';


    protected function getHtml($url): QueryList
    {
        return QueryList::get($url);
    }


    /**
     * @throws SpiderException
     */
    public function getPageList(): array
    {
        $ql = $this->getHtml($this->listApiUrl);
        $titleArr =  $ql->find('h5')->texts()->all();

        $res =  $ql->find('.game-ball-group')->htmls()->all();
        if(count($titleArr) != count($res)) throw new SpiderException('result count err!',-100);
        $resultData = [];
        $i = 0;
        foreach ($res as $powerHtml){
            $obj = QueryList::html($powerHtml);
            $item['text'] = $titleArr[$i];
            $item['date'] = date('Ymd', strtotime($titleArr[$i]));
            $item['result'] = $obj->find('.item-powerball')->texts()->all();
            $resultData[] = $item;
            $i++;
        }
        return $resultData;
    }

    public function getPageDetail($date=""): array
    {
        if(!$date){
            $date = date('Y-m-d', time());
        }else{
            $date = date('Y-m-d', strtotime($date));
        }
        $url = str_replace('{date}', $date, $this->detailApiUrl);
        $ql = $this->getHtml($url);
        $res =  $ql->find('.game-ball-group .white-balls')->texts();
        $res[] = $ql->find('.game-ball-group .powerball')->text();
        return [
            'date'      => date('Ymd', strtotime($date)),
            'result'    => $res,
        ];
    }

    public function getResult($date=""): array
    {
        return $this->getPageDetail($date);
    }
}