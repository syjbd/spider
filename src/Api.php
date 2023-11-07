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
use dasher\spider\lib\WatchDogGrvOrgAu;

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

    /**
     * @throws SpiderException
     */
    public static function getGreyhound($type, $id=0): array
    {
        $obj = new WatchDogGrvOrgAu();
        switch ($type){
            case 'trace':
                return $obj->getTraceList();
            case 'meeting':
                return $obj->getMeetingObj($id);
            case 'race':
                return $obj->getRaceObj($id);
            case 'dog':
                return $obj->getDogObj($id);
            default:
                throw new SpiderException('no this spider type',-100);
        }
    }

}