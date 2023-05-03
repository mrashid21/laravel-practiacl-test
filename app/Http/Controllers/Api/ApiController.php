<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Resources\Api\v1\SuccessResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class ApiController extends Controller
{
    /**
     * Generate success response
     *
     * @param $data
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function successResponse($data, string $message = 'Successful')
    {
        $result = [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];

        if (isset($data->resource) && $data->resource instanceof LengthAwarePaginator) {
            $result['pagination'] = $this->setPaginationData($data);
        }

        return response()->json($result, 200);
    }
    
    protected function failedResponse($data, string $message = 'Failed')
    {
        $result = [
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ];

        return response()->json($result, 400);
    }

    /**
     * Set pagination data.
     *
     * @param $data
     *
     * @return array
     */
    protected function setPaginationData($data)
    {
        $paginationData = Arr::except($data->resource->toArray(), ['data', 'links']);

        return [
            'total' => $paginationData['total'],
            'from' => $paginationData['from'],
            'to' => $paginationData['to'],
            'current_page' => $paginationData['current_page'],
            'per_page' => (int) $paginationData['per_page'],
            'last_page' => $paginationData['last_page'],
            'first_page_url' => $paginationData['first_page_url'],
            'last_page_url' => $paginationData['last_page_url'],
            'next_page_url' => $paginationData['next_page_url'],
            'prev_page_url' => $paginationData['prev_page_url'],
        ];
    }
}
