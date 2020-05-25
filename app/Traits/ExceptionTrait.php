<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

trait ExceptionTrait {

    public function apiException($request, $e) 
    {
        if($this->isModel($e)) {
            return $this->ModelResponse($e);
        } 

        if($this->isRoute($e)) {
            return $this->RouteResponse($e);
        }

        return parent::render($request, $e);
    }

    protected function isModel($e) 
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isRoute($e) 
    {
        return $e instanceof NotFoundHttpException;
    }

    protected function ModelResponse($e) 
    {
        return response()->json([
            'error' => 'Model not found'
        ], Response::HTTP_NOT_FOUND);
    }

    protected function RouteResponse($e) 
    {
        return response()->json([
            'error' => 'Route not found'
        ], Response::HTTP_NOT_FOUND);
    }
}