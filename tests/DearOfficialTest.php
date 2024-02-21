<?php
/**
 * @desc DearOfficial.php
 * @auhtor Wayne
 * @time 2024/2/20 18:54
 */

use PHPUnit\Framework\TestCase;
class DearOfficialTest extends TestCase{

    public function testClientSpider(){
        $obj = new \dasher\spider\lib\dear\Official();
        $res = $obj->getDetail('MD200224', './down/MD200224.pdf');
        var_dump($res);
    }

}