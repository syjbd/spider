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
    public function testPowerBallCom()
    {
        $result = \dasher\spider\Api::getResult('powerBallCom');
        $this->assertIsArray($result);
        $this->assertTrue(true);
    }

    public function testPowerBallNet()
    {
        $result = \dasher\spider\Api::getResult('powerBallNet');
        $this->assertIsArray($result);
        $this->assertTrue(true);
    }

}