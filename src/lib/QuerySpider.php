<?php
/**
 * @desc QuerySpider.php
 * @auhtor Wayne
 * @time 2023/12/5 14:43
 */
namespace dasher\spider\lib;

use QL\QueryList;

class QuerySpider{

    protected string $proxy = "";


    public function setProxy(string $proxy): QuerySpider
    {
        $this->proxy = $proxy;
        return $this;
    }


    protected function getHtml($url): QueryList
    {
        if(!empty($this->proxy)){
            return (new \QL\QueryList)->get($url, null, ['proxy' => $this->proxy]);
        }else{
            return (new \QL\QueryList)->get($url);
        }
    }
}