<?php
/**
 * @desc PowerBallTest.php
 * @auhtor Wayne
 * @time 2023/11/6 14:54
 */

use dasher\spider\exception\SpiderException;
use PHPUnit\Framework\TestCase;

class PowerBallTest extends TestCase
{

     public function testPowerBallNet(){
         $obj = new \dasher\spider\lib\power_ball\PowerBallNet();
         $result = $obj->getPageDetail();
         var_dump($result);
         $this->assertIsArray($result);
         $this->assertArrayHasKey('date', $result);
         $this->assertArrayHasKey('result',$result);
     }

    public function testPowerBallCom(){
        $obj = new \dasher\spider\lib\power_ball\PowerBallCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
    }

    public function testAgentLottoCom(){
        $obj = new \dasher\spider\lib\power_ball\AgentLottoCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
    }

    public function testLottoParkCom(){
        $obj = new \dasher\spider\lib\power_ball\LottoParkCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
    }
}