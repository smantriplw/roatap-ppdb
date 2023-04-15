<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidApiRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
    use ValidatesRequests, AuthorizesRequests, DispatchesJobs;

    public function __invoke()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function rules(): array {
        return [
            //
        ];
    }

    public function validation_messages(): array {
        return [
            //
        ];
    }

    public function validate_request(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->rules(), $this->validation_messages(), []);
        if ($validator->fails()) {
            throw new InvalidApiRequest($validator, $request->all());
        }
    }
}
