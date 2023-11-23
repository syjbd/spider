<?php
/**
 * @desc MagayoCom.php
 * @auhtor Wayne
 * @time 2023/11/22 15:42
 */
namespace dasher\spider\lib\ireland_lotto;

use QL\QueryList;

class MagaYoCom{

    protected string $detailApiUrl = 'https://www.magayo.com/lotto/ireland/lotto-results/';


    protected function getHtml($url): QueryList
    {
        return QueryList::get($url);
    }

    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->detailApiUrl);
        $dateText = $ql->find('.container .mt-3 .col-lg h5')->text();
        $result= $ql->find('.container .mt-3 .col-lg p:eq(0) img')->attrs('src')->all();
        $result[] = $ql->find('.container .mt-3 .col-lg p:eq(1) img')->attr('src');
        $data = [];
        foreach ($result as $item){
            $vo = parse_url($item);
            parse_str($vo['query'], $queryArr);
            $data[] = (string)intval($queryArr['p2']);
        }
        $date = trim(explode('(', $dateText)[0]);
        return [
            'date'      => date('Ymd',strtotime($date)),
            'result'    => $data,
        ];
    }




}