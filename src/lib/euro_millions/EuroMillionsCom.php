<?php
/**
 * @desc EuroMillionsCom.php
 * @auhtor Wayne
 * @time 2023/11/22 14:30
 */
namespace dasher\spider\lib\euro_millions;

use dasher\spider\exception\SpiderException;
use dasher\spider\lib\QuerySpider;
use QL\QueryList;

class EuroMillionsCom extends QuerySpider {

    protected string $detailApiUrl = 'https://www.euro-millions.com/results';


    protected array $optionConfig = [
        '5+2'   => '1st',
        '5+1'   => '2nd',
        '5'     => '3rd',
        '4+2'   => '4th',
        '4+1'   => '5th',
        '3+2'   => '6th',
        '4'     => '7th',
        '2+2'   => '8th',
        '3+1'   => '9th',
        '3'     => '10th',
        '1+2'   => '11th',
        '2+1'   => '12th',
        '2'     => '13th',
    ];

    public function getPageOption($date)
    {
        $url = 'https://www.euro-millions.com/results/' . date('d-m-Y', strtotime($date));
        $ql = parent::getHtml($url);
        $options = $ql->find('#PrizeTotals .mobFormat:eq(0) tbody');
        $optionList =$options->find('tr:not(.totals)')->map(function ($tr) {
            // 返回每个链接的文本和href属性
            return [
                'combinations' => str_replace(' ','', $tr->find('td:eq(0)')->text()),
                'winnings' => str_replace(' ','', $tr->find('td:eq(1)')->text()),
                'winners' => $tr->find('td:eq(2)')->text(),
            ];
        })->all();
        return $optionList;
    }

    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->detailApiUrl);
        $html = $ql->find('.wrapSM .box:eq(0)')->html();
        $obj = (new \QL\QueryList)->html($html);
        $date = $obj->find(".h2 span:eq(1)")->text();
        $result = $obj->find('.balls li')->texts()->all();
        if(empty($result[0])) throw new SpiderException('EuroMillionsCom can\'t get result');
        if($result[0] == '-'){
            $html = $ql->find('.wrapSM .box:eq(1)')->html();
            $obj = (new \QL\QueryList)->html($html);
            $date = $obj->find(".h2 span:eq(1)")->text();
            $result = $obj->find('.balls li')->texts()->all();
        }
        $date = str_replace('- ', '', $date);
        $date = str_replace('st', '', $date);
        $options = $this->getPageOption($date);
        return [
            'date'      => date('Ymd', strtotime($date)),
            'result'    => $result,
            'symbol'    => "€",
            'options'   => $options
        ];
    }
}