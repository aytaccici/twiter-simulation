<?php

namespace App\Services\Utility;

use Illuminate\Http\Resources\Json\JsonResource;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonResponseService
 * @package App\Services
 */
class JsonResponseService
{
    /**
     * @param array $resource
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($resource = [], $code = Response::HTTP_OK)
    {
        return $this->putAdditionalMeta($resource, 'success')
            ->response()
            ->setStatusCode($code);
    }


    /**
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function fail($code = Response::HTTP_UNPROCESSABLE_ENTITY, $message = 'Failed')
    {
        return $this->putAdditionalMeta([], $message,$code)
            ->response()
            ->setStatusCode($code);
    }

    /**
     * @param array $resource
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function noContent($resource = [], $code = Response::HTTP_NO_CONTENT)
    {
        return $this->putAdditionalMeta($resource, 'success')
            ->response()
            ->setStatusCode($code);
    }


    /**
     * @param array $resource
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbidden($code = Response::HTTP_FORBIDDEN)
    {
        return $this->putAdditionalMeta([], 'Access Denied')
            ->response()
            ->setStatusCode($code);
    }


    /**
     * @param $resource
     * @param $message
     * @param int $errorCode
     * @return JsonResource
     */
    private function putAdditionalMeta($resource, $message, $errorCode = -1)
    {
        $meta   = [
            'message'   => $message,
            'errorCode' => $errorCode

        ];
        $merged = array_merge($resource->additional ?? [], $meta);

        if ($resource instanceof JsonResource) {
            return $resource->additional($merged);
        }

        if (is_array($resource)) {
            return (new JsonResource(collect($resource)))->additional($merged);
        }

        throw new Exception('Invalid type of resource.');
    }
}
