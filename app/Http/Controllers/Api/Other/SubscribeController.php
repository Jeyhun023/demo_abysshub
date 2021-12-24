<?php

namespace App\Http\Controllers\Api\Other;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Http\Resources\Other\SubscribeResource;
use App\Models\Subscribe;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class SubscribeController extends Controller
{
    use ApiResponser;

    public function subscribe(SubscribeRequest $request)
    {
        try {
            $subscribe = new Subscribe([
                'email' => $request->email
            ]);
            $subscribe->save();
            
            return $this->successResponse(new SubscribeResource($subscribe), trans('messages.subscribe_success'));
        } catch (Exception $e) {
            return $this->errorResponse(["failed" => [trans('messages.failed')] ]);
        }
        
    }
}
