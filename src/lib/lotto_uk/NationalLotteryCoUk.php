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
        $hms =  $ql->find('.table_row_body .list_table')->htmls();
        $data = [];
        foreach ($hms as $html){
            $obj = (new \QL\QueryList)->html($html);
            $time =  $obj->find('.table_cell_first .table_cell_padding .table_cell_block')->text();
            $balls = $obj->find('.table_cell_3_width_no_raffle .table_cell_padding .table_cell_block')->text();
            $bonus = $obj->find('.table_cell_4_width_no_raffle .table_cell_padding .table_cell_block')->text();
            $res = explode('-', $balls);
            $result = [];
            foreach ($res as $item){
                $result[] = (string) intval(trim($item));
            }
            $result[] = (string) intval(trim($bonus));
            $data[] = [
                'date' => date('Ymd', strtotime($time)),
                'result' => $result,
            ];
        }
        return $data[0];

    }





}