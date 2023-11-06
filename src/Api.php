<?php
/**
 * @desc Api.php
 * @auhtor Wayne
 * @time 2023/11/6 14:37
 */
namespace dasher\spider;

use dasher\payment\exception\SpiderException;
use dasher\spider\lib\PowerBallCom;

class Api{


    /**
     * @throws SpiderException
     */
    public static function getResult(){
        $obj = new PowerBallCom();
        return $obj->getPageList()[0];
    }

}