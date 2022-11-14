<?php 
public function image()
    {
     
        $image = "https://images.unsplash.com/photo-1516071351822-ae6558a8bb5b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80";

        $pin = "pin.png";
        $pin_to_png = imagecreatefrompng($pin);
        $image_ext = Storage::mimeType($image);
        $size = getimagesize($image);
        $extension = image_type_to_extension($size[2]);
        if ($extension == ".jpg" || $extension == ".jpeg") {
            $modified_image = imagecreatefromjpeg($image);
        } elseif ($extension == ".png") {
            $modified_image = imagecreatefrompng($image);
        } elseif ($extension == ".gif"){
            $modified_image = imagecreatefromgif($image);
        }
        else {
            return false;
        }
        $get_color = imagecolorat($modified_image, 8, 8);
        $red = ($get_color >> 16) & 255;
        $green = ($get_color >> 8) & 255;
        $blue = $get_color & 255;
//            get source image height width
        list($width, $height) = getimagesize($image);
//         destination height width
        if($width > 400 || $height > 400){
            $width = 300;
            $height = 300;
            $x_axis = 300 - 300 / 2;
            $y_axis = 300 - 300 / 2;
        }else{
            $x_axis = 300 - $width / 2;
            $y_axis = 300 - $height / 2;
        }
        $pin_x_axis = 300 - 41 / 2;
//            dd($width);
        //  create another image and place original image into it
        $destination_image = imagecreatetruecolor(600, 600);
        // set background color using source image
        imagefill($destination_image, $red, $green, $blue);
        imagecopyresized($destination_image, $pin_to_png, $pin_x_axis, 20, 0, 0, 50, 28, 50, 28);
        imagecopyresized($destination_image, $modified_image, $x_axis, $y_axis, 0, 0, $width, $height, $width, $height);
        // save or return image
        header("Content-Type: image/png");
        imagepng($destination_image, 'test.png');
        // destroy for save memory
        imagedestroy($destination_image);
    }
