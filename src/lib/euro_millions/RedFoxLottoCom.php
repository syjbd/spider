<?php
namespace dasher\spider\lib\euro_millions;
use dasher\spider\Helper;
use dasher\spider\lib\QuerySpider;

/**
 * @desc RedFoxLottoCom.php
 * @auhtor Wayne
 * @time 2023/11/22 15:15
 */

class RedFoxLottoCom extends QuerySpider {

    protected string $detailApiUrl = 'https://redfoxlotto.com/results/euromillions/<ts>';

    protected array $optionConfig = [
        'I'     => '1st',
        'II'    => '2nd',
        'III'   => '3rd',
        'IV'    => '4th',
        'V'     => '5th',
        'VI'    => '6th',
        'VII'   => '7th',
        'VIII'  => '8th',
        'IX'    => '9th',
        'X'     => '10th',
        'XI'    => '11th',
        'XII'   => '12th',
        'XIII'  => '13th',
    ];

    /**
     * @throws \Exception
     */
    public function getPageDetail(): array
    {
        $ql = $this->getHtml($this->detailApiUrl);
        $date = $ql->find("#lotteryPageTitle")->text();
        $result = $ql->find('.ticket-line div')->texts()->all();
        $date = str_replace('EuroMillions Results - ', '', $date);
        $options = $ql->find('.results-detailed-content tbody');
        $optionList =$options->find('tr')->map(function ($tr) {
            // 返回每个链接的文本和href属性
            return [
                'combinations' => str_replace('&nbsp;','',$tr->find('td:eq(0) .mobile-hide')->text()),
                'winnings' => $tr->find('td:eq(3) .table-results-detailed-amount')->text(),
                'winners' => $tr->find('td:eq(2) .table-results-detailed-winners')->text(),
            ];
        })->all();

        $options = AgentLottoCom::getOptions($this->optionConfig,$optionList,'€');

        return [
            'date'      => Helper::dateFormat($this->convertToTimestamp($date), 'Ymd', 'Europe/Berlin'),
            'result'    => $result,
            'symbol'    => "€",
            'options'   => $options
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