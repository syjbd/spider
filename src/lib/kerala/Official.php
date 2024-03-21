<?php
/**
 * @desc Official.php
 * @auhtor Wayne
 * @time 2024/3/6 11:19
 */
namespace dasher\spider\lib\kerala;

use dasher\spider\lib\QuerySpider;

class Official extends QuerySpider{



    public function pdfToText($file){
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($file);
        $text = $pdf->getText();
        echo $text;
        return $text;
    }

}