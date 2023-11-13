<?php
/**
 * @desc TheDogsComAu.php
 * @auhtor Wayne
 * @time 2023/11/8 18:37
 */
namespace dasher\spider\lib;
use dasher\payment\exception\SpiderException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use QL\QueryList;

class TheDogsComAu{

    protected string $baseUrl = 'https://www.thedogs.com.au/';
    protected string $meetingListUrl = "https://www.thedogs.com.au/racing";


    protected function getHtml($url): QueryList
    {
        return (new \QL\QueryList)->get($url);
    }

    public function getTraceList(): array
    {
        $ql = $this->getHtml($this->meetingListUrl);
        $areas =  $ql->find('.meeting-grid tbody')->htmls()->all();
        $meeting = [];
        foreach ($areas as $areaHtml){
            $obj = (new \QL\QueryList)->html($areaHtml);
            $meetingsHtml = $obj->find('tr')->htmls()->all();
            foreach ($meetingsHtml as $mt){
                $obj = (new \QL\QueryList)->html($mt);
                $meetingName = $obj->find('.meetings-venues__name')->text();
                $meetingLink = $obj->find('.meetings-venues__name a')->attr('href');
                if(empty($meetingLink)) continue;
                $meetings = explode('?',$meetingLink);
                if(empty($meetings[0])) continue;
                $linkArr = explode('/', $meetings[0]);
                if(empty($linkArr[2]) || empty($linkArr[3])) continue;
                $meetingCode = $linkArr[2];
                $meetingDate = $linkArr[3];
                $mltList = $obj->find(".meetings-venues__race-time")->htmls()->all();
                $raceTimes = [];
                $raceLinks = [];
                $raceResults = [];
                foreach ($mltList as $ml){
                    $obj = (new \QL\QueryList)->html($ml);
                    $result = $obj->find(".race-box__caption")->text();
                    if($result == 'ABD') continue;
                    $raceTimes[] = $obj->find('a')->attr('data-race-box');
                    $raceLinks[] = $obj->find("a")->attr('href');
                    $raceResults[] = $result;
                }
                $races = [];
                foreach ($raceLinks as $key=>$link){
                    $links = explode('/', $link);
                    $races[] = [
                        'round'     => $links[4],
                        'result'    => $raceResults[$key],
                        'time'      => $raceTimes[$key],
                        'link'      => $link
                    ];
                }
                $meeting[] = [
                    'meeting_name'  => $meetingName,
                    'meeting_code'  => $meetingCode,
                    'meeting_date'  => $meetingDate,
                    'meeting_link'  => $meetingLink,
                    'meeting_rice'  => $races
                ];
            }
        }
        return $meeting;
    }

    public function getRaceDetail($url): array
    {
        $ql = $this->getHtml($url);
        $name = $ql->find('.race-header__info .race-header__info__name')->text();
        $grade = $ql->find('.race-header__info .race-header__info__grade')->text();
        $time = $ql->find('.race-header__info formatted-time')->attr('data-timestamp');
        $round= $ql->find('.race-header .race-box .race-box__number')->text();
        $result= $ql->find('.race-header .race-box .race-box__caption span')->texts()->all();
        $photo = $ql->find('.race-header__media .race-header__media__item--photo')->attr('href');

        $oddsHls = $ql->find('.race-runners tbody tr')->htmls();
        $raceOdds=[];
        foreach ($oddsHls as $hl){
            $obj = (new \QL\QueryList)->html($hl);
            $position = $obj->find('.race-runners__finish-position')->text();
            $box = $obj->find('.race-runners__box sprite-svg')->attr('name');
            if(empty($box)) continue;
            $dogName = $obj->find('.race-runners__name .race-runners__name__dog a')->text();
            $dogLink = $obj->find('.race-runners__name .race-runners__name__dog a')->attr('href');
            if(empty($dogName)){
                $data = $obj->find('.race-runners__name__dog')->html();
                $dogName = trim(strstr($data, '<span', true));
            }
            $odds = $obj->find('.runner-odds-fluctuation--price')->text();
            $raceOdds[] = [
                'position'  => $position,
                'box'       => str_replace('rug_', '', $box),
                'dog_name'  => $dogName,
                'dog_link'  => $dogLink,
                'odds'      => $odds,
            ];
        }

        return [
            'name' => $name,
            'grade' => $grade,
            'time' => $time,
            'round' => $round,
            'result' => $result,
            'photo' =>  $photo,
            'odds' => $raceOdds
        ];
    }

    /**
     * @throws GuzzleException
     * @throws SpiderException
     */
    public function downPhoto($url, $savePath){
        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 2.0,
            'verify' => false,
            'http_errors' => false,
            'allow_redirects' => [
                'max'             => 10,       // allow at most 10 redirects.
                'strict'          => true,     // use "strict" RFC compliant redirects.
                'referer'         => true,     // add a Referer header
                'protocols'       => ['http', 'https'], // only allow https URLs
                'track_redirects' => true
            ]
        ]);
        $response = $client->get($url, [
            RequestOptions::SINK => $savePath,
        ]);
        if ($response->getStatusCode() == 200) {
            return $savePath;
        } else {
            throw new SpiderException('Failed to download image', -100);
        }
    }
}