<?php
require_once __DIR__ .'/../../src/insight-api.php';

use zinntikumugai\InsightApi\InsightApi;

class insightapiTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $urls = ['https://insight.bitzeny.jp/api'];

    protected function _before() {
    }

    protected function _after() {
    }


}
