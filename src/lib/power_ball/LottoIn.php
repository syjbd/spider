<?php
/**
 * @desc LottoIn.php
 * @auhtor Wayne
 * @time 2023/12/14 14:28
 */
namespace dasher\spider\lib\power_ball;

use dasher\spider\lib\QuerySpider;

class LottoIn extends QuerySpider
{

    protected string $detailApiUrl = 'https://www.lotto.in/powerball<ts>';

    public function getPageDetail(): array
    {

        $ql = $this->getHtml($this->detailApiUrl);
        $res = $ql->find('.latest .balls li.resultBall ')->texts()->all();
        $date = $ql->find('.latest .date')->text();
        $time = strtotime($date);
        return [
            'date'      => date('Ymd', $time),
            'result'    => $res,
        ];
    }

}