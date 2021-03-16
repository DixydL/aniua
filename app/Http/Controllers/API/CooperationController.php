<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cooperation;
use Illuminate\Http\Resources\Json\JsonResource;

class CooperationController extends Controller
{
    public function show()
    {
    }

    public function store(Request $request)
    {
       // dd($request->html);
        $cooperation = new Cooperation(
            [
                'html' => $request->html,
            ]
        );

        $cooperation->save();

        return new JsonResource($cooperation);
    }

    public function update(Cooperation $cooperation, Request $request)
    {
        $cooperation->fill(
            [
                'html' => $request->html,
            ]
        );

        $cooperation->save();

        return new JsonResource($cooperation);
    }
}
