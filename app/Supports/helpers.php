<?php

use Illuminate\Pagination\LengthAwarePaginator;

function api($message,$statusCode,$model = null) {
    $meta = [];

    if($statusCode == 200){
         $meta = [
            'total' => $model->count()
        ];
        
        if(!is_null($model) && $model instanceof LengthAwarePaginator){
            $meta = Arr::except($model->toArray(), [
                'data', 'links', 'last_page_url', 'first_page_url', 'next_page_url', 'path', 'prev_page_url'
            ]);
            $model = $model->items();
        }
    }

    $response = [
        'statusCode' => $statusCode,
        'message'  => $message,
        'data' => $model,
        'meta' => $meta
    ];


    return response()->json($response,$statusCode);
}

function randomUser(){
    $request = Http::baseUrl(config('integration.random_user.url'))->asJson();

    return $request;
}

