<?php
/**
 * @desc Base Page Url : https://www.lotto.in/kerala-state-lotteries/results
 */

namespace dasher\spider\lib\kerala;

use dasher\spider\exception\SpiderException;
use dasher\spider\lib\QuerySpider;
use GuzzleHttp\Exception\GuzzleException;
use QL\QueryList;

class LottIn extends QuerySpider
{
    protected array $resultPageUrlMap = [
        1 => 'https://www.lotto.in/kerala-state-lotteries/win-win-results',
        2 => 'https://www.lotto.in/kerala-state-lotteries/sthree-sakthi-results',
        3 => 'https://www.lotto.in/kerala-state-lotteries/akshaya-results',
        4 => 'https://www.lotto.in/kerala-state-lotteries/karunya-results',
        5 => 'https://www.lotto.in/kerala-state-lotteries/karunya-plus-results',
        6 => 'https://www.lotto.in/kerala-state-lotteries/nirmal-lottery-results',
        7 => 'https://www.lotto.in/kerala-state-lotteries/fifty-fifty-results',
        8 => 'https://www.lotto.in/kerala-state-lotteries/xmas-new-year-bumper-results',
        9 => 'https://www.lotto.in/kerala-state-lotteries/summer-bumper-results',
        10 => 'https://www.lotto.in/kerala-state-lotteries/vishu-bumper-results',
        11 => 'https://www.lotto.in/kerala-state-lotteries/monsoon-results',
        12 => 'https://www.lotto.in/kerala-state-lotteries/onam-bumper-results',
        13 => 'https://www.lotto.in/kerala-state-lotteries/pooja-results',
    ];

    /**
     * @param int $type
     * @return string
     */
    private function getResultPageUrl(int $type): string
    {
        return $this->resultPageUrlMap[$type] ?? '';
    }

    /**
     * @param int $type
     * @param string $issueNo
     * @return array
     * @throws SpiderException
     */
    public function getResult(int $type, string $issueNo): array
    {
        $url = $this->getResultPageUrl($type);

        if ($url == '') {
            throw new SpiderException('LottIn unknown type err!');
        }

        try {
            $ql = $this->getHtml($url);
            $result = $this->parseHtmlData($ql, $issueNo);
        } catch (\Throwable $e) {
            throw new SpiderException('LottIn getResult err');
        }

        return $result;
    }

    /**
     * @param QueryList $ql
     * @param string $issueNo
     * @return array
     * @throws SpiderException
     */
    private function parseHtmlData(QueryList $ql, string $issueNo): array
    {
        $resultArr = [];
        $issueNo = strtoupper($issueNo);
        $targetTable = $ql->find('table.mobFormat caption:contains(' . $issueNo . ')')->parent("table");

        if ($targetTable->count() == 0) {
            $targetTable = $ql->find('table.mobFormat tfoot:contains(' . $issueNo . ')')->parent("table");
            if ($targetTable->count() == 0) {
                throw new SpiderException('LottIn parseHtmlData err!');
            }
        }

        $targetTable->find("tbody tr")
            ->map(function ($tr) use (&$resultArr) {
                $trHtml = $tr->html();
                $prizeTitle = trim((new QueryList)->html($trHtml)->find('td:eq(0)')->text());
                $ticketNumbers = (new QueryList)->html($trHtml)->find('td:eq(1)')->text();
                $prizeAmount = trim((new QueryList)->html($trHtml)->find('td:eq(2)')->text());
                $resultArr[] = [
                    'title' => $this->extractSpecificPrizeInfo($prizeTitle),
                    'numbers' => preg_replace('/\s|Ending|With:|\<br\>|\([^)]*\)/i', '', $ticketNumbers),
                    'amount' => $this->convertPrizeAmount($prizeAmount),
                ];
            });

        if (empty($resultArr)) {
            throw new SpiderException('LottIn parseOtherHtmlData err!');
        }

        return $resultArr;
    }

    /**
     * @param string $amountStr
     * @return string
     */
    private function convertPrizeAmount(string $amountStr): string
    {
        $amountStr = trim(str_replace(["/-", "₹", ","], "", $amountStr));
        return str_replace([" Lakh", "Lakh", " Crore", "Crore"], ["00000", "00000", "0000000", "0000000"], $amountStr);
    }

    /**
     * @param string $input
     * @return string
     */
    private function extractSpecificPrizeInfo(string $input): string
    {
        // 正则表达式，匹配数字或者 "Consolation"
        $pattern = '/(\d+)|(Consolation)(?=\s*Prize)/';
        preg_match($pattern, $input, $matches);

        if (!empty($matches[1])) {
            return trim($matches[1]);
        } elseif (!empty($matches[2])) {
            return trim($matches[2]);
        }

        return '';
    }
}