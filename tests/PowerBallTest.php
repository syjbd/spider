<?php
/**
 * @desc PowerBallTest.php
 * @auhtor Wayne
 * @time 2023/11/6 14:54
 */

use dasher\payment\exception\SpiderException;
use dasher\spider\lib\PowerBallCom;
use PHPUnit\Framework\TestCase;

class PowerBallTest extends TestCase
{

//    /**
//     * @throws SpiderException
//     */
//    public function testPowerBallCom()
//    {
//        $result = \dasher\spider\Api::getResult('powerBallCom');
//        $this->assertIsArray($result);
//        $this->assertTrue(true);
//    }
//
//    public function testPowerBallNet()
//    {
//        $result = \dasher\spider\Api::getResult('powerBallNet');
//        $this->assertArrayHasKey('result',$result);
//        $this->assertArrayHasKey('date',$result);
//        $this->assertTrue(true);
//    }
//
//    public function testPowerBallComDetail(){
//        $date = '20230902';
//        $obj = new \dasher\spider\lib\PowerBallCom();
//        $result = $obj->getPageDetail($date);
//        $this->assertArrayHasKey('date',$result);
//        $this->assertArrayHasKey('result',$result);
//    }
//
//    public function testPowerBallNetDetail(){
//        $date = '20230902';
//        $obj = new \dasher\spider\lib\PowerBallNet();
//        $result = $obj->getPageDetail($date);
//        $this->assertArrayHasKey('date',$result);
//        $this->assertArrayHasKey('result',$result);
//    }
//
//    public function testWatchDogTrace(){
//        $obj = new \dasher\spider\lib\WatchDogGrvOrgAu();
//        $result = $obj->getTraceList();
//        $this->assertArrayHasKey('traceList',$result);
//        $this->assertArrayHasKey('meetingList',$result);
//    }
//
//    /**
//     * @throws SpiderException
//     */
//    public function testWatchDogMeeting(){
//        $meetingId = 900013492;
//        $obj = new \dasher\spider\lib\WatchDogGrvOrgAu();
//        $result = $obj->getMeetingObj($meetingId);
//        $this->assertArrayHasKey('meeting',$result);
//        $this->assertArrayHasKey('races',$result);
//    }
//
//    /**
//     * @throws SpiderException
//     */
//    public function testWatchDogRace(){
//        $raceId = 961837841;
//        $obj = new \dasher\spider\lib\WatchDogGrvOrgAu();
//        $result = $obj->getRaceObj($raceId);
//        $this->assertArrayHasKey('race',$result);
//        $this->assertArrayHasKey('dogs',$result);
//    }
//
//    /**
//     * @throws SpiderException
//     */
//    public function testWatchDogDog(){
//        $dogId = 360995211;
//        $obj = new \dasher\spider\lib\WatchDogGrvOrgAu();
//        $result = $obj->getDogObj($dogId);
//        $this->assertArrayHasKey('dog_name',$result);
//        $this->assertArrayHasKey('colour',$result);
//        $this->assertArrayHasKey('sex',$result);
//        $this->assertArrayHasKey('breeds',$result);
//    }


    public function testTheDogCom(){
        $url = 'https://www.thedogs.com.au/racing/townsville/2023-11-10/4/ingham-road-seafood?trial=false';
        $url = 'https://www.thedogs.com.au/racing/townsville/2023-11-10/1/burdekin-vet-services/odds';
        $url = 'https://www.thedogs.com.au/racing/wentworth-park/2023-11-10/6/the-gardens-to-wenty-final-gardens-wenty-f/odds';
        $url = 'https://www.thedogs.com.au/racing/angle-park/2023-11-13/1/fresh-pet-food-co-maiden-stake-ctb-division1/odds';
        $obj = new \dasher\spider\lib\TheDogsComAu();
//        $result = $obj->getTraceList();
//        $this->assertIsArray($result);
//
//        $this->assertArrayHasKey('meeting_name',$result[0]);
//        $this->assertArrayHasKey('meeting_code',$result[0]);
//        $this->assertArrayHasKey('meeting_ymd',$result[0]);
//        $this->assertArrayHasKey('meeting_link',$result[0]);
//        $this->assertArrayHasKey('meeting_rice',$result[0]);
//
//
//        $result = $obj->getRaceDetail($url);
//        print_r($result);
//        $this->assertArrayHasKey('name',$result);
//        $this->assertArrayHasKey('grade',$result);
//        $this->assertArrayHasKey('time',$result);
//        $this->assertArrayHasKey('round',$result);
//        $this->assertArrayHasKey('result',$result);
//        $this->assertArrayHasKey('photo',$result);
//        $this->assertArrayHasKey('video',$result);
//        $this->assertArrayHasKey('odds',$result);
//
//        $this->assertIsArray($result['odds']);
//
//        $this->assertArrayHasKey('position',$result['odds'][0]);
//        $this->assertArrayHasKey('box',$result['odds'][0]);
//        $this->assertArrayHasKey('dog_name',$result['odds'][0]);
//        $this->assertArrayHasKey('dog_link',$result['odds'][0]);
//        $this->assertArrayHasKey('odds',$result['odds'][0]);

//        $url = 'https://www.thedogs.com.au/videos/watch/races/1101808/replay';
//        $result = $obj->getVideoUrl($url);
//        var_dump($result);
//        $photo = '/attachments/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaHBCRVgrQVFFPSIsImV4cCI6bnVsbCwicHVyIjoiYmxvYl9pZCJ9fQ==--f4f478eb7c329441969584ed7db9f488cdb068aa/2023-1011-04.jpg';
//        $obj->downPhoto($photo, '');
        $url = "https://www.thedogs.com.au/videos/watch/races/1101808/replay";
        $url = "https://www.thedogs.com.au/videos/watch/races/1101953/replay";
        $url = "https://www.thedogs.com.au/videos/watch/races/1101949/replay";

        $result = $obj->getVideoUrl($url);
        var_dump($result);

//        $url = 'https://d2w8yyjcswa0zt.cloudfront.net/c4p343q1pztp3de893mqe8xe2kmv.m3u8';
//        $url = 'https://d2w8yyjcswa0zt.cloudfront.net/c4p343q1pztp3de893mqe8xe2kmv/400.m3u8';
//        $obj = new \dasher\spider\lib\M3u8Down();
//        $result = $obj->setSourceUrl($url)->setBaseUrl('https://d2w8yyjcswa0zt.cloudfront.net/c4p343q1pztp3de893mqe8xe2kmv/')->replaceVideoContent();
//        $obj = $obj->setSavePath('tests/')->writeVideoFile($result, 'test.m3u8');
//        var_dump($result);

    }

//    public function testM3u8Down(){
//        $url = 'https://d2w8yyjcswa0zt.cloudfront.net/c0i4x27s6cp1didg6361qvf9d81p/8500.m3u8';
//        $obj = new \dasher\spider\lib\M3u8Down();
//        $result = $obj->setSourceUrl($url)->down();
//        var_dump($result);
//    }
}