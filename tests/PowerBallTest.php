<?php
/**
 * @desc PowerBallTest.php
 * @auhtor Wayne
 * @time 2023/11/6 14:54
 */

use dasher\spider\exception\SpiderException;
use dasher\spider\lib\PowerBallCom;
use PHPUnit\Framework\TestCase;

class PowerBallTest extends TestCase
{

    /**
     * @throws SpiderException
     */
    public function testPowerBallCom()
    {
        $result = \dasher\spider\Api::getResult('powerBallCom');
        $this->assertIsArray($result);
        $this->assertTrue(true);
    }

    public function testPowerBallNet()
    {
        $result = \dasher\spider\Api::getResult('powerBallNet');
        $this->assertArrayHasKey('result',$result);
        $this->assertArrayHasKey('date',$result);
        $this->assertTrue(true);
    }

    public function testPowerBallComDetail(){
        $date = '20230902';
        $obj = new \dasher\spider\lib\PowerBallCom();
        $result = $obj->getPageDetail($date);
        $this->assertArrayHasKey('date',$result);
        $this->assertArrayHasKey('result',$result);
    }

    public function testPowerBallNetDetail(){
        $date = '20230902';
        $obj = new \dasher\spider\lib\PowerBallNet();
        $result = $obj->getPageDetail($date);
        $this->assertArrayHasKey('date',$result);
        $this->assertArrayHasKey('result',$result);
    }


}