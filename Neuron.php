<?php
class GeneralNeuron
{
    public $minOutput = 1800;
}

class Neuron extends GeneralNeuron
{
    public $name;
    public $arrayOCR = array(array());
    public $memory   = array(array());
    public $output   = 0;

    public function readImage($pathToImg,$learn = false){
        $image = imagecreatefromjpeg($pathToImg);
        $maxX = imagesx($image);
        $maxY = imagesy($image);

        if($learn)
            $array = $this->memory;
        else
            $array = array(array());

        for($y = 0;$y < $maxY;$y++){
            for($x = 0;$x < $maxX;$x++){
                if($learn){
                    $black = $this->blackOrWhite(imagecolorsforindex($image,imagecolorat ($image , $x, $y)));
                    if(($black == 0 && !$array[$y][$x] == 1) || $black == 1)
                        $array[$y][$x] = $black;

                }else
                    $array[$y][$x] = $this->blackOrWhite(imagecolorsforindex($image,imagecolorat ($image , $x, $y)));
                //$array[$y][$x] = $array[$y][$x] + $this->blackOrWhite(imagecolorsforindex($image,imagecolorat ($image , $x, $y)));
            }
        }
        imagedestroy($image);

        if($learn)
            $this->memory   = $array;
        else
           $this->arrayOCR  = $array;

    }

    protected function blackOrWhite($arrayColor){
        if($arrayColor['red'] >= 150 && $arrayColor['green'] >= 150 && $arrayColor['blue'] >= 150)
            return '0'; // white
        else
            return '1';
    }

    public function printImage($memory = false){
        if($memory)
            $array = $this->memory;
        else
            $array = $this->arrayOCR;

        for($y = 0;$y < count($array);$y++){
            for($x = 0;$x < count($array[$y]);$x++){
                echo $array[$y][$x];
            }
            echo '<br>';
        }
    }

    public function OCR(){
        $memory     = $this->memory;
        $arrayOCR   = $this->arrayOCR;
        for($y = 0;$y < count($memory);$y++){
            for($x = 0;$x < count($memory[$y]);$x++){
                if($memory[$y][$x] == $arrayOCR[$y][$x])
                    $this->output++;
            }
        }
        echo 'output : '.$this->output.'<br>';
        if($this->output > $this->minOutput)
            echo $this->name;
    }



}
