<?php
/**
 * @desc AgentLottoCom.php
 * @auhtor Wayne
 * @time 2023/11/22 14:08
 */
namespace dasher\spider\lib\mega_millions;

use QL\QueryList;

class AgentLottoCom{
    protected string $detailApiUrl = 'https://www.agentlotto.com/en/results/mega-millions/';


    protected function getHtml($url): QueryList
    {
        return QueryList::get($url);
    }

    public function getPageDetail(): array
    {

        $ql = $this->getHtml($this->detailApiUrl);
        $res = $ql->find('.results_item_mid .numberList li span')->texts()->all();
        $res[array_key_last($res)] = str_replace('x','',$res[array_key_last($res)]);
        $dateText = $ql->find('.lott_info .lott_data')->text();
        $date = str_replace('Draw Date ', '', $dateText);
        $time = strtotime($date);
        return [
            'date'      => date('Ymd', $time),
            'result'    => $res,
        ];
    }

}