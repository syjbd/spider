<?php
/**
 * @desc LotteryAddaCom.php
 * @auhtor Wayne
 * @time 2023/12/6 11:15
 */
namespace dasher\spider\lib\kerala;

use dasher\spider\exception\SpiderException;
use dasher\spider\lib\QuerySpider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class LotteryAddaCom extends QuerySpider{

    protected string $listUrl = 'https://api.staging.lotteryadda.com/home/index';
    protected string $infoUrl = "https://api.staging.lotteryadda.com/home/getPlanDetail/<id>";
    protected string $listResultUrl = "https://api.staging.lotteryadda.com/lottery/getOpenIssues?pageNum=<page>&pageSize=<limit>";
    protected string $infoResultUrl = "https://api.staging.lotteryadda.com/lottery/officeResult/<id>";
    /**
     * @throws GuzzleException
     * @throws SpiderException
     */
    public function getContent($url)
    {
        $options = [
            RequestOptions::VERIFY => false, # disable SSL certificate validation
            RequestOptions::TIMEOUT => 30, # timeout of 30 seconds
        ];
        if(!empty($this->proxy)) $options[RequestOptions::PROXY] = $this->proxy;
        $client= new Client($options);
        $response = $client->get($url);
        if($response->getStatusCode() == 200) {
            $content = (string)$response->getBody();
            return json_decode($content, true);
        }else{
            throw new SpiderException('Kerala GuzzleHttp err!');
        }
    }

    /**
     * @throws GuzzleException
     * @throws SpiderException
     */
    public function getList(): array
    {
        $data = $this->getContent($this->listUrl);
        $list = [];
        if(!empty($data['data']['homePlanResult']['lotteryType'][0]['list'])){
            $list = array_merge($data['data']['homePlanResult']['lotteryType'][0]['list'][0]['list']);
        }
        if(!empty($data['data']['homePlanResult']['lotteryType'][1]['list'])){
            $list = array_merge($data['data']['homePlanResult']['lotteryType'][1]['list'][0]['list']);
        }
        return $list;
    }

    /**
     * @throws SpiderException
     * @throws GuzzleException
     */
    public function getInfo($id){
        $infoUrl =  str_replace('<id>', $id, $this->infoUrl);
        $data = $this->getContent($infoUrl);
        if($data['code'] !== 200) throw new SpiderException('Kerala id err');
//        $lotteryGamePlan = $data['data']['lotteryGamePlan'];
//        $issueData = [
//            'issue_no'      => $lotteryGamePlan['issueNum'],
//            'issue_img'     => $lotteryGamePlan['lotteryPic'],
//            'issue_name'    => $lotteryGamePlan['lotteryName'],
//            'first_letter'  => $lotteryGamePlan['firstLetter'],
//            'second_letter' => $lotteryGamePlan['twelveLetter'],
//            'open_time'     =>  strtotime($lotteryGamePlan['openDate']),
//            'start_time'    =>  strtotime($lotteryGamePlan['startDate']),
//        ];
//        $data['odds'] = $this->getOdds($data['data']['lotteryPrizeDetails']);
        return $data['data'];
    }

//    public function getOdds($odds){
//        $data = [];
//        foreach ($odds as $odd){
//            if($odd['prizeName'] != 'Online exclusive')
//            $data[] = [
//                'title'     => $odd['prizeName'],
//                'reward' => $odd['prizeMoney'],
//                'remark' => $odd['prizeDetail'],
//                'sort'  => $odd['sort'],
//                'num'   => $odd['prizeNum'],
//                'total' => $odd['totalPrizeMoney'],
//            ];
//                $data[] = $odd;
//        }
//        return $data;
//    }

    /**
     * @throws GuzzleException
     * @throws SpiderException
     */
    public function getResult($id){
        $infoUrl =  str_replace('<id>', $id, $this->infoResultUrl);
        $data = $this->getContent($infoUrl);
        return $data['data'];
    }
}