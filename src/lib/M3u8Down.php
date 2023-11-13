<?php
/**
 * @desc M3u8Dwon.php
 * @auhtor Wayne
 * @time 2023/11/10 17:28
 */
namespace dasher\spider\lib;

use dasher\payment\exception\SpiderException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class M3u8Down{

    protected string $url;
    protected string $savePath = "./";


    protected array $proxyList = [];

    public function setSourceUrl(string $url): M3u8Down
    {
        $this->url = $url;
        return $this;
    }

    public function setSavePath($savePath): M3u8Down
    {
        if($savePath) $this->savePath = $savePath;
        return $this;
    }

    public function setProxy($proxyList=[]){
        if(!empty($proxyList)){
            $this->proxyList = $proxyList;
        }
    }

    /**
     * @throws GuzzleException
     * @throws SpiderException
     */
    public function downFile($sourceUrl, $fileName): string
    {
        $client = new Client([
            'timeout'  => 30,
            'verify' => false,
            'http_errors' => false,
            'allow_redirects' => [
                'max'             => 10,       // allow at most 10 redirects.
                'strict'          => true,     // use "strict" RFC compliant redirects.
                'referer'         => true,     // add a Referer header
                'protocols'       => ['http', 'https'], // only allow https URLs
                'track_redirects' => true
            ]
        ]);
        $response = $client->get($sourceUrl, [
            RequestOptions::SINK => $this->savePath . $fileName,
        ]);
        if ($response->getStatusCode() == 200) {
            return $this->savePath . $fileName;
        } else {
            throw new SpiderException('Failed to download image', -100);
        }
    }

    /**
     * @throws GuzzleException
     * @throws SpiderException
     */
    public function down(){

        $client = new \GuzzleHttp\Client([
//                'proxy' => $this->proxyList[rand(0,count($this->proxyList)-1)],
        ]);
        $response = $client->get($this->url,[
            'verify' => false,
            'http_errors' => false,
            'Content-Type' => 'application/vnd.apple.mpegurl',
        ]);
        $this->downFile($this->url, basename($this->url));
        $content = (string)$response->getBody();
        if (preg_match_all('/(http|https):\/\/.*/', $content, $matches)
            || preg_match_all('/.+\.ts/', $content, $matches)) {
            $count = count($matches[0]);
            foreach ($matches[0] as $key => $value) {
                if (strpos($value, 'http') === false) {
                    $parse_url_result = parse_url($this->url);
                    $url_path = $parse_url_result['path'];
                    $arr = explode('/', $url_path);
                    array_splice($arr, -1);
                    $url_path_pre = $parse_url_result['scheme'] . "://" . $parse_url_result['host'] . implode('/', $arr) . "/";
                    $sourceFile = $url_path_pre . $value;
                    $this->downFile($sourceFile, $this->savePath . $value);
                }
            }
        }
    }
}