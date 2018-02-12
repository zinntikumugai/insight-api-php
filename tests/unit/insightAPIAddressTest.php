<?php
use zinntikumugai\InsightApi\InsightApi;

class insightAPIAddressTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $urls = ['https://insight.bitzeny.jp/api'];
    private $address = 'Zfj7VPcdnDvLGE5t8WCYK6AGXVmNapc9Tx';
    private $API = null;

    private $TMP = [];

    protected function _before() {
        $this->API = new InsightApi($this->urls);
        $this->TMP['data'] = [
            'addrStr' => "Zfj7VPcdnDvLGE5t8WCYK6AGXVmNapc9Tx",
            'balance' => 1.43,
            'balanceSat' => 143000000,
            'totalReceived' => 1.43,
            'totalReceivedSat' => 143000000,
            'totalSent' => 0,
            'totalSentSat' => 0,
            'unconfirmedBalance' => 0,
            'unconfirmedBalanceSat' => 0,
            'unconfirmedTxApperances' => 0,
            'txApperances' => 2,
            'transactions' => [
                '2c738c9e08b256c9c54eb25f8c22f86841c8a08ff5293d303b75ca8d63ef86a0',
                'fd48320f620753da0af738d9802aae90805ad3e66cf027e4b638b7ca3f15dcb5'
            ]
        ];

        $this->TMP['upspet'] = [
            [
                'address' => "Zfj7VPcdnDvLGE5t8WCYK6AGXVmNapc9Tx",
                'txid' => "2c738c9e08b256c9c54eb25f8c22f86841c8a08ff5293d303b75ca8d63ef86a0",
                'vout' => 1,
                'ts' => 1518431925,
                'scriptPubKey' => "76a9142fb51f3c703a71ca2c9c828301fb0ce6292c1c6d88ac",
                'amount' => 0.13,
                'confirmations' => 6,
                'confirmationsFromCache' => true
            ],
            [
                'address' => "Zfj7VPcdnDvLGE5t8WCYK6AGXVmNapc9Tx",
                'txid' => "fd48320f620753da0af738d9802aae90805ad3e66cf027e4b638b7ca3f15dcb5",
                'vout' => 1,
                'ts' => 1518431925,
                'scriptPubKey' => "76a9142fb51f3c703a71ca2c9c828301fb0ce6292c1c6d88ac",
                'amount' => 1.3,
                'confirmations' => 6,
                'confirmationsFromCache' => true
            ]
        ];
        foreach ($this->TMP['upspet'] as $key => $value) {
            $this->TMP['upspet'][$key] = (object)$value;
        }

    }

    protected function _after() {
    }

    public function testGetAddressData() {
        $this->API->getAddressData($this->address);
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], (object)$this->TMP['data']);
    }

    public function testGetAddressDataSelectBalance() {
        $this->API->getAddressDataSelect($this->address);
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], $this->TMP['data']['balanceSat']);
    }

    public function testGetAddressDataSelectTotalReceived() {
        $this->API->getAddressDataSelect($this->address, 'totalReceived');
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], $this->TMP['data']['totalReceivedSat']);
    }

    public function testGetAddressDataSelectTotalSent() {
        $this->API->getAddressDataSelect($this->address, 'totalSent');
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], $this->TMP['data']['totalSentSat']);
    }

    public function testGetAddressDataSelectUnconfirmedBalance() {
        $this->API->getAddressDataSelect($this->address, 'unconfirmedBalance');
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], $this->TMP['data']['unconfirmedBalanceSat']);
    }

    public function testGetAddressUnspetOutput() {
        $this->API->getAddressUnspetOutput($this->address);
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], $this->TMP['upspet']);
    }

    public function testGetAddressUnspetOutputs() {
        $this->API->getAddressUnspetOutputs($this->address);
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], $this->TMP['upspet']);
    }

    public function testGetAddressUnspetOutputsArray() {
        $this->API->getAddressUnspetOutputs([$this->address]);
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], $this->TMP['upspet']);
    }
}
