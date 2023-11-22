<?php
/**
 * @desc EuroMillionsTest.php
 * @auhtor Wayne
 * @time 2023/11/22 15:00
 */
use PHPUnit\Framework\TestCase;
class EuroMillionsTest extends TestCase{

    public function testEuroMillionsCom(){
        $obj = new \dasher\spider\lib\euro_millions\EuroMillionsCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
    }

    public function testRedFoxLottoCom(){
        $obj = new \dasher\spider\lib\euro_millions\RedFoxLottoCom();
        $result = $obj->getPageDetail();
        var_dump($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('result',$result);
    }


}