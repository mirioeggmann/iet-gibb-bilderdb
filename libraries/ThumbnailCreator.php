<?php

/**
 * Lychez : Image database (https://lychez.luvirx.io)
 * Copyright (c) luvirx (https://luvirx.io)
 *
 * Licensed under The MIT License
 * For the full copyright and license information, please see the LICENSE.md
 * Redistributions of the files must retain the above copyright notice.
 *
 * @link 		https://lychez.luvirx.io Lychez Project
 * @copyright 	Copyright (c) 2016 luvirx (https://luvirx.io)
 * @license		https://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Class that creates a thumnail of a given picture.
 */
class ThumbnailCreator {
    
    /**
     * Creates a thumbnail of a picture with the real sizes but just smaller.
     *
     * @param $source Source of the original picture.
     * @param $target Target of the thumbnail.
     * @param int $maxWidthOrHeight Maximal width or height of the thumbnail.
     */
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