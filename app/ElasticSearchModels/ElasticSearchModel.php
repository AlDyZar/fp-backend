<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 01/04/2018
 * Time: 10:35 PM
 */

namespace App\ElasticSearchModels;

use Elasticsearch\ClientBuilder;

class ElasticSearchModel
{
    public function __construct(ClientBuilder $cb)
    {
        $hosts = [
            'http://localhost:9200'
        ];
        $this->client = ClientBuilder::create()->setHosts($hosts)->build();
    }
}