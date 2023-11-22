<?php
/**
 * @desc LottoparkCom.php
 * @auhtor Wayne
 * @time 2023/11/22 10:46
 */
namespace dasher\spider\lib\lotto_uk;

use QL\QueryList;

class NationalLotteryCoUk{

    protected string $apiUrl = 'https://www.national-lottery.co.uk/results/lotto/draw-history';


    protected function getHtml($url): QueryList
    {
        return QueryList::get($url);
    }

    public function getPageDetail(): array
    {

        $ql = $this->getHtml($this->apiUrl);
        $time =  $ql->find('.table_row_odd:eq(0) .table_cell_first .table_cell_padding .table_cell_block')->text();
        $balls = $ql->find('.table_row_odd:eq(0) .table_cell_3_width_no_raffle .table_cell_padding .table_cell_block')->text();
        $bonus = $ql->find('.table_row_odd:eq(0) .table_cell_4_width_no_raffle .table_cell_padding .table_cell_block')->text();
        $res = explode('-', $balls);
        foreach ($res as $item){
            $result[] = (string) intval(trim($item));
        }
        $result[] = (string) intval(trim($bonus));
        return [
            'date' => date('Ymd', strtotime($time)),
            'result' => $result,
        ];

    }





}