<?php
/**
 * @desc MagayoCom.php
 * @auhtor Wayne
 * @time 2023/11/22 15:42
 */
namespace dasher\spider\lib\mega_millions;

use dasher\spider\lib\QuerySpider;

class MagaYoCom extends QuerySpider {

    protected string $detailApiUrl = 'https://www.magayo.com/lotto/usa/mega-millions-results/<ts>';

    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->detailApiUrl);
        $dateText = $ql->find('.container .mt-3 .col-lg h5')->text();
        $result= $ql->find('.container .mt-3 .col-lg p:eq(0) img')->attrs('src')->all();
        $result[] = $ql->find('.container .mt-3 .col-lg p:eq(1) img')->attr('src');
        $play = $ql->find('.container .mt-3 .col-lg p:eq(2)')->text();
        $data = [];
        foreach ($result as $item){
            $vo = parse_url($item);
            parse_str($vo['query'], $queryArr);
            $data[] = (string)intval($queryArr['p2']);
        }
        preg_match('/\d+/', $play,$match);
        $play = $match[0];
        $data[] = (string)intval($play);
        $date = trim(explode('(', $dateText)[0]);
        return [
            'date'      => date('Ymd',strtotime($date)),
            'result'    => $data,
        ];
    }




}