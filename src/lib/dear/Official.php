<?php
/**
 * @desc Official.php
 * @auhtor Wayne
 * @time 2024/2/20 18:49
 */
namespace dasher\spider\lib\dear;

use dasher\spider\exception\SpiderException;
use dasher\spider\lib\QuerySpider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Official extends QuerySpider{

    protected $fileUrl = 'http://www.nagalandlotteries.com/old_results/{$issueNo}.PDF';


    /**
     * @throws SpiderException
     */
    public function getDetail($issueNo, $savePath): bool
    {
        $options = [
            RequestOptions::VERIFY => false,
            RequestOptions::TIMEOUT => 30,
        ];
        if(!empty($this->proxy)) $options[RequestOptions::PROXY] = $this->proxy;
        $client= new Client($options);
        $url = str_replace('{$issueNo}',$issueNo,$this->fileUrl);
        try {
            $response = $client->head($url);
            if($response->getStatusCode() == 200) {
                if(!file_exists($savePath) && $url){
                    $client = new Client();
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
            throw new SpiderException('Kerala GuzzleHttp err!');
        }
        return false;
    }


}