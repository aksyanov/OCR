<?php
require_once('Neuron.php');
require_once('ImageHelper.php');

$n0 = new Neuron('0');
$n1 = new Neuron('1');
$n2 = new Neuron('2');
$n3 = new Neuron('3');
$n4 = new Neuron('4');
$n5 = new Neuron('5');
$n6 = new Neuron('6');
$n7 = new Neuron('7');
$n8 = new Neuron('8');
$n9 = new Neuron('9');

$neuronsLayer = array($n0,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9);

//$dir = 'images/3x5/';
$dir = 'images/bibi/';

foreach($neuronsLayer as $neuron){
    if(isset($_GET['learn'])){
        $iterCount = 1;
        for($iter = 0;$iter < $iterCount;$iter++){
            echo '<b>Итерация обучения нейрона '.$neuron->name.' №'.$iter.'</b><br>';
            if(is_dir($dir))
                if($dh = opendir($dir))
                    while(($file = readdir($dh))!== false){
                        if(filetype($dir.$file) == 'dir')
                            continue;

                        $image = new ImageHelper($dir.$file);
                        $imageArray = $image->array;
                        $isNeuron = $neuron->OCR($imageArray);

                        if(strripos($file,$neuron->name) > -1){ //цифра нужная
                            if(!$isNeuron){
                                $neuron->learn($imageArray,true);
                                echo 'файл '.$file.' не верный<br>';
                                if($iterCount - 1 == $iter)
                                    $iterCount++;
                            }
                        }else{
                            if($isNeuron){
                                $neuron->learn($imageArray,false);
                                echo 'файл '.$file.' не верный<br>';
                                if($iterCount - 1 == $iter)
                                    $iterCount++;
                            }
                        }
                    }

            $neuron->save();
        }
    }

    if(isset($_GET['OCR'])){
        echo '<br><b><u>Чтение</u> и распознование цифры '.$neuron->name.'</b><br>';
        if(is_dir($dir))
            if($dh = opendir($dir))
                while(($file = readdir($dh))!== false){
                    if(filetype($dir.$file) == 'dir')
                        continue;

                    $image = new ImageHelper($dir.$file);
                    $imageArray = $image->array;
                    $isNeuron = $neuron->OCR($imageArray);

                    echo $file.': ';
                    echo $isNeuron;
                    echo '<br>';
                }

        /*echo '<br><br>В памяти:<br><pre>';
        print_r($neuron->memory);
        echo '</pre>';*/

        echo '<br><br><br>';
    }
}

if(isset($_GET['learn_code'])){
    $file = '3 0 1 4 5';
    $image = new ImageHelper('images/bibi_code/'.$file);
    $image->getSymbols();
    $symbolArray = preg_split("/ /",$file,null,PREG_SPLIT_NO_EMPTY);

    foreach($neuronsLayer as $neuron){
        $iterCount = 1;
        for($iter = 0;$iter < $iterCount;$iter++){
            echo '<b>Итерация обучения нейрона '.$neuron->name.' №'.$iter.'</b><br>';

            $symbolCount = 0;
            foreach($image->symbols as $symbol){
                $imageArray = $symbol['array'];
                $isNeuron = $neuron->OCR($imageArray);

                $curSymbol = $symbolArray[$symbolCount];
                if($curSymbol == $neuron->name){ //цифра нужная
                    if(!$isNeuron){
                        $neuron->learn($imageArray,true);
                        echo 'Символ '.$curSymbol.' не верный<br>';
                        if($iterCount - 1 == $iter)
                            $iterCount++;
                    }
                }else{
                    if($isNeuron){
                        $neuron->learn($imageArray,false);
                        echo 'Символ '.$curSymbol.' не верный<br>';
                        if($iterCount - 1 == $iter)
                            $iterCount++;
                    }
                }

                $symbolCount++;
            }

            $neuron->save();
        }
    }

}

if(isset($_GET['OCR_code'])){
    $image = new ImageHelper('images/bibi_code/3 0 1 4 5');
    $image->getSymbols();

    foreach($image->symbols as $symbol){
        foreach($neuronsLayer as $neuron){
            $isNeuron = $neuron->OCR($symbol['array']);
            if($isNeuron){
                $symbolName = $neuron->name;
                break;
            }else
                $symbolName = '?';
        }
        echo $symbolName;
    }
}


$image = new ImageHelper('images/bibi_code/1.jpg',false);
$image->resize(20);
$image->getArray();
//$image->printArray();
$image->getSymbols();
$image->sortSymbols();
foreach($image->symbols as $symbol){
    $image->printArray(false,$symbol['array']);
    echo '<br><br>';
}
//$image->printArray();

/*foreach($image->symbols as $symbol){
    foreach($neuronsLayer as $neuron){
        $isNeuron = $neuron->OCR($symbol['array']);
        if($isNeuron){
            $symbolName = $neuron->name;
            break;
        }else
            $symbolName = '?';
    }
    echo $symbolName;
}*/

?>











