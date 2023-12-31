<?php
/**
 * @desc AgentLottoCom.php
 * @auhtor Wayne
 * @time 2023/11/22 14:08
 */
namespace dasher\spider\lib\ireland_lotto;

class AgentLottoCom extends \dasher\spider\lib\power_ball\AgentLottoCom {

    protected string $detailApiUrl = 'https://www.agentlotto.com/en/results/lotto-ie/<ts>';
    protected string $listApiUrl = 'https://www.agentlotto.com/en/results/lotto-ie/?&month={month}&year={year}';


//    protected function getHtml($url): QueryList
//    {
//        return QueryList::get($url);
//    }
//
//    public function getPageDetail(): array
//    {
//
//        $ql = $this->getHtml($this->detailApiUrl);
//        $res = $ql->find('.results_item_mid .numberList li span')->texts()->all();
//        $dateText = $ql->find('.lott_info .lott_data')->text();
//        $date =str_replace('Draw Date ', '', $dateText);
//        $time = strtotime($date);
//        return [
//            'date'      => date('Ymd', $time),
//            'result'    => $res,
//        ];
//    }

}