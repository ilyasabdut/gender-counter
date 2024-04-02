<?php

use Illuminate\Pagination\LengthAwarePaginator;

function api($message,$statusCode,$model = null) {
    $meta = [];
    if($model instanceof LengthAwarePaginator){
        $meta = Arr::except($model->toArray, [
            'data', 'links', 'last_page_url', 'first_page_url', 'next_page_url', 'path', 'prev_page_url'
        ]);
        $model = $model->items();

    }

    return response()->json([
        'statusCode' => $statusCode,
        'message'  => $message,
        'data' => $model,
        'meta' => $meta
    ]);
}
