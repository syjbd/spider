<?php
/**
 * @desc MegaMillionsTest.php
 * @auhtor Wayne
 * @time 2023/11/22 15:24
 */
use dasher\spider\lib\lotto_uk\LottoParkCom;
use PHPUnit\Framework\TestCase;

class MegaMillionsTest extends TestCase{

    public function testRedFoxLottoCom(){
        $obj = new \dasher\spider\lib\mega_millions\RedFoxLottoCom();
        $result = $obj->getPageDetail();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
    }

    public function testLottoParkCom(){
        $obj = new \dasher\spider\lib\mega_millions\LottoParkCom();
        $result = $obj->getPageDetail();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
    }

    public function testMagaYoCom(){
        $obj = new \dasher\spider\lib\mega_millions\MagaYoCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
    }
}