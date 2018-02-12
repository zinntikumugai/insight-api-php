<?php
namespace zinntikumugai\InsightApi;

use mpyw\Co\Co;
use mpyw\Co\CURLException;

class InsightApi {

    private $url = null;
    private $URLs = [];   //curl Address

    function __construct($arg) {
        // https://insight.bitzeny.jp/api/
        $this->url = $arg[0];
    }

    public function getURL() {
        return $this->url;
    }

    public function getURLs() {
        return $this->URLs;
    }

    public function resetURLs() {
        $this->URLs = [];
    }

    public function run($flg = false) {
        $C_URLs = [];
        foreach ($this->URLs as $key => $url) {
            $C_URLs[] = self::get($url);
            echo "[$key]: $url".PHP_EOL;
        }
        $DataStrs = Co::wait($C_URLs);
        $Datas = [];

        foreach ($DataStrs as $str) {
            if(!$flg)
                $Datas[] = json_decode($str);
            else
                $Datas[] = $str;
        }
        return $Datas;
    }

    public function get($url, $ops = []) {
		$ch = curl_init();
		$ops = array_replace([
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
		], $ops);
		curl_setopt_array($ch, $ops);
		return $ch;
	}

    public function getAddressData($addr, $ops = null) {
        if($ops !== null)
            $url = $this->url .'/addr/' .$addr .'?' .http_build_query($ops);
        else
            $url = $this->url .'/addr/' .$addr;
        $this->URLs[] = $url;
        return $url;
    }

    public function getAddressDataSelect($addr, $properties = 'balance') {
        $prt = '';
        switch ($properties) {
            case 'balance':
            case 'Balance':
                $prt = 'balance';
                break;

            case 'totalReceived':
            case 'totalreceived':
            case 'Totalreceived':
            case 'TotalReceived':
                $prt = 'totalReceived';
                break;

            case 'totalSent':
            case 'totalsent':
            case 'TotalSent':
            case 'Totalsent':
                $prt = 'totalSent';
                break;

            case 'unconfirmedBalance':
            case 'unconfirmedbalance':
            case 'UnconfirmedBalance':
            case 'UnconfirmedBalance':
                $prt = 'unconfirmedBalance';
                break;

            default:
                return null;
                break;
        }
        $url = $this->url .'/addr/' .$addr .'/' .$prt;
        $this->URLs[] = $url;
        return $url;
    }

    public function getAddressUnspetOutput($addr) {
        $url = $this->url .'/addr/' .$addr .'/utxo';
        $this->URLs[] = $url;
        return $url;
    }

    public function getAddressUnspetOutputs($addrs) {
        if(is_array($addrs))
            $addr = implode(',', $addrs);
        else
            $addr = $addrs;
        $url = $this->url .'/addrs/' .$addr .'/utxo';
        $this->URLs[] = $url;
        return $url;
    }

    public function getBlock($hash) {
        $url = $this->url .'/block/' .$hash;
        $this->URLs[] = $url;
        return $url;
    }

    public function getBlockIndex($height) {
        $url = $this->url .'/block-index/' .$height;
        $this->URLs[] = $url;
        return $url;
    }

    public function getBlockSummaries($limit, $date) {
        $ops = [
            'limit' => $limit,
            'blockDate' => $date
        ];
        $url = $this->url .'/blocks?' .http_build_query($ops);
        $this->URLs[] = $url;
        return $url;
    }

    public function getStatusSync() {
        $url = $this->url .'/sync';
        $this->URLs[] = $url;
        return $url;
    }

    public function getStatusPeer() {
        $url = $this->url .'/peer';
        $this->URLs[] = $url;
        return $url;
    }

    public function getStatusNetwork($action = 'getinfo') {
        switch ($action) {
            case 'getinfo':
            case 'getDifficulty':
            case 'getBestBlockHash':
            case 'getLastBlockHash':
                $url =  $this->url .'/status?q=' .$action;
                break;

            default:
                $url = null;
                break;
        }

        $this->URLs[] = $url;
        return $url;
    }

    public function getTransaction($txid) {
        $url = $this->url .'/tx/' .$txid;
        $this->URLs[] = $url;
        return $url;
    }

    public function getRawTransaction($rawid) {
        $url = $this->url .'/rawtx/' .$txid;
        $this->URLs[] = $url;
        return $url;
    }

    public function getTransactionsBlock($hash) {
        $url = $this->url .'/txs/?block=' .$hash;
        $this->URLs[] = $url;
        return $url;
    }

    public function getTranasctionsAddress($addr) {
        $url = $this->url .'/txs/?address=' .$addr;
        $this->URLs[] = $url;
        return $url;
    }
}

?>
