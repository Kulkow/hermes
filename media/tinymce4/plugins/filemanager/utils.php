<?php 

if($_SESSION["verify"] != "FileManager4TinyMCE") die('forbiden');

function deleteDir($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir)) return unlink($dir);
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (!deleteDir($dir.DIRECTORY_SEPARATOR.$item)) return false;
    }
    return rmdir($dir);
}

function create_img_gd($imgfile, $imgthumb, $newwidth, $newheight="") {
    require_once('php_image_magician.php');  
    $magicianObj = new imageLib($imgfile);
    // *** Resize to best fit then crop
    $magicianObj -> resizeImage($newwidth, $newheight, 'crop');  

    // *** Save resized image as a PNG
    $magicianObj -> saveImage($imgthumb);
}

function makeSize($size) {
   $units = array('B','KB','MB','GB','TB');
   $u = 0;
   while ( (round($size / 1024) > 0) && ($u < 4) ) {
     $size = $size / 1024;
     $u++;
   }
   return (number_format($size, 1, ',', '') . " " . $units[$u]);
}

function create_folder($path=false,$path_thumbs=false){
	$oldumask = umask(0); 
	if ($path && !file_exists($path))
		mkdir($path, 0775); // or even 01777 so you get the sticky bit set 
	if($path_thumbs && !file_exists($path_thumbs)) 
		mkdir($path_thumbs, 0775); // or even 01777 so you get the sticky bit set 
	umask($oldumask);
}

function translit_table(){
        $translit_table = array(
        		'а' => 'a', 	'А' => 'A',
        		'б' => 'b', 	'Б' => 'B',
        		'в' => 'v', 	'В' => 'V',
        		'г' => 'g', 	'Г' => 'G',
        		'д' => 'd', 	'Д' => 'D',
        		'е' => 'e', 	'Е' => 'E',
        		'ж' => 'zh',	'Ж' => 'Zh',
        		'з' => 'z',		'З' => 'Z',
        		'и' => 'i',		'И' => 'I',
        		'й' => 'y',		'Й' => 'Y',
        		'к' => 'k',		'К' => 'K',
        		'л' => 'l',		'Л' => 'L',
        		'м' => 'm',		'М' => 'M',
        		'н' => 'n',		'Н' => 'N',
        		'о' => 'o',		'О' => 'O',
        		'п' => 'p',		'П' => 'P',
        		'р' => 'r',		'Р' => 'R',
        		'с' => 's',		'С' => 'S',
        		'т' => 't',		'Т' => 'T',
        		'у' => 'u',		'У' => 'U',
        		'ф' => 'f',		'Ф' => 'F',
        		'х' => 'h',		'Х' => 'H',
        		'ц' => 'c',		'Ц' => 'C',
        		'ч' => 'ch',	'Ч' => 'Ch',
        		'ш' => 'sh',	'Ш' => 'Sh',
        		'щ' => 'sch',	'Щ' => 'Sch',
        		'ъ' => '',		'Ъ' => '',
        		'ы' => 'y',		'Ы' => 'Y',
        		'ь' => '',		'Ь' => '',
        		'э' => 'e',		'Э' => 'E',
        		'ю' => 'yu',	'Ю' => 'Yu',
        		'я' => 'ya',	'Я' => 'Ya',
        		'і' => 'i',		'І' => 'I',
        		'ї' => 'yi',	'Ї' => 'Yi',
        		'є' => 'e',		'Є' => 'E'
        	);
         return $translit_table;
    }

function translit($str = NULL, $mod = 'def')
	{
		$translit_table = translit_table();
        $str = preg_replace('{[ |.]+}', '_', $str);
		$str = iconv('UTF-8', 'UTF-8//IGNORE', strtr($str, $translit_table));
//        $str = iconv('cp1251', 'cp1251//IGNORE', strtr($str, $translit_table));
		return preg_replace(array('/[^0-9a-zA-Z_\-]+/', '{[_]+}', '{[-]+}'), array('', '_', '-'), $str);
	}

?>