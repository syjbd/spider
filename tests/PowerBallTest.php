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

    public function testWatchDog(){
        $obj = new \dasher\spider\lib\WatchDogGrvOrgAu();
        $res = $obj->getTraceJson()->getTraceList();
        print_r($res->getData('traceList'));
        print_r($res->getData('meetingList'));
    }
}