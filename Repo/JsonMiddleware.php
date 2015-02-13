<?php

class JsonMiddleware extends \Slim\Middleware
{

    public function call()
    {

        // Force response headers to JSON
        $this->app->response->headers->set(
            'Content-Type',
            'application/json'
        );
         
        $method = strtolower($this->app->request->getMethod());
        $mediaType = $this->app->request->getMediaType();
         
        if (in_array(
            $method,
            array('post', 'put', 'patch')
        )) {
             
            if (empty($mediaType) || $mediaType !== 'application/json') {
                // Return generic error
                // Connect with database
                $this->dbConnect();
                
            }
            else
            {
                // Connect with database
                $this->dbConnect();
            }
        }





        $this->next->call();
    }

    public function dbConnect()
    {
        if($_SERVER['HTTP_HOST'] == 'localhost')
        {
            $database = 'businessapp';
            $user = 'root';
            $password = '';
        }
        else
        {
            $database = 'businessapp';
            $user = 'root';
            $password = '';
        }

        $pdo = new PDO("mysql:dbname=". $database, $user, $password);
        $GLOBALS['con'] = new FluentPDO($pdo);        
    }


}

