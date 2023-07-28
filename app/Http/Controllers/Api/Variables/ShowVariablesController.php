<?php
namespace App\Http\Controllers\Api\Variables;

use App\Http\Controllers\Controller;
use App\Models\VariablesModel;

class ShowVariablesController extends Controller
{
    public function get_var(string $key) {
        $var = VariablesModel::where('key', $key);
        if (!$var->exists()) {
            return response()->json([
                'error' =>  'The requested setting couldn\'t found',
            ], 404);
        }

        return response()->json([
            'data' => $var->get(),
        ]);
    }

    public function get_all() {
        return response()->json([
            'data' =>   VariablesModel::all()->where('publicable', '=', true),
        ]);
    }
}