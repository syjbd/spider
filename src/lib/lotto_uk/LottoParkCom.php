<?php
/**
 * @desc LottoparkCom.php
 * @auhtor Wayne
 * @time 2023/11/22 12:46
 */
namespace dasher\spider\lib\lotto_uk;

use dasher\spider\Helper;
use QL\QueryList;

class LottoParkCom{

    protected string $detailApiUrl = 'https://lottopark.com/results/lotto-uk/';


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
        $res =  $ql->find('.ticket-line .ticket-line-number')->texts()->all();
        $res[] = $ql->find('.ticket-line .ticket-line-bnumber')->text();
        $dateText = $ql->find('#lotteryPageTitle')->text();
        $arr = explode('-', $dateText);
        $date = trim($arr[1]);
        $time = $this->convertToTimestamp($date);
        return [
            'date'      => Helper::dateFormat($time, 'Ymd', 'Europe/Lisbon'),
            'result'    => $res,
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