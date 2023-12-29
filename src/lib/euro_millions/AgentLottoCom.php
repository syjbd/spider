<?php
/**
 * @desc AgentLottoCom.php
 * @auhtor Wayne
 * @time 2023/11/22 14:08
 */
namespace dasher\spider\lib\euro_millions;
use dasher\spider\Helper;
use dasher\spider\lib\QuerySpider;

class AgentLottoCom extends QuerySpider {
    protected string $detailApiUrl = 'https://www.agentlotto.com/en/results/euromillions/';
    protected string $listApiUrl = 'https://www.agentlotto.com/en/results/euromillions/?&month={month}&year={year}';

    protected array $optionConfig = [
        '5+2PB' => '1st',
        '5+1PB' => '2nd',
        '5+0PB' => '3rd',
        '4+2PB' => '4th',
        '4+1PB' => '5th',
        '3+2PB' => '6th',
        '4+0PB' => '7th',
        '2+2PB' => '8th',
        '3+1PB' => '9th',
        '3+0PB' => '10th',
        '1+2PB' => '11th',
        '2+1PB' => '12th',
        '2+0PB' => '13th',
    ];

    public function getPageDetail(): array
    {

        $ql = $this->getHtml($this->detailApiUrl);
        $res = $ql->find('.results_item_mid .numberList li span')->texts()->all();
        $dateText = $ql->find('.lott_info .lott_data')->text();
        $options = $ql->find('.detailed_table:eq(0) tbody');
        $optionList =$options->find('tr:not(.detailed_table_tot)')->map(function ($tr) {
            // 返回每个链接的文本和href属性
            return [
                'combinations' => $tr->find('td:eq(0)')->text(),
                'winnings' => $tr->find('td:eq(1)')->text(),
                'winners' => $tr->find('td:eq(2)')->text(),
            ];
        })->all();
        $date =str_replace('Draw Date ', '', $dateText);
        $time = strtotime($date);
        return [
            'date'      => date('Ymd', $time),
            'result'    => $res,
            'symbol'    => "$",
            'options'   => self::getOptions($this->optionConfig,$optionList)
        ];
    }

    public function getMonths($month=0): array
    {
        $months = [];
        if ($month == 0){
            for ($i=1; $i<=12;$i++){
                $months[] = (string)$i;
            }
        }else{
            $months[] = $month;
        }
        return $months;
    }

    public function loadListResult($year,$month): array
    {
        $url = str_replace('{year}', $year, $this->listApiUrl);
        $url = str_replace('{month}', $month, $url);
        $ql = $this->getHtml($url);
        $data = [];
        $res = $ql->find('.oldresults_tbody .oldresults_item .oldresults_item_head')->htmls();
        foreach ($res as $html){
            $obj = (new \QL\QueryList)->html($html);
            $date = $obj->find('.oldresults_td1')->text();
            $result = $obj->find('.oldresults_td3 .results_item_cont .numberList li')->texts()->all();
            $result[array_key_last($result)] = str_replace('x','',$result[array_key_last($result)]);
            $data[] = [
                'date'      => date('Ymd', strtotime($date)),
                'result'    => $result,
            ];
        }
        return $data;
    }

    public function getPageList($page=0, $month=0): array
    {
        $year = date('Y') - $page;
        $months = $this->getMonths($month);
        $data = [];
        foreach ($months as $month){
            $res = $this->loadListResult($year, $month);
            $data = array_merge($data, $res);
        }
        return $data;
    }

    public static function getOptions($optionConfig, $options, $symbol="$"): array
    {
        $data = [];
        foreach ($options as $option){
            $option['option']       = $optionConfig[$option['combinations']];
            $option['winnings']     = floatval(str_replace([$symbol,','], '', $option['winnings']));
            $data[] = $option;
        }
        return $data;
    }
}