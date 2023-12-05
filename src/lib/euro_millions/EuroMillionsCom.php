<?php
/**
 * @desc EuroMillionsCom.php
 * @auhtor Wayne
 * @time 2023/11/22 14:30
 */
namespace dasher\spider\lib\euro_millions;

use dasher\spider\lib\QuerySpider;

class EuroMillionsCom extends QuerySpider {

    protected string $detailApiUrl = 'https://www.euro-millions.com/results';

    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->detailApiUrl);
        $html = $ql->find('.wrapSM .box:eq(0)')->html();
        $obj = (new \QL\QueryList)->html($html);
        $date = $obj->find(".h2 span:eq(1)")->text();
        $result = $obj->find('.balls li')->texts()->all();
        if($result[0] == '-'){
            $html = $ql->find('.wrapSM .box:eq(1)')->html();
            $obj = (new \QL\QueryList)->html($html);
            $date = $obj->find(".h2 span:eq(1)")->text();
            $result = $obj->find('.balls li')->texts()->all();
        }
        $date = str_replace('- ', '', $date);
        $date = str_replace('st', '', $date);
        return [
            'date'      => date('Ymd', strtotime($date)),
            'result'    => $result,
        ];
    }
}