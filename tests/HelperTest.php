<?php
/**
 * @desc HelperTest.php
 * @auhtor Wayne
 * @time 2023/11/22 17:09
 */
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testWatchDogTrace(){
        $t = time();
        var_dump($t );
        var_dump(\dasher\spider\Helper::dateFormat($t,'Y-m-d H:i:s','Asia/Shanghai'));
        var_dump(\dasher\spider\Helper::dateFormat($t));
    }

}