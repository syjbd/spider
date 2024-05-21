<?php
/**
 * @desc Sarkariresultsinfo.php
 * @auhtor Wayne
 * @time 2024/5/21 16:25
 */
namespace dasher\spider\lib\dear;

use dasher\spider\lib\QuerySpider;
use QL\QueryList;

class Sarkariresultsinfo extends QuerySpider{

    protected string $url = 'https://www.sarkariresultsinfo.net/{year}/{month}/nagaland-state-lottery-result-{day}.html';
    protected string $pm1 = 'MN';
    protected string $pm6 = 'DN';
    protected string $pm8 = 'EN';

    public function setPm($pm1='MN',$pm6='DN',$pm8='EN'): Sarkariresultsinfo
    {
        $this->pm1 = $pm1;
        $this->pm6 = $pm6;
        $this->pm8 = $pm8;
        return $this;
    }

    public function getDetail($date){
        $time = strtotime($date);
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d-m-Y', $time);
        $url = str_replace(['{year}','{month}','{day}'], [$year,$month,$day], $this->url);
        $ql = $this->getHtml($url);
        $titles = $ql->find('.post-body.entry-content div span span b')->find('span')->texts()->all();
        $htmls = $ql->find('.post-body.entry-content')->find('table')->htmls()->all();
        return ['titles'=>$titles, 'htmls'=>$htmls];
    }

    public function getArray($date){
        $arr = $this->getDetail($date);
        $time = strtotime($date);
        $day = date('dmy', $time);
        $options = $arr['htmls'];
        $titles = $arr['titles'];
        $issueNoArr = [];
        foreach ($titles as $item){
            $item = str_replace([' ', '/[\x00-\x1F\x80-\xFF]/'],'',$item);
            switch ($item){
                case '01:00PMRESULT':
                    $issueNoArr[] = "{$this->pm1}{$day}";
                    break;
                case '06:00PMRESULT':
                    $issueNoArr[] = "{$this->pm6}{$day}";
                    break;
                case '08:00PMRESULT':
                    $issueNoArr[] = "{$this->pm8}{$day}";
                    break;
                default:
                    break;
            }
        }
        $issues = [];
        $prizeNames = [];
        $winners = [];
        foreach ($options as $option){
            $dom = (new QueryList())->html($option);
            $prizeNames[] = $dom->find('thead')->text();
            $winners[] = $dom->find('tbody')->text();
        }

        $issueIndex = -1;
        foreach ($prizeNames as $key=>$prize){
            $arr = explode('-',$prize);
            $prizeName = trim($arr[0]);
            $PrizeAmount = intval(str_replace([' ', ',', '/','Rs.'], '', $arr[1]));
            if($prizeName === 'Consolation Prize') $prizeName = 'Cons. Prize';
            if($prizeName === '1st Prize'){
                $issueIndex++;
                $issues[$issueIndex]['issue_no'] = $issueNoArr[$issueIndex];
                $issues[$issueIndex]['result'] = [];
            }
            $winnerList = explode('-',$winners[$key]);
            $winnerArray = [];
            foreach ($winnerList as $winner){
                $winnerArray[] = str_replace(['(All Serials)', ' ',' ', '/[\x00-\x1F\x80-\xFF]/'],'',$winner);
            }
            $issues[$issueIndex]['result'][] = [
                'PrizeName' => $prizeName,
                'PrizeAmount' => $PrizeAmount,
                'Winners' => $winnerArray
            ];
        }
        return $issues;
    }
}