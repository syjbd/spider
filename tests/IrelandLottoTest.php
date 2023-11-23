<?php
/**
 * @desc IrelanLottoTest.php
 * @auhtor Wayne
 * @time 2023/11/22 16:01
 */
use dasher\spider\lib\lotto_uk\LottoParkCom;
use PHPUnit\Framework\TestCase;

class IrelandLottoTest extends TestCase
{
    public function testMagaYoCom()
    {
        $obj = new \dasher\spider\lib\ireland_lotto\MagaYoCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result', $result);
    }

    public function testLotteryTextsCom()
    {
        $obj = new \dasher\spider\lib\ireland_lotto\LotteryTextsCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result', $result);
    }

    public function testAgentLottoCom(){
        $obj = new \dasher\spider\lib\ireland_lotto\AgentLottoCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
    }
}