<?php
class Neuron
{
    public $name;
    public $input    = array(array());  //входной массив изображения
    public $memory   = array(array());  //память, веса синапсисов
    public $inputMul = array(array());  //отмасштабированный input
    public $limit    = 9;               // лимит, ниже которой буква не верна
    public $inputSum = 0;               // сумма весов синапсисов

    public function __construct(){
        //в дальнешем загрузить память
        $this->memory = array(array());
    }

    public function mul(){

    }

    public function sum(){

    }

    public function isNeuron(){

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
