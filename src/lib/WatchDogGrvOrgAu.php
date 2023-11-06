<?php
/**
 * @desc WatchDogGrvOrgAu.php
 * @auhtor Wayne
 * @time 2023/11/6 18:05
 */
namespace dasher\spider\lib;
use dasher\payment\exception\SpiderException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use QL\QueryList;

class WatchDogGrvOrgAu{

    protected $meetingListUrl = "https://watchdog.grv.org.au/form/recent";
    protected $meetingDetail = 'https://watchdog.grv.org.au/form/meeting/{$meetingId}';
    protected $raceUrl = 'https://watchdog.grv.org.au/form/race/{$raceId}/detailed';

    protected $traceList = [];
    protected $meetingList = [];
    protected $raceList = [];

    protected $traceObj = [];
    protected $meetingObj = [];
    protected $raceObj = [];

    protected $traceJson = [];
    protected $meetingJson = [];

    /**
     * @throws GuzzleException
     * @throws SpiderException
     */
    public function getTraceJson(){
        $client = new Client(['verify' => false, 'http_errors' => false]);
        try {
            $response = $client->get($this->meetingList);
            $content = (string)$response->getBody();
            if (empty($content)) {
                throw new SpiderException('spider run failed',-100);
            }
            $this->traceJson = json_decode($content, true);
        }catch (GuzzleException $e){
            throw new SpiderException($e->getMessage(), -101, $e->getPrevious());
        }
        return $this;
    }

    public function getTraceList(){
        foreach ($this->traceJson['meetings'] as $item){
            $this->traceList[] = [
                'track_code' => $item['trackCode'],
                'track_name' => $item['trackName']
            ];
            $this->meetingList[] = $item['id'];
        }
        $this->meetingList = array_unique($this->meetingList);
        return $this;
    }

    /**
     * @throws SpiderException
     */
    public function getMeetingObj($meetingId){
        $url = str_replace('{$meetingId}', $meetingId,$this->meetingObj);
        $client = new Client(['verify' => false, 'http_errors' => false]);
        try {
            $response = $client->get($url);
            $content = (string)$response->getBody();
            if (empty($content)) {
                throw new SpiderException('spider run failed',-100);
            }
            $result = json_decode($content, true);
            $meeting = [
                'id'            => $result[0]['id'],
                'track_code'    => $result[0]['trackCode'],
                'track_name'    => $result[0]['trackName'],
                'slot'          => $result[0]['slot'],
                'race_count'    => $result[0]['countRaces'],
                'meeting_date'  => $result[0]['meetingDate'],
                'start_time'    => $result[0]['startTime'],
            ];

        }catch (GuzzleException $e){
            throw new SpiderException($e->getMessage(), -101, $e->getPrevious());
        }
    }

    public function getRaceList(){

    }

    public function getData($key){
        return $this->$key;
    }
}