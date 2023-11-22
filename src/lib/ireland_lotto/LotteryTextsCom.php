<?php
/**
 * @desc MagayoCom.php
 * @auhtor Wayne
 * @time 2023/11/22 15:42
 */
namespace dasher\spider\lib\ireland_lotto;

use QL\QueryList;

class LotteryTextsCom{

    protected string $detailApiUrl = 'https://lotterytexts.com/ireland/lotto/';


    protected function getHtml($url): QueryList
    {
        return QueryList::get($url);
    }

    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->detailApiUrl);
        $html = $ql->find('.elementor-section .elementor-column-gap-default .elementor-col-100 .elementor-element-populated .elementor-widget-container .elementor-shortcode:eq(0)')->html();
        $obj = (new \QL\QueryList)->html($html);
        $dateText = $obj->find('.lottery-logo .container .custom-row2 .col-md-4 .lottery-detail .lottery-detail-inner .lottery-date span')->text();
        $result = $obj->find('.lottery-logo .container .custom-row2 .lottery-balls-below .lottery-balls li')->texts()->all();
        return [
            'date'      => date('Ymd',strtotime($dateText)),
            'result'    => $result,
        ];
    }




}