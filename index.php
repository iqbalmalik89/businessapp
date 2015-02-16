<?php
require 'vendor/autoload.php';
session_cache_limiter(false);
session_start();
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
    $data = $app->request->getBody();

	if(!empty($data))
	{
	    $decodeJsonParams = json_decode($data, TRUE);
        if(is_array($decodeJsonParams))
            $jsonParams = $decodeJsonParams;
	}

	$app->requestdata = array_merge($jsonParams, $formParams);
    //var_dump($app->requestdata);

/*
* Grouped routes
*/

$app->group('/api', function () use ($app) {

    // Add Category
    $app->post('/category' , function () use ($app){
    	

        $new = new CategoryRepo();
        $code = $new->addCategory($app->requestdata);
        response($code, array());
    });

    // Update Category
    $app->put('/category' , function () use ($app){

        $new = new CategoryRepo();
        $code = $new->updateCategory($app->requestdata);
        response($code, array());
    });    

    // Update Category
    $app->delete('/category' , function () use ($app){
        $new = new CategoryRepo();
        $code = $new->deleteCategory($app->requestdata);
        response($code, array());
    });    

    // Add Sub-Category
    $app->post('/sub_cat', function () use ($app){

    	$new  = new SubCatRepo();
    	//var_dump($app->request->getBody());
    	$code = $new->addSubCategory($app->requestdata);
    	response($code,array());

    });

    // Update Sub-Category
    $app->put('/sub_cat' , function () use ($app){

        $new = new SubCatRepo();
        $code = $new->updateSubCategory($app->requestdata);
        response($code, array());
    }); 

    // Delete Sub-Category
    $app->delete('/sub_cat' , function () use ($app){

        $new = new SubCatRepo();
        $code = $new->deleteSubCategory($app->requestdata);
        response($code, array());
    }); 

    // Get Sub-Categories either of a given category or all sub-categories
    $app->get('/sub_cat' , function () use ($app){

        $new = new SubCatRepo();
        $code = $new->getSubCategory($app->requestdata);
        response($code, $code['data']);
    }); 

    // Login
    $app->post('/login' , function () use ($app){

        $new = new LoginRepo();
        $code = $new->login($app->requestdata);
        response($code, $code['data']);
    }); 

    $app->get('/logout' , function () use ($app){
        session_destroy();
        response(200, array());
    }); 

    $app->get('/categories' , function () use ($app){
        $new = new CategoryRepo();
        $resp = $new->getCategories($app->requestdata);
        response($resp['code'], array('data' => $resp['data']));
    }); 

    // Check Vendor Name
    $app->get('/vendor_name' , function () use ($app){

        $new = new VendorRepo();
        $code = $new->checkVendor($app->requestdata);
        response($code, $code['data']);
    });
    
});




$app->run();