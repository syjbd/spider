<?php
/**
 * @desc Api.php
 * @auhtor Wayne
 * @time 2023/11/6 14:37
 */
namespace dasher\spider;

use dasher\payment\exception\SpiderException;
use dasher\spider\lib\PowerBallCom;
use dasher\spider\lib\PowerBallNet;

class Api{


    /**
     * @throws SpiderException
     */
    public static function getResult($type='powerBallCom'){
        switch ($type){
            case 'powerBallCom':
                $obj = new PowerBallCom();
                return $obj->getPageList()[0];
            case 'powerBallNet':
                $obj = new PowerBallNet();
                return $obj->getPageList()[0];
            default:
                throw new SpiderException('no this spider object');
        }
    }

    public static function getGreyhound(){

    }

}