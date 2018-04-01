<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 01/04/2018
 * Time: 2:51 PM
 */

namespace App\ElasticSearchModels;

use App\ElasticSearchModels\ElasticSearchModel;

class ItemElasticSearchModel extends ElasticSearchModel
{
    protected $type = '_doc';
    protected $size = 4;

    public function getAll($index){
        $params = [
            'index' => $index,
            'type' => '_doc',
        ];

        $response = $this->client->search($params);
        return $response;
    }

    public function search($index, $name){
        $params = [
            'index' => $index,
            'type' => $this->type,
            'body' => [
                'query' => [
                    'match' => [
                        'name' => $name
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);
        return $response;
    }

    public function find($index, $id){
        $params = [
            'index' => $index,
            'id' => $id
        ];

        $response = $this->client->get($params);
        return $response;
    }

}