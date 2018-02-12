<?php
use zinntikumugai\InsightApi\InsightApi;

class insightAPITransactionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $urls = ['https://insight.bitzeny.jp/api'];
    private $address = 'Zfj7VPcdnDvLGE5t8WCYK6AGXVmNapc9Tx';
    private $transaction = '2c738c9e08b256c9c54eb25f8c22f86841c8a08ff5293d303b75ca8d63ef86a0';
    private $TMP = [];

    protected function _before() {
        $this->API = new InsightApi($this->urls);
        $this->TMP['transaction'] =  [
            "txid" => "2c738c9e08b256c9c54eb25f8c22f86841c8a08ff5293d303b75ca8d63ef86a0",
            "version" => 1,
            "locktime" => 1135093,
            "vin" => [
                [
                    "txid" => "15792212ea7311e13f2803f4e512cdeb21380589b150ad3af6c386e5c16ff871",
                    "vout" => 0,
                    "scriptSig" => [
                          "asm" => "30440220513de38e0d5875c4b84197dd981d2175818363e0f622741fcaeffa7c7bf5f48402207dbf2b1e549b993e10e96621ce9de44b21021f63fa5d683e5500ad42350b1a0a01 037dec9514db4f3bf4f0899aaee62a1de99dbbe44da3d021316b5a3df95b76123f",
                          "hex" => "4730440220513de38e0d5875c4b84197dd981d2175818363e0f622741fcaeffa7c7bf5f48402207dbf2b1e549b993e10e96621ce9de44b21021f63fa5d683e5500ad42350b1a0a0121037dec9514db4f3bf4f0899aaee62a1de99dbbe44da3d021316b5a3df95b76123f"
                    ],
                    "sequence" => 4294967294,
                    "n" => 0,
                    "addr" => "Ze78zujsyWEAQj1xbupYNV2TcczV7WtNyV",
                    "valueSat" => 50000000,
                    "value" => 0.5,
                    "doubleSpentTxID" => null,
                    "isConfirmed" => true,
                    "confirmations" => 202206,
                    "unconfirmedInput" => false
                ]
            ],
            "vout" => [
                [
                    "value" => "0.36999774",
                    "n" => 0,
                    "scriptPubKey" => [
                        "asm" => "OP_DUP OP_HASH160 74cea63cb73ea9c96ffc3a4ae3302d08d6899908 OP_EQUALVERIFY OP_CHECKSIG",
                        "hex" => "76a91474cea63cb73ea9c96ffc3a4ae3302d08d689990888ac",
                        "reqSigs" => 1,
                        "type" => "pubkeyhash",
                        "addresses" => [
                            "Zn2UhJFa39f8QBSqcZgFdzkTJfTDyyTPRH"
                        ]
                    ]
                ],
                [
                    "value" => "0.13000000",
                    "n" => 1,
                    "scriptPubKey" => [
                        "asm" => "OP_DUP OP_HASH160 2fb51f3c703a71ca2c9c828301fb0ce6292c1c6d OP_EQUALVERIFY OP_CHECKSIG",
                        "hex" => "76a9142fb51f3c703a71ca2c9c828301fb0ce6292c1c6d88ac",
                        "reqSigs" => 1,
                        "type" => "pubkeyhash",
                        "addresses" => [
                            "Zfj7VPcdnDvLGE5t8WCYK6AGXVmNapc9Tx"
                        ]
                    ]
                ]
            ],
            "blockhash" => "00000000723a221061433baf366df2a66e0fb3a4d9a0e7e40b6c8290bcdddde3",
            "confirmations" => 119,
            "time" => 1518431925,
            "blocktime" => 1518431925,
            "valueOut" => 0.49999774,
            "size" => 225,
            "valueIn" => 0.5,
            "fees" => 2.26E-6
        ];

        foreach ($this->TMP['transaction']['vin'] as $key => $value) {
            $this->TMP['transaction']['vin'][$key]['scriptSig'] = (object)$this->TMP['transaction']['vin'][$key]['scriptSig'];
            $this->TMP['transaction']['vin'][$key] = (object)$this->TMP['transaction']['vin'][$key];
        }
        foreach ($this->TMP['transaction']['vout'] as $key => $value) {
            $this->TMP['transaction']['vout'][$key]['scriptPubKey'] = (object)$this->TMP['transaction']['vout'][$key]['scriptPubKey'];
            $this->TMP['transaction']['vout'][$key] = (object)$this->TMP['transaction']['vout'][$key];
        }
    }

    protected function _after() {
    }

    public function testGetTransaction() {
        $this->API->getTransaction($this->transaction);
        $DATA = $this->API->run();
        $this->TMP['transaction']['confirmations'] = $DATA[0]->confirmations;
        foreach ($DATA[0]->vin as $key => $value) {
            $this->TMP['transaction']['vin'][$key]->confirmations = $value->confirmations;
        }
        $this->assertEquals($DATA[0], (object)$this->TMP['transaction']);
    }
}
