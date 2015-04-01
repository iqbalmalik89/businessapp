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

/*
* Grouped routes
*/

$app->group('/api', function () use ($app) {

    // Add Category
    $app->post('/addcategory' , function () use ($app){
    	

        $new = new CategoryRepo();
        $code = $new->addCategory($app->requestdata);
        response($code, array());
    });

    // Update Category
    $app->post('/updatecategory' , function () use ($app){

        $new = new CategoryRepo();
        $code = $new->updateCategory($app->requestdata);
        response($code, array());
    });    

    // Delete Category
    $app->post('/deletecategory' , function () use ($app){
        $new = new CategoryRepo();
        $code = $new->deleteCategory($app->requestdata);
        response($code, array());
    });    

    // Add Sub-Category
    $app->post('/addsub_cat', function () use ($app){

    	$new  = new SubCatRepo();
    	//var_dump($app->request->getBody());
    	$code = $new->addSubCategory($app->requestdata);
    	response($code,array());

    });

    // Update Sub-Category
    $app->post('/updatesub_cat' , function () use ($app){

        $new = new SubCatRepo();
        $code = $new->updateSubCategory($app->requestdata);
        response($code, array());
    }); 

    // Delete Sub-Category
    $app->post('/deletesub_cat' , function () use ($app){

        $new = new SubCatRepo();
        $code = $new->deleteSubCategory($app->requestdata);
        response($code, array());
    }); 

    // Get Sub-Categories either of a given category or all sub-categories
    $app->get('/sub_cat' , function () use ($app){

        $new = new SubCatRepo();
        $code = $new->getSubCategory($app->requestdata);
        response($code['code'], array('data' => $code['data']));
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

    // Check event Name
    $app->get('/event_name' , function () use ($app){

        $new = new EventRepo();
        $code = $new->checkEvent($app->requestdata);

        if($code)
            response(400, array());
        else
            response(200, array());

    });


    // Add Business
    $app->post('/business_add', function() use ($app){

        $new = new VendorRepo();
        $code = $new->businessAdd($app->requestdata);
        response($code,array());
    });
    
      // Add vendor Images
    $app->post('/upload_images', function() use ($app){
        $new = new UtilityRepo();
        $resp = $new->uploadTmp($_FILES['file_data']);
        response($resp['code'],array("file_name" => $resp['file_name']));
    });

     // Add Vendor Working Days
    $app->post('/add_vendor_working_days', function() use ($app){

        $new = new VendorRepo();
        $code = $new->addVendorDays($app->requestdata);
        response($code,array());
    });

     // update vendor status
    $app->post('/vendor_status', function() use ($app){

        $new = new VendorRepo();
        $code = $new->vendorStatus($app->requestdata);
        response($code,array());
    });

    // Add deal 
    $app->post('/add_deal', function() use ($app){

        $new = new DealRepo();
        $code = $new->addDeal($app->requestdata);
        response($code,array());
    });

    // Update Deal
    $app->post('/updatedeal' , function () use ($app){

        $new = new DealRepo();
        $code = $new->updateDeal($app->requestdata);
        response($code, array());
    });    

    // Delete deal
    $app->post('/deletedeal' , function () use ($app){
        $new = new DealRepo();
        $code = $new->deleteDeal($app->requestdata);
        response($code, array());
    });

    // Get Deals
    $app->get('/deals' , function () use ($app){

        $new = new DealRepo();
        $code = $new->getDeals($app->requestdata);
        response($code['response'], array('data' => $code['data'], 'total_pages' => $code['total_pages'], 'count' => $code['count']));
    });

    // update deal status
    $app->post('/deal_status', function() use ($app){

        $new = new DealRepo();
        $code = $new->dealStatus($app->requestdata);
        response($code,array());
    });

    // Add Event
    $app->post('/addevent' , function () use ($app){
        $new = new EventRepo();
        $code = $new->addEvent($app->requestdata);
        response($code, array());
    });

    // event cron
    $app->get('/eventcron' , function () use ($app){
        $new = new EventRepo();
        $code = $new->eventCron($app->requestdata);
        //response($code, array());
    });


    // update event status
    $app->post('/event_status', function() use ($app){

        $new = new EventRepo();
        $code = $new->eventStatus($app->requestdata);
        response($code,array());
    });

    // Add Deal Vendors
    $app->post('/add_deal_vendor', function() use ($app){

        $new = new DealRepo();
        $code = $new->addDealVendors($app->requestdata);
        response($code, array());
    });

    // Location Routes 
    $app->get('/countries', function() use ($app){

        $new = new LocationRepo();
        $code = $new->getCountries($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });

    $app->get('/states', function() use ($app){

        $new = new LocationRepo();
        $code = $new->getStates($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });    

    $app->get('/cities', function() use ($app){
        $new = new LocationRepo();
        $code = $new->getCities($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });        

    $app->get('/vendors', function() use ($app){
        $new = new VendorRepo();
        $code = $new->getVendors($app->requestdata);
        response($code['code'], array('data' => $code['data'], 'total_pages' => $code['total_pages'] , 'count' => $code['count'] ));
    });        

    // Delete Vendor
    $app->post('/deletevendor' , function () use ($app){
        $new = new VendorRepo();
        $code = $new->deleteVendor($app->requestdata);
        response($code, array());
    });

    // Get events
    $app->get('/events', function() use ($app){
        $new = new EventRepo();
        $code = $new->getEvents($app->requestdata);
        response($code['response'], array('data' => $code['data'], 'total_pages' => $code['total_pages'], 'count' => $code['count']));
    }); 

    // Delete Event
    $app->post('/deleteevent' , function () use ($app){
        $new = new EventRepo();
        $code = $new->deleteEvent($app->requestdata);
        response($code, array());
    }); 

    // Add Promo Vendors and Images
    $app->post('/addpromovendors', function() use ($app){

        $new = new PromoVendorsRepo();
        $code = $new->addPromoVendors($app->requestdata);
        response($code, array());
    });

    // Update Promo Vendors and Images
    $app->post('/editpromovendors', function() use ($app){

        $new = new PromoVendorsRepo();
        $code = $new->editPromoVendors($app->requestdata);
        response($code, array());
    });

    // Get promo vendors
    $app->get('/promovendors', function() use ($app){
        $new = new PromoVendorsRepo();
        $code = $new->getPromoVendors($app->requestdata);
        response($code['response'], array('data' => $code['data'], 'total_pages' =>$code['total_pages'], 'count' =>$code['count'] ));
    }); 

    // Get Deals of a vendor
    $app->get('/vendordeals', function() use ($app){
        $new = new DealRepo();
        $code = $new->getVendorDeals($app->requestdata);
        response($code['response'], array('data' => $code['data']));
    });     

    // Get Deals of a vendor
    $app->post('/vendordeals', function() use ($app){
        $new = new DealRepo();
        $code = $new->postVendorDeals($app->requestdata);
        response($code, array());
    });     

    // Delete Promo Vendor
    $app->post('/deletepromovendor', function() use ($app){
        $new = new PromoVendorsRepo();
        $code = $new->deletePromoVendor($app->requestdata);
        response($code, array());
    });         

    $app->get('/admindata', function() use ($app){
        $new = new LoginRepo();
        $code = $new->getAdminData();
        response(200, array('data' => $code));
    });

    $app->post('/editadmindata', function() use ($app){
        $new = new LoginRepo();
        $code = $new->editAdminData($app->requestdata);
        response($code, array());
        
    });

    $app->post('/editadminpassword', function() use ($app){
        $new = new LoginRepo();
        $code = $new->editadminpassword($app->requestdata);
        response($code, array());
        
    });

    $app->post('/send_contact_query', function() use ($app){
        $new = new QueriesRepo();
        $code = $new->sendAdminQuery($app->requestdata);
        response($code, array());
        
    });

    $app->post('/add_subscriber', function() use ($app){
        $new = new QueriesRepo();
        $code = $new->addSubscriber($app->requestdata);
        response($code, array());        
    });

    $app->get('/queries', function() use ($app){
        $new = new QueriesRepo();
        $code = $new->getQueries($app->requestdata);
        response($code['code'], array('data' => $code['data'], 'total_pages' =>$code['total_pages'] ));
    });

    $app->get('/subscribers', function() use ($app){
        $new = new QueriesRepo();
        $code = $new->getSubscribers($app->requestdata);
        response($code['code'], array('data' => $code['data'], 'total_pages' =>$code['total_pages'] ));
    });    

    $app->post('/deletequery', function() use ($app){
        $new = new QueriesRepo();
        $code = $new->deleteQuery($app->requestdata);
        response($code, array());        
    });

    $app->post('/deletesubscriber', function() use ($app){
        $new = new QueriesRepo();
        $code = $new->deleteSubscriber($app->requestdata);
        response($code, array());        
    });

    $app->get('/forgotpassword', function() use ($app){
        $new = new LoginRepo();
        $code = $new->forgotPassword($app->requestdata);
        response($code, array());
    });

    $app->get('/resetpassword', function() use ($app){
        $new = new LoginRepo();
        $code = $new->resetPassword($app->requestdata);
        response($code, array());
    });

    //Edit Subscriber
     $app->post('/editsubscriber', function() use ($app){
        $new = new QueriesRepo();
        $code = $new->editSubscriber($app->requestdata);
        response($code, array());
    });

     //Deactive Subscriber
     $app->post('/deactivesubscriber', function() use ($app){
        $new = new QueriesRepo();
        $code = $new->deactiveSubscriber($app->requestdata);
        response($code, array());
    });

     $app->post('/verify_email', function() use ($app){
        $new = new QueriesRepo();
        $code = $new->verifyEmail($app->requestdata);
        response($code, array());
    });

});




$app->run();

