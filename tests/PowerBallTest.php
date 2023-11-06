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
    public function testExample()
    {
        // 这是一个断言示例
        $result = \dasher\spider\Api::getResult();
        $this->assertIsArray($result);
        $this->assertTrue(true);
    }

}