<?php
use zinntikumugai\InsightApi\InsightApi;

class insightAPIStatusTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $urls = ['https://insight.bitzeny.jp/api'];
    private $address = 'Zfj7VPcdnDvLGE5t8WCYK6AGXVmNapc9Tx';
    private $TMP = [];

    protected function _before() {
        $this->API = new InsightApi($this->urls);

    }

    protected function _after() {
    }


}
