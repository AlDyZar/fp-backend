<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 01/04/2018
 * Time: 2:34 PM
 */

namespace App\ElasticSearchModels;

use Elasticsearch\ClientBuilder;

class HistoryElasticSearchModel extends ElasticSearchModel {

    protected $index = 'history';
    protected $type = '_doc';

    public function getAll($user_id){
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'body' => [
                'query' => [
                    'match' => [
                        'user_id' => $user_id
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);
        return $response;
    }
}