<?php
/**
 * @desc EuroMillionsTest.php
 * @auhtor Wayne
 * @time 2023/11/22 15:00
 */

use dasher\spider\Client;
use PHPUnit\Framework\TestCase;
class ClientSpiderTest extends TestCase{

    /**
     * @throws \dasher\spider\exception\SpiderException
     */
    public function testClientSpider(){
        $client = new Client();
        $result1 = $client->getResult(Client::NAMESPACE_POWER_BALL, 'PowerBallCom');
        $result2 = $client->getResult(Client::NAMESPACE_POWER_BALL, 'PowerBallNet');
        $this->assertTrue($result1 == $result2);

        $result1 = $client->getResult(Client::NAMESPACE_EURO_MILLIONS, 'EuroMillionsCom');
        $result2 = $client->getResult(Client::NAMESPACE_EURO_MILLIONS, 'RedFoxLottoCom');
        $this->assertTrue($result1 == $result2);

        $result1 = $client->getResult(Client::NAMESPACE_IRELAND_LOTTO, 'LotteryTextsCom');
        $result2 = $client->getResult(Client::NAMESPACE_IRELAND_LOTTO, 'MagaYoCom');
        $this->assertTrue($result1 == $result2);


        $result1 = $client->getResult(Client::NAMESPACE_LOTTO_UK, 'AgentLottoCom');
        $result2 = $client->getResult(Client::NAMESPACE_LOTTO_UK, 'LottoParkCom');
        $result3 = $client->getResult(Client::NAMESPACE_LOTTO_UK, 'NationalLotteryCoUk');
        $this->assertTrue($result3 == $result2);
        $this->assertTrue($result1 == $result3);

        $result1 = $client->getResult(Client::NAMESPACE_MEGA_MILLIONS, 'LottoParkCom');
        $result2 = $client->getResult(Client::NAMESPACE_MEGA_MILLIONS, 'MagaYoCom');
        $result3 = $client->getResult(Client::NAMESPACE_MEGA_MILLIONS, 'RedFoxLottoCom');
        $this->assertTrue($result3 == $result2);
        $this->assertTrue($result1 == $result3);
    }


}