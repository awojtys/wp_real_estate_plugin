<?php
class ModifyPicture 
{    
    protected $_filename;
    protected function generateName($file)
    {
        $extension = explode('.', $file);
        $name = '';
        $letters = range('A', 'z');
        shuffle($letters);
        foreach ($letters as $letter) 
        {
            $name .= $letter;
        }  
        $hash = hash('md5', $name).time(). '.'. end($extension);
        return $this->_filename = $hash;
    }
    
    public function resizeImage($filename)
    {

        $this->generateName($filename->name);
        $oldfilepath = $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/real_estate_office/server/php/files/' . $filename->name;
        $newfilepath = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/real_estate/' . $this->_filename;
        
        $image = new Imagick($oldfilepath);
        $image ->readimage($oldfilepath);
        $image->resizeImage(400, 400, Imagick::FILTER_LANCZOS,1, true);
        $image->writeimage($newfilepath);
        $image->clear();
        $image->destroy();
        
        $response = array('image_name' => $this->_filename);
        header("Content-Type: application/json");        
        echo json_encode($response);
        exit;   
    }
}

?>
