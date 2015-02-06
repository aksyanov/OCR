<?php
class Neuron
{
    public $name;
    public $input    = array(array());  //входной массив изображения
    public $memory   = array(array());  //память, веса синапсисов
    public $inputMul = array(array());  //отмасштабированный input
    public $limit    = 9;               // лимит, ниже которой буква не верна
    public $inputSum = 0;               // сумма весов синапсисов
    public $memoryFolder    = 'memory/';
    public $memoryExt       = '.txt';

    public function __construct($name){
        $this->name = $name;
        $this->loadInMemory();
    }

    public function mul(){
        $y = 0;
        foreach($this->memory as $elemY){
            $x = 0;
            foreach($elemY as $elemX){
                $this->inputMul[$y][$x] = $this->input[$y][$x] * $elemX;
                $x++;
            }
            $y++;
        }
    }

    public function sum(){
        $this->inputSum = 0;
        foreach($this->inputMul as $elemY)
            foreach($elemY as $elemX)
                $this->inputSum+= $elemX;
    }

    public function isNeuron(){
        return $this->inputSum >= $this->limit;
    }

    protected function loadInMemory(){
        $filename = $this->memoryFolder.$this->name.$this->memoryExt;
        if(file_exists($filename)){
            $memoryFile = file($filename);
            $y = 0;
            $array = array(array());
            foreach($memoryFile as $string){
                $string = rtrim($string);
                $arrayString = preg_split("/ /",$string,null,PREG_SPLIT_NO_EMPTY);
                $array[$y] = $arrayString;
                $y++;
            }
            $this->memory = $array;
        }else{
            $stream = fopen($filename,'w');
            $string = "0 0 0\r\n0 0 0\r\n0 0 0\r\n0 0 0\r\n0 0 0";
            fwrite($stream,$string);
        }
    }

    public function save(){
        $filename = $this->memoryFolder.$this->name.$this->memoryExt;
        $stream = fopen($filename,'w');
        $string = "";
        foreach($this->memory as $y){
            foreach($y as $x){
                $string.= $x.' ';
            }
            $string.="\r\n";
        }
        fwrite($stream,$string);
    }

    public function learn($input,$isNeuron){
        $y = 0;
        foreach($input as $elemY){
            $x = 0;
            foreach($elemY as $elemX){
                if($isNeuron)
                    $this->memory[$y][$x]+=$elemX;
                else
                    $this->memory[$y][$x]-=$elemX;
                $x++;
            }
            $y++;
        }
    }

    public function OCR($input){
        $this->input = $input;
        $this->mul();
        $this->sum();
        return $this->isNeuron();
    }

}
