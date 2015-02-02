<?php
  header('Content-type: image/png'); // устанавливаем тип документа - "изображение в формате PNG".
?>
<?php
	
	$image = imagecreatetruecolor(80,60) // создаем изображение... 
    or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки 


	// "Зальем" фон картинки синим цветом...
	imagefill($image, 0, 0, 0x000080);
	// Нарисуем желтый контурный эллипс...
	imageellipse($image, 40, 30, 50, 50, 0xFFFF00);
	// ...и еще пару, но сплошных...
	imagefilledellipse($image, 30, 20, 10, 10, 0xFFFF00);
	imagefilledellipse($image, 50, 20, 10, 10, 0xFFFF00);
	// ...вертикальную линию...
	imageline($image, 40, 28, 40, 38, 0xFFFF00);
	// ...и дугу.
	imagearc($image, 40, 30, 40, 40, 45, 135, 0xFFFF00);

	// Устанавливаем тип документа - "изображение в формате PNG"...
	header('Content-type: image/png'); 
	// ...И, наконец, выведем сгенерированную картинку в формате PNG:
	imagepng($image);

	imagedestroy($image);                // освобождаем память, выделенную для изображения
	
?>