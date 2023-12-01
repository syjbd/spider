<?php
/**
 * @desc ListMegaMillionsTest.php
 * @auhtor Wayne
 * @time 2023/12/1 17:09
 */
use PHPUnit\Framework\TestCase;

class ListResultTest extends TestCase
{
//    public function testMegaMillions(){
//        $obj = new \dasher\spider\lib\mega_millions\AgentLottoCom();
//        $result = $obj->getPageList(0,0);
//        print_r($result);
//        $this->assertIsArray($result);
//    }
//
//    public function testPowerBall(){
//        $obj = new \dasher\spider\lib\power_ball\AgentLottoCom();
//        $result = $obj->getPageList(0,0);
//        print_r($result);
//        $this->assertIsArray($result);
//    }

//    public function testLottoUk(){
//        $obj = new \dasher\spider\lib\lotto_uk\AgentLottoCom();
//        $result = $obj->getPageList(0,0);
//        print_r($result);
//        $this->assertIsArray($result);
//    }

//    public function testEuroMillions(){
//        $obj = new \dasher\spider\lib\euro_millions\AgentLottoCom();
//        $result = $obj->getPageList(0,0);
//        print_r($result);
//        $this->assertIsArray($result);
//    }

    public function testEuroMillionsList(){
        $obj = new \dasher\spider\lib\ireland_lotto\AgentLottoCom();
        $result = $obj->getPageList(0,0);
        print_r($result);
        $this->assertIsArray($result);
    }

    public function testEuroMillionsDetail(){
        $obj = new \dasher\spider\lib\ireland_lotto\AgentLottoCom();
        $result = $obj->getPageDetail();
        print_r($result);
        $this->assertIsArray($result);
    }

}
