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

*/
	$jsonParams = array();
	$formParams = $app->request->params();
	//var_dump($formParams);

	if(!$app->request->getBody())
	{
	    $jsonParams = json_decode($app->request->getBody(), TRUE);
	}

	$app->request = array_merge($jsonParams, $formParams);

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

    // Add Sub-Category
    $app->post('/sub_cat', function () use ($app){

    	$new  = new SubCatRepo();
    	//var_dump($app->request->getBody());
    	$code = $new->addSubCategory($app->request);
    	response($code,array());

    });

    // Update Sub-Category
    $app->put('/sub_cat' , function () use ($app){

        $new = new SubCatRepo();
        $code = $new->updateSubCategory($app->request);
        response($code, array());
    }); 

    // Delete Sub-Category
    $app->delete('/sub_cat' , function () use ($app){

        $new = new SubCatRepo();
        $code = $new->deleteSubCategory($app->request);
        response($code, array());
    }); 

    // Get Sub-Categories either of a given category or all sub-categories
    $app->get('/sub_cat' , function () use ($app){

        $new = new SubCatRepo();
        $code = $new->getSubCategory($app->request);
        response($code, $code['data']);
    }); 

    // Login
    $app->post('/login' , function () use ($app){

        $new = new LoginRepo();
        $code = $new->login($app->request);
        response($code, $code['data']);
    }); 
    
});




$app->run();