<?php
/**
 * @desc DeaLotteryIn.php
 * @auhtor Wayne
 * @time 2024/5/21 14:29
 */
namespace dasher\spider\lib\dear;
use dasher\spider\exception\SpiderException;
use dasher\spider\lib\QuerySpider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class DearLotteryIn extends QuerySpider{

    protected string $url = "https://dear-lottery.in/dear-lottery-result-today-{hour}-pm/";

    public function getImageUrl($hour){
        $url = str_replace('{hour}', $hour, $this->url);
        $ql = $this->getHtml($url);
        //page #content #primary #main article .entry-content figure img
        return $ql->find('.entry-content figure img')->attr('data-src');
    }

    /**
     * @throws SpiderException
     */
    public function getDetail($hour, $savePath): bool
    {
        try {
            $options = [
                RequestOptions::VERIFY => false,
                RequestOptions::TIMEOUT => 30,
            ];
            if(!empty($this->proxy)) $options[RequestOptions::PROXY] = $this->proxy;
            $client= new Client($options);
            $url = $this->getImageUrl($hour);
            $response = $client->head($url);
            if($response->getStatusCode() == 200) {
                if(!file_exists($savePath) && $url){
                    $client = new Client($options);
                    $response = $client->request('GET',$url, [
                        'sink' => $savePath, // 使用 'sink' 选项保存到文件
                    ]);
                    if ($response->getStatusCode() === 200) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        } catch (GuzzleException $e) {
            throw new SpiderException('Kerala GuzzleHttp err!' . $e->getMessage());
        }

        return false;
    }

}