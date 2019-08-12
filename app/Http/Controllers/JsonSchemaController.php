<?php

namespace App\Http\Controllers;

use App\Schemas\StockUpdateSchema;
use App\Http\Controllers\Controller;

class JsonSchemaController extends Controller
{
    public function stockUpdateSchema()
    {
        $schema = (new StockUpdateSchema)->get();

        return response($schema)->header('Content-Type', 'application/json');
    }
}
