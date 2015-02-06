<?php
require_once('Neuron.php');
require_once('ImageHelper.php');

/*$n0 = new Neuron('0');
$n1 = new Neuron('1');
$n2 = new Neuron('2');
$n3 = new Neuron('3');
$n4 = new Neuron('4');*/
$n5 = new Neuron('5');

$dir = 'images/3x5/';

for($iter = 0;$iter < 0;$iter++){
    echo 'Итерация обучения №'.$iter.'<br>';
    if(is_dir($dir))
        if($dh = opendir($dir))
            while(($file = readdir($dh))!== false){
                if(filetype($dir.$file) == 'dir')
                    continue;

                $image = new ImageHelper($dir.$file);
                $imageArray = $image->array;
                $isNeuron = $n5->OCR($imageArray);

               /* if(strripos($file,'5') > -1){ //цифра 5
                    if(!$isNeuron)
                        $n5->learn($imageArray,true);
                }else{
                    if($isNeuron)
                        $n5->learn($imageArray,false);
                }*/
            }

    $n5->save();
}

echo 'Чтение и распознование цифры 5<br>';
if(is_dir($dir))
    if($dh = opendir($dir))
        while(($file = readdir($dh))!== false){
            if(filetype($dir.$file) == 'dir')
                continue;

            $image = new ImageHelper($dir.$file);
            $imageArray = $image->array;
            $isNeuron = $n5->OCR($imageArray);

            echo $file.': ';
            var_dump($isNeuron);
            echo '<br>';
        }

echo '<br><br>В памяти:<br><pre>';
print_r($n5->memory);
echo '</pre>';


?>











