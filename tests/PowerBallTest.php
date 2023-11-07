<?php
/**
 * @desc PowerBallTest.php
 * @auhtor Wayne
 * @time 2023/11/6 14:54
 */

use dasher\spider\lib\PowerBallCom;
use PHPUnit\Framework\TestCase;

class PowerBallTest extends TestCase
{

    /**
     * @throws \dasher\payment\exception\SpiderException
     */
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
//        $this->assertArrayHasKey('text',$result);
//        $this->assertTrue(true);
//    }

//    public function testWatchDogTrace(){
//        $obj = new \dasher\spider\lib\WatchDogGrvOrgAu();
//        $result = $obj->getTraceList();
//        $this->assertArrayHasKey('traceList',$result);
//        $this->assertArrayHasKey('meetingList',$result);
//    }
//
//    /**
//     * @throws \dasher\payment\exception\SpiderException
//     */
//    public function testWatchDogMeeting(){
//        $meetingId = 900013492;
//        $obj = new \dasher\spider\lib\WatchDogGrvOrgAu();
//        $result = $obj->getMeetingObj($meetingId);
//        print_r($result);
//        $this->assertArrayHasKey('meeting',$result);
//        $this->assertArrayHasKey('races',$result);
//    }

//    /**
//     * @throws \dasher\payment\exception\SpiderException
//     */
//    public function testWatchDogRace(){
//        $raceId = 961837841;
//        $obj = new \dasher\spider\lib\WatchDogGrvOrgAu();
//        $result = $obj->getRaceObj($raceId);
//        print_r($result);
//        $this->assertArrayHasKey('race',$result);
//        $this->assertArrayHasKey('dogs',$result);
//    }

    /**
     * @throws \dasher\payment\exception\SpiderException
     */
    public function testWatchDogDog(){
        $dogId = 360995211;
        $obj = new \dasher\spider\lib\WatchDogGrvOrgAu();
        $result = $obj->getDogObj($dogId);
        $this->assertArrayHasKey('dog_name',$result);
        $this->assertArrayHasKey('colour',$result);
        $this->assertArrayHasKey('sex',$result);
        $this->assertArrayHasKey('breeds',$result);
    }
}