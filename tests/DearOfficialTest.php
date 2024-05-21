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
        $res = $obj->getDetail('MD030324', './down/MD030324.pdf');
        var_dump($res);
    }

    public function testOfficialPdf(){
        $obj = new \dasher\spider\lib\kerala\Official();
        $res = $obj->pdfToText(dirname(__DIR__, 1) . '/src/down/1pm.jpg');
        var_dump($res);
    }

    public function testIndiaDear(){
        $obj = new \dasher\spider\lib\dear\DearLotteryIn();
        $res = $obj->getDetail(1, dirname(__DIR__, 1).'/src/down/1pm.jpg');
        var_dump($res);
    }
}