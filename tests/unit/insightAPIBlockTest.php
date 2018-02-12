<?php
use zinntikumugai\InsightApi\InsightApi;

class insightAPIBlockTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $urls = ['https://insight.bitzeny.jp/api'];
    private $address = 'Zfj7VPcdnDvLGE5t8WCYK6AGXVmNapc9Tx';
    private $blockhash = '000000001dd4db607d0bd902947e56a68037adba6af41a8c15bad8c2f63e0cbf';
    private $index = '1135176';
    private $summaries = [1, '2018-1-1'];
    private $API = null;

    private $TMP = [];

    protected function _before() {
        $this->API = new InsightApi($this->urls);
        $this->TMP['blockhash'] = [
            'blockHash' => "000000001dd4db607d0bd902947e56a68037adba6af41a8c15bad8c2f63e0cbf"
        ];

        $this->TMP['block'] = [
            "hash" => "000000001dd4db607d0bd902947e56a68037adba6af41a8c15bad8c2f63e0cbf",
            "confirmations" => 85,  //nop
            "size" => 245,
            "height" => 1135176,
            "version" => 536870912,
            "merkleroot" => "d02b565c1b0806d10edd15b85bc4846fc27880d1b9a92e6889bfd329660d2420",
            "tx" => [
                "d02b565c1b0806d10edd15b85bc4846fc27880d1b9a92e6889bfd329660d2420"
            ],
            "time" => 1518431702,
            "nonce" => 1002940970,
            "bits" => "1d01364f",
            "difficulty" => 0.82497262,
            "chainwork" => "0000000000000000000000000000000000000000000000000000c8bced1d47f7",
            "previousblockhash" => "000000009df383b7b90876730e9480a11684802fa43d0e9a4cbe707cc4b74eac",
            "nextblockhash" => "00000000e4c0c56d5c9af67537b9f24dca88a063dd4af4a1f98fedaa8b5922e0",
            "reward" => 1.5625,
            "isMainChain" => true
        ];
        $this->TMP['blocks'] = [
            "blocks" => [
                [
                    "height" => 1095701,
                    "size" => 66803,
                    "hash" => "0000000086ee86439bf6d2658135fff5019e014d03c2e3f410fe2b55dfa967cc",
                    "time" => "1514851182",
                    "txlength" => 185
                ],
                [
                    "height" => 1095700,
                    "size" => 10706,
                    "hash" => "00000000ce9c4a43f9d092c5c1b46d7e3a2e44c4336c616a1cee11f113ed66d9",
                    "time" => "1514850948",
                    "txlength" => 34
                ]
            ],
            "length" => 2,
            "pagination" => [
                "next" => "2018-01-02",
                "prev" => "2017-12-31",
                "currentTs" => 1514851199,
                "current" => "2018-1-1",
                "isToday" => false,
                "more" => true,
                "moreTs" => "1514850948"
            ]
        ];
        foreach ($this->TMP['blocks']['blocks'] as $key => $value) {
            $this->TMP['blocks']['blocks'][$key] = (object)$value;
        }
        $this->TMP['blocks']['pagination'] = (object)$this->TMP['blocks']['pagination'];
    }

    protected function _after() {
    }

    public function testGetBlockIndex() {
        $this->API->getBlockIndex($this->index);
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], (object)$this->TMP['blockhash']);
    }

    public function testGetBlock() {
        $this->API->getBlock($this->blockhash);
        $DATA = $this->API->run();
        $this->TMP['block']['confirmations'] = $DATA[0]->confirmations;
        $this->assertEquals($DATA[0], (object)$this->TMP['block']);
    }

    public function testGetBlockSummaries() {
        $this->API->getBlockSummaries($this->summaries[0], $this->summaries[1]);
        $DATA = $this->API->run();
        $this->assertEquals($DATA[0], (object)$this->TMP['blocks']);
    }

}
