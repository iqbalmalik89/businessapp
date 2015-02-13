<?php
require 'vendor/autoload.php';
$app = new \Slim\Slim(array(
    'debug' => true
));

/*
* HTTP STATUS CODES
* 200 ok
* 400 Bad Request
* 401 Unauthorized
* 409 Conflict
*/

function response($code, $dataAry)
{
    if($code != 200)
    {
        $dataAry['status'] = 'error';        
    }
    else
    {
        $dataAry['status'] = 'success'; 
    }

    $response = $GLOBALS['app']->response();
    $response['Content-Type'] = 'application/json';
    $response->status($code);
    $response->body(json_encode($dataAry));
}


/*
* JSON middleware
* It Always make sure, response is in the form of JSON
* We also initiate database connection here
*/

$app->add(new JsonMiddleware('/api'));

/*
* Grouped routes
*/

$app->group('/api', function () use ($app) {

    // Add Category
    $app->post('/category' , function () use ($app){

        $new = new CategoryRepo();
        $code = $new->addCategory($app->request);
        response($code, array());
    });

    // Update Category
    $app->put('/category' , function () use ($app){

        $new = new CategoryRepo();
        $code = $new->updateCategory($app->request);
        response($code, array());
    });    

});




$app->run();