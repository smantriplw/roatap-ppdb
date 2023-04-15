<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

class InvalidApiRequest extends Exception
{
    private MessageBag $bag;
    private $actualData;

    public function __construct(Validator $validator, $actualData)
    {
        parent::__construct();

        $this->bag = $validator->errors();
        $this->actualData = $actualData;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            '$actual' => $this->actualData,
            'errors' => $this->bag->toArray(),
        ], 401);
    }
}
