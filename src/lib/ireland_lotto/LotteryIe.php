<?php
/**
 * @desc IrelanIe.php
 * @auhtor Wayne
 * @time 2023/12/29 18:14
 */
namespace dasher\spider\lib\ireland_lotto;

use dasher\spider\lib\euro_millions\AgentLottoCom;
use dasher\spider\lib\QuerySpider;

class LotteryIe extends QuerySpider{

    //https://dev-front-api.02uhp.xyz/1.html
    protected string $detailApiUrl = 'https://www.lottery.ie/results/lotto/history';

    protected array $optionConfig = [
        'Jackpot'       => '1st',
        'Match5+Bonus'  => '2nd',
        'Match5'        => '3rd',
        'Match4+Bonus'  => '4th',
        'Match4'        => '5th',
        'Match3+Bonus'  => '6th',
        'Match3'        => '7th',
        'Match2+Bonus'  => '8th',
    ];

    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->detailApiUrl);
        $dateText = $ql->find('h2:eq(0)')->text();
        $result= $ql->find('.bg-results-gradient .relative .gap-4 .flex-col .space-y-4:eq(0) .flex-wrap .rounded-full')->texts();
        $result[] = $ql->find('.bg-results-gradient .relative .gap-4 .flex-col .space-y-4:eq(1)')->text();

        $optionDom = $ql->find('table:eq(0) thead');
        $options = $optionDom->find('tr:not(.text-sm)')->map(function ($tr) {
            // 返回每个链接的文本和href属性
            return [
                'combinations' => str_replace(' ','', $tr->find('td:eq(0)')->text()),
                'winnings' => str_replace(' ','', $tr->find('td:eq(2)')->text()),
                'winners' => $tr->find('td:eq(1)')->text(),
            ];
        })->all();

        $time = strtotime(\DateTime::createFromFormat('d/m/y',explode(' ',$dateText)[1])->format('Y-m-d'));
        return [
            'date'      => date('Ymd', $time),
            'result'    => $result,
            'symbol'    => "€",
            'options'   => AgentLottoCom::getOptions($this->optionConfig, $options, '€')
        ];
    }

}