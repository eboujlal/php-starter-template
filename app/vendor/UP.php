<?php

    class UP{

        protected $extAvailable = ['gif','jpg','png','jpeg'];
        protected $dir = 'img/';

        public function __construct($dir){
            $this->dir = $dir;
        }

        public function directory($dirName){
            $this->dir = $dirName;
        }

        private function getExtension($filename){
            $ext = pathinfo($filename);
            return $ext['extension'];
        }

        private function nameRand($len){
            $alpha = "0123456789azertyuiopmlkjhgfdsqwxcvbnAZERTYUIOPMLKJHGFDSQWXCVBN";
            return strtoupper(substr(str_shuffle(str_repeat($alpha,20)),0,$len));
        }

        public function movefile($file){
            $ext = self::getExtension($file['name']);
            $newName = DATE('dmY').$this->nameRand(16).'.'.$ext;
            $dst = $this->dir.$newName;
            $this->move($file['tmp_name'],$newName);
            return array('name'=>$newName,'file'=>$dst);
        }

        public function moveFiles($src){
            $files = $this->multi($src);
            $uploded = array();
            foreach ($files as $file) {
                $newName = DATE('dmY').$this->nameRand(16).'.'.$file['extension'];
                $dst = $this->dir.$newName;
                $this->move($file['tmp_name'],$dst);
                array_push($uploded,array('name'=>$newName,'file'=>$dst));
            }
            return $uploded;
        }

        private function move($file,$dst){
            if(move_uploaded_file($file,$dst))return true;
            else return false;
        }

        public function secure($file){
            $ext = $this->getExtension($file);
            if(in_array($ext,$this->extAvailable)) return true;
            else return false;
        }

        public function shell($file){

        }

        private function multi($src){
            $dst = array();
            for($i=0;$i<count($src['name']);$i++){
                $path = pathinfo($src['name'][$i]);
                $tmp = array(
                    'name'=>$src['name'][$i],
                    'type'=>$src['type'][$i],
                    'extension'=>$path['extension'],
                    'tmp_name'=>$src['tmp_name'][$i],
                    'error'=>$src['error'][$i],
                    'size'=>$src['size'][$i]
                );
                array_push($dst,$tmp);
            }
            return $dst;
        }


        function crop($files,$thumb_width, $thumb_height,$titre=''){
            $cropped = array();
            foreach ($files as $file) {
                    $ext = strtolower($this->getExtension($file['name']));
                    if($ext=='jpg') $ext = 'jpeg';
                    $func = "imagecreatefrom".$ext;
                    $image = $func($file['file']);
                    if($titre!='') $filename = $this->dir.$titre.'-'.$thumb_width.'x'.$thumb_height.'-'.$file['name'];
                    else $filename = $file['file'];
                    $width = imagesx($image);
                    $height = imagesy($image);
                    $original_aspect = $width / $height;
                    $thumb_aspect = $thumb_width / $thumb_height;
                    if ( $original_aspect >= $thumb_aspect )
                    {
                        // If image is wider than thumbnail (in aspect ratio sense)
                        $new_height = $thumb_height;
                        $new_width = $width / ($height / $thumb_height);
                    }
                    else
                    {
                        // If the thumbnail is wider than the image
                        $new_width = $thumb_width;
                        $new_height = $height / ($width / $thumb_width);
                    }
                    $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
                    // Resize and crop
                    imagecopyresampled($thumb,
                        $image,
                        0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                        0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                        0, 0,
                        $new_width, $new_height,
                        $width, $height);

                    switch($ext){
                        case 'bmp': imagewbmp($thumb, $filename); break;
                        case 'gif': imagegif($thumb, $filename); break;
                        case 'jpeg': imagejpeg($thumb, $filename,80); break;
                        case 'png': imagepng($thumb, $filename,9); break;
                    }
                    array_push($cropped,$filename);
            }
            return $cropped;
        }

    }
