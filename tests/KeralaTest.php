<?php
/**
 * @desc KeralaTest.php
 * @auhtor Wayne
 * @time 2023/12/6 11:38
 */
use PHPUnit\Framework\TestCase;
class KeralaTest extends TestCase
{

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \dasher\spider\exception\SpiderException
     */
    public function testLotteryAddaComList(){
        $obj = new \dasher\spider\lib\kerala\LotteryAddaCom();
        $result = $obj->getList();
        $this->assertIsArray($result);
        $this->assertTrue(count($result) > 3);

    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \dasher\spider\exception\SpiderException
     */
    public function testLotteryAddaComInfo(){
        $id = 1513;
        $obj = new \dasher\spider\lib\kerala\LotteryAddaCom();
        $result = $obj->getInfo($id);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('lotteryGamePlan',$result);
        $this->assertArrayHasKey('lotteryPrizeDetails',$result);
    }

    public function testLotteryAddaComInfoResult(){
        $id = 1505;
        $obj = new \dasher\spider\lib\kerala\LotteryAddaCom();
        $result = $obj->getResult($id);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('prizeName',$result[0]);
        $this->assertArrayHasKey('sort',$result[0]);
        $this->assertArrayHasKey('prizeMoney',$result[0]);
        $this->assertArrayHasKey('codes',$result[0]);
    }
}