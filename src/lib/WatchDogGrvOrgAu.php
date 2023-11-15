<?php
/**
 * @desc WatchDogGrvOrgAu.php
 * @auhtor Wayne
 * @time 2023/11/6 18:05
 */
namespace dasher\spider\lib;
use dasher\spider\exception\SpiderException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WatchDogGrvOrgAu{

    protected string $meetingListUrl = "https://watchdog.grv.org.au/form/recent";
    protected string $meetingDetail = 'https://watchdog.grv.org.au/form/meeting/{meetingId}';
    protected string $raceUrl = 'https://watchdog.grv.org.au/form/race/{raceId}/detailed';
    protected string $dogUrl = 'https://watchdog.grv.org.au/form/dog/{dogId}';

    /**
     * @throws SpiderException
     */
    public function getUrlResponse($url){
        try {
            $client = new Client(['verify' => false, 'http_errors' => false]);
            $response = $client->get($url);
            $content = (string)$response->getBody();
            if (empty($content)) {
                throw new SpiderException('spider run failed',-100);
            }
            return json_decode($content, true);
        }
        catch (GuzzleException $e){
            throw new SpiderException($e->getMessage(), -101, $e->getPrevious());
        }
    }

    /**
     * @throws SpiderException
     */
    public function getTraceList(): array
    {
        $result= $this->getUrlResponse($this->meetingListUrl);
        if(empty($result['meetings'])) throw new SpiderException('no meetings info', -100);
        $traceList = [];
        $meetingList = [];
        foreach ($result['meetings'] as $item){
            $traceList[] = [
                'track_code' => $item['trackCode'],
                'track_name' => $item['trackName']
            ];
            $meetingList[] = $item['id'];
        }
        $meetingList = array_unique($meetingList);
        return ['traceList'=> $traceList, 'meetingList'=>$meetingList];
    }

    /**
     * @throws SpiderException
     */
    public function getMeetingObj($meetingId): array
    {
        $url = str_replace('{meetingId}', $meetingId,$this->meetingDetail);
        $result = $this->getUrlResponse($url);
        $meetingObj = [
            'source_meeting_id' => $result['meetings'][0]['id'],
            'track_code'        => $result['meetings'][0]['trackCode'],
            'track_name'        => $result['meetings'][0]['trackName'],
            'slot'              => $result['meetings'][0]['slot'],
            'race_count'        => $result['meetings'][0]['countRaces'],
            'meeting_time'      => strtotime($result['meetings'][0]['meetingDate']),
            'start_time'        => strtotime($result['meetings'][0]['startTime']),
        ];
        $races = [];
        foreach ($result['races'] as $race){
            $races[] = [
                'source_race_id'    => $race['id'],
                'source_meeting_id' => $race['meetingId'],
                'rug_number'        => $race['number'],
                'sponsor'           => $race['sponsor'],
                'distance'          => $race['distance'],
                'grade_code'        => $race['gradeCode'],
                'video_id'          => $race['videoId'],
                'photo_url'         => !empty($race['photoFinishUrl']) ? $race['photoFinishUrl'] : '',
            ];
        }
        return  ['meeting'=>$meetingObj, 'races'=>$races];
    }

    /**
     * @throws SpiderException
     */
    public function getDogObj($dogId): array
    {
        $url = str_replace('{dogId}', $dogId, $this->dogUrl);
        $result = $this->getUrlResponse($url);
        if(empty($result['bbsubjects'])) throw new SpiderException('no dog info',-100);
        return [
            'dog_name'      => $result['bbsubjects'][0]['name'],
            'colour'        => $result['bbsubjects'][0]['colour'],
            'sex'           => $result['bbsubjects'][0]['sex'],
            'breeds'        => $result['bbsubjects'][0]['type'],
            'source_dog_id' => $result['bbsubjects'][0]['id'],
        ];
    }

    /**
     * @throws SpiderException
     */
    public function getRaceObj($raceId): array
    {
        $url = str_replace('{raceId}', $raceId, $this->raceUrl);
        $result = $this->getUrlResponse($url);
        if(empty($result['races'][0])) throw new SpiderException('no rices info', -100);
        $race = [
            'source_race_id'    => $result['races'][0]['id'],
            'source_meeting_id' => $result['races'][0]['meetingId'],
            'sponsor'           => $result['races'][0]['sponsor'],
            'distance'          => $result['races'][0]['distance'],
            'grade_code'        => $result['races'][0]['gradeCode'],
            'video_id'          => $result['races'][0]['videoId'],
            'rug_number'        => $result['races'][0]['number'],
            'photo_url'         => !empty($result['races'][0]['photoFinishUrl']) ? $result['races'][0]['photoFinishUrl'] : '',
        ];
        $dogs = [];
        if(empty($result['participants'])) throw new SpiderException('no participants', -100);
        foreach ($result['participants'] as $dog){
            $dogs[] = [
                'source_race_id'    => $dog['raceId'],
                'rug_number'        => $dog['rugNumber'],
                'box'               => $dog['box'] != 'scratched' ? $dog['box'] : 0,
                'source_dog_id'     => $dog['dogId'],
                'dog_name'          => $dog['dogName'],
                'odds'              => $dog['box'] != 'scratched' && !empty($dog['oddsFixedWin']) ? $dog['oddsFixedWin'] : 0,
            ];
        }
        return ['race'=>$race, 'dogs'=>$dogs];
    }

    public function getData($key){
        return $this->$key;
    }
}