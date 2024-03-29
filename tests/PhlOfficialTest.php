<?php
/**
 * @desc PhlOfficialTest.php
 * @auhtor Wayne
 * @time 2024/3/21 10:22
 */
use PHPUnit\Framework\TestCase;
class PhlOfficialTest extends TestCase{


    public function testToday(){
        $obj = new \dasher\spider\lib\phl\Official();
        $res = $obj->getTodayContent();
        var_dump($res);
    }

    public function testHistory(){
        $obj = new \dasher\spider\lib\phl\Official();
        $res = $obj->getHistoryContent([]);
        var_dump($res);
    }

    public function testGame(){
        $obj = new \dasher\spider\lib\phl\Official();
        $res = $obj->getGameContent(38111);
        var_dump($res);
    }
}