<?php
/**
 * @desc Client.php
 * @auhtor Wayne
 * @time 2023/11/22 16:18
 */
namespace dasher\spider;

use dasher\spider\exception\SpiderException;

class Client{

    const NAMESPACE_EURO_MILLIONS   = 'euro_millions';
    const NAMESPACE_IRELAND_LOTTO   = 'ireland_lotto';
    const NAMESPACE_LOTTO_UK        = 'lotto_uk';
    const NAMESPACE_MEGA_MILLIONS   = 'mega_millions';
    const NAMESPACE_POWER_BALL      = 'power_ball';


    /**
     * @throws SpiderException
     */
    public function getResult($lottery, $spiderName, $config=[], $headers=[])
    {
        $className = "\\dasher\\spider\\lib\\{$lottery}\\{$spiderName}";
        if(!class_exists($className)){
            throw new SpiderException($className . 'Spider class no exists!', -100);
        }
        $obj = new $className();
        return $obj->setConfig($config)->getPageDetail();
    }

    /**
     * @throws SpiderException
     */
    public function getHistory($lottery, $year=0,$month=0){
        $className = "\\dasher\\spider\\lib\\{$lottery}\\AgentLottoCom";
        if(!class_exists($className)){
            throw new SpiderException($className . 'Spider class no exists!', -100);
        }
        $obj = new $className();
        return $obj->getPageList($year, $month);
    }

}