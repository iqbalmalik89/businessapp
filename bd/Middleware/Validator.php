<?php

class Validator extends \Slim\Middleware
{
    public function call()
    {
        //The Slim application
        $app = $this->app;

        //The Environment object
        $env = $app->environment;

        //The Request object
        $req = $app->request;

        $requestMethod = $req->getMethod();
        $requestUri = $req->getResourceUri();

		$requestData = json_decode($req->getBody());


        $this->next->call();
        
        //The Response object
        $res = $app->response;
    }

    public function resolveMiddleWare($requestMethod, $requestUri)
    {
        $rules = array();
    }



}

