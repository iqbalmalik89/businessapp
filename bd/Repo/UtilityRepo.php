<?php
class UtilityRepo{

	/*
	* This function handle add request
	*/
	public $dir;

 	public static function getRootPath($root = true) {
 		if($_SERVER['HTTP_HOST'] == 'localhost')
 		{
 			if($root)
		 		$dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'businessapp'.DIRECTORY_SEPARATOR.'bd'.DIRECTORY_SEPARATOR;
		 	else
		 		$dir = 'http://'.$_SERVER['HTTP_HOST'].'/businessapp/bd/';		 		
 		}
 		else
 		{
 			if($root)
		 		$dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'beta'.DIRECTORY_SEPARATOR;
		 	else
		 		$dir = 'http://'.$_SERVER['HTTP_HOST'].'/beta/';
 		}

 		return $dir;
    }

	public function uploadTmp($file)
	{	
		$path = $_REQUEST['path'];
		$resp = array('code' => 400,  'file_name' => '');
		$path = self::getRootPath(true).'data'.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR;
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		$fileName = time().rand(1, 100).'.'.strtolower($ext);
		if(is_array($file))
		{
			$type = explode('/', $file['type']);
			if($type[0] == 'image')
			{
				if(move_uploaded_file($file['tmp_name'], $path.$fileName))
				{
					$resp['file_name'] = $fileName;
					$resp['code'] = 200;
				}
			}
		}

		return $resp;
	}

}

