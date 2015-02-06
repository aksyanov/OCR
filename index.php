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

$dir = 'images/3x5/';

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

//Подкинем пару файлов
$ext = '.png';
$image1 = new ImageHelper($dir.'1'.$ext);
$image5 = new ImageHelper($dir.'5'.$ext);
$image5c = new ImageHelper($dir.'5c'.$ext);
$image6 = new ImageHelper($dir.'6'.$ext);
$image8 = new ImageHelper($dir.'8'.$ext);
$image9 = new ImageHelper($dir.'9'.$ext);
$imageArray = array($image1,$image5,$image5c,$image6,$image8,$image9);

foreach($imageArray as $image){
    foreach($neuronsLayer as $neuron){
        if($neuron->OCR($image->array))
            echo $neuron->name;
    }
}


?>











