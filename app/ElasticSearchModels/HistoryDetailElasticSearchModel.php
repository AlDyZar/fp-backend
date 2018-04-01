<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 01/04/2018
 * Time: 7:02 PM
 */

namespace App\ElasticSearchModels;


class HistoryDetailElasticSearchModel extends ElasticSearchModel
{
    protected $index = 'history';
    protected $type = '_doc';

    public function getAll($history_id){
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'body' => [
                'query' => [
                    'match' => [
                        'history_id' => $history_id
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);
        return $response;
    }
}