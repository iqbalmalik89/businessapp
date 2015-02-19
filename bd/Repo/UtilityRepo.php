<?php
class UtilityRepo{

	/*
	* This function handle add request
	*/
	public $dir;

 	public static function getRootPath() {
 		if($_SERVER['HTTP_HOST'] == 'localhost')
 		{
	 		$dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'businessapp'.DIRECTORY_SEPARATOR.'bd'.DIRECTORY_SEPARATOR;
 		}
 		else
 		{
	 		$dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'bd'.DIRECTORY_SEPARATOR;
 		}
 		return $dir;
    }

	public function uploadTmp($file)
	{	
		$resp = array('code' => 400,  'file_name' => '');
		$path = self::getRootPath().'data'.DIRECTORY_SEPARATOR.'vendor_images';
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		$fileName = time().'.'.strtolower($ext);
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

