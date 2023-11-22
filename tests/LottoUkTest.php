<?php
/**
 * @desc LottoUkTest.php
 * @auhtor Wayne
 * @time 2023/11/22 10:53
 */

use dasher\spider\lib\lotto_uk\LottoParkCom;
use PHPUnit\Framework\TestCase;
class LottoUkTest extends TestCase{

    public function testLottoPackCom(){
        $obj = new LottoParkCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
        $this->assertTrue(count($result['result']) == 7);
    }

    public function testNationalLotteryCoUk(){
        $obj = new \dasher\spider\lib\lotto_uk\NationalLotteryCoUk();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
        $this->assertTrue(count($result['result']) == 7);
    }

    public function testAgentLottoCom(){
        $obj = new \dasher\spider\lib\lotto_uk\AgentLottoCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
        $this->assertTrue(count($result['result']) == 7);
    }
}