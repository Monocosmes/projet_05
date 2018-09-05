<?php

namespace classes;

class Upload
{
    public function uploadImageArticle($params, $path, $id = null)
    {
        /*******************************************************
         * Only these origins will be allowed to upload images *
         ******************************************************/
        $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://example.com");
        
        /*********************************************
         * Change this line to set the upload folder *
         *********************************************/
        $imageFolder = ROOT.'assets/images/'.$path.'/';
        $imagePath = ASSETS.'images/'.$path.'/';
        
        reset ($_FILES);
        $temp = current($_FILES);
        $imageSize = getimagesize($temp['tmp_name']);

        if (is_uploaded_file($temp['tmp_name'])){
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                // same-origin requests won't set an origin. If the origin is set, it must be valid.
                if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                } else {
                    header("HTTP/1.1 403 Origin Denied");
                    return;
                }
            }
        
            /*
            If your script needs to receive cookies, set images_upload_credentials : true in
            the configuration and enable the following two headers.
            */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');
        
            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            }        
            // Verify extension
            elseif (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "jpeg", "png"))) {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }
            // Verify size
            elseif (($path === 'avatars' AND $temp['size'] > '500000') OR ($path === 'articles' AND $temp['size'] > '2000000')) {
                header("HTTP/1.1 400 Invalid file size");
                return;
            }
            // Verify width and height
            elseif($path === 'avatars' AND ($imageSize[0] > 500 OR $imageSize[1] > 750)) {
                header("HTTP/1.1 400 Invalid file width");
                return;
            }
        
            // Accept upload if there was no origin, or if it is an accepted origin

            $elements = explode('.', $temp['name']);
            $num = sizeof($elements) - 1;
            $extension = $elements[$num];

            if($path === 'avatars') {
                $imageName = $id.'-'.uniqid().'.'.$extension;
            } elseif ($path === 'articles') {
                $imageName = rand(1, 999).'-'.uniqid().'.'.$extension;
            }

            $filetowrite = $imageFolder . $imageName;
            $filePath = $imagePath . $imageName;

            move_uploaded_file($temp['tmp_name'], $filetowrite);

            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            echo json_encode(array
            (
                'location' => $filePath,
                'size' => $temp['size'],
                'imageSize' => $imageSize,
                'name' => $imageName
            ));

            return ($path === 'avatars') ? $imageName : '';
        } else {
            // Notify editor that the upload failed
            header("HTTP/1.1 500 Server Error");
        }
    }
}
