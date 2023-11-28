<?php
/**
 * @desc EuroMillionsCom.php
 * @auhtor Wayne
 * @time 2023/11/22 14:30
 */
namespace dasher\spider\lib\euro_millions;

use QL\QueryList;

class EuroMillionsCom{

    protected string $detailApiUrl = 'https://www.euro-millions.com/results';


    protected function getHtml($url): QueryList
    {
        return QueryList::get($url);
    }

    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->detailApiUrl);
        $html = $ql->find('.wrapSM .box:eq(0)')->html();
        $obj = (new \QL\QueryList)->html($html);
        $date = $obj->find(".h2 span:eq(1)")->text();
        $result = $obj->find('.balls li')->texts()->all();
        $date = str_replace('- ', '', $date);
        $date = str_replace('st', '', $date);
        return [
            'date'      => date('Ymd', strtotime($date)),
            'result'    => $result,
        ];
    }
}