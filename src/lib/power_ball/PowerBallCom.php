<?php
/**
 * @desc powerBallCom.php
 * @auhtor Wayne
 * @time 2023/11/6 14:37
 */
namespace dasher\spider\lib\power_ball;

use dasher\spider\exception\SpiderException;
use dasher\spider\lib\QuerySpider;
use QL\QueryList;

class PowerBallCom extends QuerySpider {

    protected string $listApiUrl = 'https://www.powerball.com/previous-results';
    protected string $detailApiUrl = 'https://www.powerball.com/draw-result?gc=powerball&date={date}';
    protected string $indexUrl = 'https://www.powerball.com/';


    /**
     * @throws SpiderException
     */
    public function getPageList($proxy=""): array
    {
        $ql = $this->setProxy($proxy)->getHtml($this->listApiUrl);
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

    public function getPageDetailResult($date="",$proxy=""): array
    {
        if(!$date){
            $date = date('Y-m-d', time());
        }else{
            $date = date('Y-m-d', strtotime($date));
        }
        $url = str_replace('{date}', $date, $this->detailApiUrl);
        $ql = $this->setProxy($proxy)->getHtml($url);
        $res =  $ql->find('.game-ball-group .white-balls')->texts();
        $res[] = $ql->find('.game-ball-group .powerball')->text();
        return [
            'date'      => date('Ymd', strtotime($date)),
            'result'    => $res,
        ];
    }

    public function getPageDetail($proxy=""): array
    {
        $ql = $this->setProxy($proxy)->getHtml($this->indexUrl);
        $dateText = $ql->find('#numbers .number-powerball .card-body h5')->text();
        $balls = $ql->find('#numbers .number-powerball .card-body .game-ball-group .item-powerball')->texts()->all();
        $play = $ql->find('#numbers .number-powerball .card-body .power-play .multiplier')->text();
        $balls[] = str_replace('x','', $play);
        return [
            'date'      => date('Ymd', strtotime($dateText)),
            'result'    => $balls,
        ];
    }

}