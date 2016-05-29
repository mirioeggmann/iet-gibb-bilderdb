<?php
/**
 * Created by PhpStorm.
 * User: jmeadmin
 * Date: 28.05.16
 * Time: 11:19
 */
class ThumbnailCreator {
    public function createThumbnail($source, $target, $maxWidthOrHeight = 100) {
        list ($width, $height, $type) = getimagesize ($source);

        if($type == 1) {
            $source_image = imagecreatefromgif($source);
        } else if ($type == 2 ) {
            $source_image = imagecreatefromjpeg($source);
        } else if ($type == 3) {
            $source_image = imagecreatefrompng($source);
        }

        $new_width = ($width > $height ? $maxWidthOrHeight : floor($width * ($maxWidthOrHeight / $height)));
        $new_height = ($height > $width ? $maxWidthOrHeight : floor($height * ($maxWidthOrHeight / $width)));

        $virtual = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled($virtual, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        if($type == 1) {
            imagegif($virtual, $target);
        } else if ($type == 2 ) {
            imagejpeg($virtual, $target);
        } else if ($type == 3) {
            imagepng($virtual, $target);
        }

        imagedestroy($virtual);
        imagedestroy($source_image);
    }
}