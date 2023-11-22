<?php
namespace dasher\spider\lib\mega_millions;
use dasher\spider\Helper;
use QL\QueryList;

/**
 * @desc RedFoxLottoCom.php
 * @auhtor Wayne
 * @time 2023/11/22 15:15
 */

class RedFoxLottoCom{

    protected string $detailApiUrl = 'https://redfoxlotto.com/results/mega-millions/';


    protected function getHtml($url): QueryList
    {
        return QueryList::get($url);
    }

    /**
     * @throws \Exception
     */
    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->detailApiUrl);
        $date = $ql->find("#lotteryPageTitle")->text();
        $result = $ql->find('.ticket-line div')->texts()->all();
        $date = str_replace('Mega Millions Results - ', '', $date);
        return [
            'date'      => Helper::dateFormat($this->convertToTimestamp($date),'Ymd'),
            'result'    => $result,
        ];
    }

    public function convertToTimestamp($str): int
    {
        $str = str_replace(' at ', ' ', $str);
        $str = str_replace(' e', ' T', $str);
        $date = \DateTime::createFromFormat('F d, Y g:i:s A T', $str);
        return $date->getTimestamp();
    }
}