<?php
/**
 * @desc AgentLottoCom.php
 * @auhtor Wayne
 * @time 2023/11/22 14:08
 */
namespace dasher\spider\lib\euro_millions;
use dasher\spider\lib\QuerySpider;

class AgentLottoCom extends QuerySpider {
    protected string $detailApiUrl = 'https://www.agentlotto.com/en/results/euromillions/';
    protected string $listApiUrl = 'https://www.agentlotto.com/en/results/euromillions/?&month={month}&year={year}';

    public function getPageDetail(): array
    {

        $ql = $this->getHtml($this->detailApiUrl);
        $res = $ql->find('.results_item_mid .numberList li span')->texts()->all();
        $dateText = $ql->find('.lott_info .lott_data')->text();
        $date =str_replace('Draw Date ', '', $dateText);
        $time = strtotime($date);
        return [
            'date'      => date('Ymd', $time),
            'result'    => $res,
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
        var_dump($url);
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

}