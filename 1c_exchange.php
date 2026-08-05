<?php
header('Content-Type: text/html; charset=utf-8');
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
set_time_limit(600);
ini_set('memory_limit', '356M');

function generate_chpu ($str)
		{
		$converter = array(
	        'а' => 'a',   'б' => 'b',   'в' => 'v',
	        'г' => 'g',   'д' => 'd',   'е' => 'e',
	        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
	        'и' => 'i',   'й' => 'y',   'к' => 'k',
	        'л' => 'l',   'м' => 'm',   'н' => 'n',
	        'о' => 'o',   'п' => 'p',   'р' => 'r',
	        'с' => 's',   'т' => 't',   'у' => 'u',
	        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
	        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
	        'ь' => '',  'ы' => 'y',   'ъ' => '',
	        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
 
	        'А' => 'A',   'Б' => 'B',   'В' => 'V',
	        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
	        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
	        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
	        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
	        'О' => 'O',   'П' => 'P',   'Р' => 'R',
	        'С' => 'S',   'Т' => 'T',   'У' => 'U',
	        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
	        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
	        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
	        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		$str = strtr($str, $converter);
		$str = strtolower($str);
		$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
		$str = trim($str, "-");
		return $str;
		}


//$imgdir="/home/t/texetbiz/modno-len.ru/public_html/img_news";
/////////////подключаемся к базе////////////////
include "../includes/config.php";
mysql_connect($hostname,$username,$password) OR DIE("");
@mysql_select_db("$dbName") or die("Не могу выбрать базу данных ");
/////////////подключаемся к базе////////////////


function dopphoto ($filename,$color_id,$id_1c_1)
{
/////////////////////////////////////////добавление доп картиники
if ($filename=="") 
{
$kartinka_name1="nophoto.jpg";$kartinka_name2="nophoto.jpg";
} 
else 
{
//***//
$kartinka = explode("/", $filename);
$kartinka_name=$kartinka[2];
//////////////проверяем наличие картинки в базе
$query_razmer11 = "SELECT count(id) as cnt FROM `prod2_trikotaj` where id_1c_color='$color_id' and photo1='$kartinka_name' and photo2='$kartinka_name' limit 1";
//echo "++++++++ $query_razmer11<br />";
$result_razmer11 = mysql_query($query_razmer11);
while($row = mysql_fetch_array($result_razmer11, MYSQLI_ASSOC))
{
//$id_razmer="";
//***//
$cnt_d1=$row["cnt"];
}
//////////////проверяем наличие картинки в базе
//***//
if ($cnt_d1>0)
{
echo "";
//echo "Рисунок уже есть!";
}
else 
{
//echo "РАБОТАЕМ ";
echo "";
//***//
$kartinka_name111="/home/t/texetbiz/modno-len.ru/public_html/adfgiug324fg/"."$filename";
if (!move_uploaded_file($kartinka_name111, $imgdir . "/h/" . $kartinka_name1))
chmod($imgdir . "/h/" . $kartinka_name1, 0777);
$imgrr=$kartinka_name111;
$ris=resized($imgrr,390);
$imgrr=$kartinka_name111;
$ris=resized_h($imgrr,1000);
$kartinka_name11=$kartinka_name1;
$query_prod_d1 = "INSERT INTO `prod2_trikotaj` (`p`, `photo1`,`photo2`,`id_1c_color`) VALUES ('$id_1c_1','$kartinka_name','$kartinka_name','$color_id');";
$result_prod_d1 = mysql_query($query_prod_d1);
}
}
/////////////////////////////////////////добавление доп картиники
return $kartinka_name;
}



function resize ($filename, $size)
{
$pref = '';
$img = strtolower(strrchr(basename($filename), "."));
$imgname = basename($filename);

$formats = array('.JPG', '.jpg', '.gif', '.png', '.bmp');
if (in_array($img, $formats))
{
list($width, $height) = getimagesize($filename);
$new_height = $height * $size;
$n2 = $height / $width  ;
$new_height2 = $size *  $n2;
$new_width = $new_height / $width;
$thumb = imagecreatetruecolor($size, $new_width);


imagealphablending($thumb, true); 
$white=imagecolorallocate($thumb, 255, 255, 255); 
imagefilledrectangle($thumb, 0, 0, $width-1, $height-1, $white); 

switch ($img)
{
case '.JPG': $source = @imagecreatefromjpeg($filename); break;
case '.jpg': $source = @imagecreatefromjpeg($filename); break;
case '.gif': $source = @imagecreatefromgif($filename); break;
case '.png': $source = @imagecreatefrompng($filename); break;
case '.bmp': $source = @imagecreatefromwbmp($filename); break;
}
imagecopyresampled($thumb, $source, 0, 0, 0, 0, $size, $new_width, $width, $height);


switch ($img)
{
case '.JPG': imagejpeg($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname, 90); break;
case '.jpg': imagejpeg($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname, 90); break;
case '.gif': imagegif($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname); break;
case '.png': imagepng($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname); break;
case '.bmp': imagewbmp($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname); break;
}
}
else return 'Error';
@imagedestroy($thumb);
@imagedestroy($source);
return $imgname;
}

//---------
function resize_h ($filename, $size)
{
$pref = '';
$img = strtolower(strrchr(basename($filename), "."));
$imgname = basename($filename);
$formats = array('.JPG', '.jpg', '.gif', '.png', '.bmp');
if (in_array($img, $formats))
{
list($width, $height) = getimagesize($filename);
$new_height = $height * $size;
$new_width = $new_height / $width;

$n2 = $height / $width  ;
$new_height2 = $size *  $n2;


$thumb = imagecreatetruecolor($size, $new_width);
switch ($img)
{
case '.JPG': $source = @imagecreatefromjpeg($filename); break;
case '.jpg': $source = @imagecreatefromjpeg($filename); break;
case '.gif': $source = @imagecreatefromgif($filename); break;
case '.png': $source = @imagecreatefrompng($filename); break;
case '.bmp': $source = @imagecreatefromwbmp($filename); break;
}
imagecopyresampled($thumb, $source, 0, 0, 0, 0, $size, $new_width, $width, $height);

imagecopy($thumb, $watermark, $pos_x, $pos_y, 0, 0, $w_width, $w_height);
//-------------------


switch ($img)
{
case '.JPG': imagejpeg($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname, 90); break;
case '.jpg': imagejpeg($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname, 90); break;
case '.gif': imagegif($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname); break;
case '.png': imagepng($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname); break;
case '.bmp': imagewbmp($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname); break;
}
}
else return 'Error';
@imagedestroy($thumb);
@imagedestroy($source);
return $imgname;
}



function resized ($filename, $size)
{
$pref = '';
$img = strtolower(strrchr(basename($filename), "."));
$imgname = basename($filename);

$formats = array('.JPG', '.jpg', '.gif', '.png', '.bmp');
if (in_array($img, $formats))
{
list($width, $height) = getimagesize($filename);
$new_height = $height * $size;
$n2 = $height / $width  ;
$new_height2 = $size *  $n2;
$new_width = $new_height / $width;
$thumb = imagecreatetruecolor($size, $new_width);


imagealphablending($thumb, true); 
$white=imagecolorallocate($thumb, 255, 255, 255); 
imagefilledrectangle($thumb, 0, 0, $width-1, $height-1, $white); 

switch ($img)
{
case '.JPG': $source = @imagecreatefromjpeg($filename); break;
case '.jpg': $source = @imagecreatefromjpeg($filename); break;
case '.gif': $source = @imagecreatefromgif($filename); break;
case '.png': $source = @imagecreatefrompng($filename); break;
case '.bmp': $source = @imagecreatefromwbmp($filename); break;
}
imagecopyresampled($thumb, $source, 0, 0, 0, 0, $size, $new_width, $width, $height);


switch ($img)
{
case '.JPG': imagejpeg($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname, 90); break;
case '.jpg': imagejpeg($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname, 90); break;
case '.gif': imagegif($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname); break;
case '.png': imagepng($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname); break;
case '.bmp': imagewbmp($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/s/'. $pref.$imgname); break;
}
}
else return 'Error';
@imagedestroy($thumb);
@imagedestroy($source);
return $imgname;
}

//---------
function resized_h ($filename, $size)
{
$pref = '';
$img = strtolower(strrchr(basename($filename), "."));
$imgname = basename($filename);
$formats = array('.JPG', '.jpg', '.gif', '.png', '.bmp');
if (in_array($img, $formats))
{
list($width, $height) = getimagesize($filename);
$new_height = $height * $size;
$new_width = $new_height / $width;

$n2 = $height / $width  ;
$new_height2 = $size *  $n2;


$thumb = imagecreatetruecolor($size, $new_width);
switch ($img)
{
case '.JPG': $source = @imagecreatefromjpeg($filename); break;
case '.jpg': $source = @imagecreatefromjpeg($filename); break;
case '.gif': $source = @imagecreatefromgif($filename); break;
case '.png': $source = @imagecreatefrompng($filename); break;
case '.bmp': $source = @imagecreatefromwbmp($filename); break;
}
imagecopyresampled($thumb, $source, 0, 0, 0, 0, $size, $new_width, $width, $height);

imagecopy($thumb, $watermark, $pos_x, $pos_y, 0, 0, $w_width, $w_height);
//-------------------


switch ($img)
{
case '.JPG': imagejpeg($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname, 90); break;
case '.jpg': imagejpeg($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname, 90); break;
case '.gif': imagegif($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname); break;
case '.png': imagepng($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname); break;
case '.bmp': imagewbmp($thumb, '/home/t/texetbiz/modno-len.ru/public_html/img_news/h/'. $pref.$imgname); break;
}
}
else return 'Error';
@imagedestroy($thumb);
@imagedestroy($source);
return $imgname;
}





class Exchange1c {
 
        private $mode;
        private $filename;
 
 
        public function __construct() {
                // принимаем значение mode
                $this->mode = $_GET['mode'];
                $this->filename = $_GET['filename'];
        }
 
        public function run(){
                $mode = $this->mode;
                // и здесь, в зависимости, что отправла 1С
                // вызываем одноименный метод
                /*
                 * 1. checkauth
                 * 2. init
                 * 3. file
                 * 4.1 import - [filename] => import.xml
                 * 4.2 import - [filename] => offers.xml
                 */
                $this->$mode();
        }
 
 
        /*
         * Этап 1. Авторизовываем 1с клиента
         */
        public function checkauth() {
                echo "success\n";
                echo session_name()."\n";
                echo session_id()."\n";
                exit;
        }
 
        /*
         * Этап 2. Говрим 1с, умеем или не умеем работать с архивами
         * в нашем случае - умеем :)
         */
        public function init() {
                $zip = extension_loaded('zip') ? 'yes' : 'no';
                echo 'zip='.$zip."\n";
//              echo "zip=no\n";
                echo "file_limit=0\n";
                exit;
        }
 
  
        public function file() {
 
                // вытаскиваем сырые данные
                $data = file_get_contents('php://input');
 
                //Сохраняем файл импорта в zip архиве
                file_put_contents($this->filename, $data);
               
                // распаковываем
                if(file_exists($this->filename)) {
                        // работаем с zip
                        $zip = new ZipArchive;
                        //все в порядке с архивом?
                        if($res = $zip->open($this->filename, ZIPARCHIVE::CREATE)) {
 
                                // распаковываем два файла в формате xml куда-то
                                // в нашем случае в этот же каталог
                                $zip->extractTo('/home/t/texetbiz/modno-len.ru/public_html/adfgiug324fg');
                                $zip->close();
 
                                // удаляем временный файл
                                unlink($this->filename);
                                //Всё получилось?
                                echo "success\n";
                                exit;
                        }
                }
                // если ничего не получилось
                echo "failure\n";
                exit;
        }



/////////////////////////////////////////////
        /*
         * Этап 5 генерируем файл обмена
         */

        public function query() {
                echo "success\n";
                exit;
}

/////////////////////////////////////////////

 
        /*
         * Этап 3 и 4 работаем с файлами обмена
        */




        public function import() {





                // используем читалку xml
                $xml = simplexml_load_file($this->filename);
                if($xml && $this->filename == 'import.xml') {








////////////////добавление категорий из справочника
foreach($xml as $el)
{
////////////////////////////////////////////////

for ($a = 0; $a < 100; $a++)  {

$id_kat=$el->Группы->Группа[$a]->Ид;
$id_kat_name=$el->Группы->Группа[$a]->Наименование;
$chpu_kat=generate_chpu($id_kat_name);

if ($id_kat=="")
{
echo "";
}
else 
{

$query_zz1 = "SELECT count(id) as cnt FROM `podr_trikotaj` where data_1c='$id_kat' limit 1";
$result_zz1 = mysql_query($query_zz1);
while($row = mysql_fetch_array($result_zz1, MYSQLI_ASSOC))
{
$cnt1=$row["cnt"];
}

if ($cnt1==0)
{
//echo "Характеристика категории отсутсвует - добавляем<br />";
$query_kat = "INSERT INTO `podr_trikotaj` ( `name`,  `data_1c`,`chpu`,`cat`,`title`,`description`) VALUES ('$id_kat_name','$id_kat','$chpu_kat','1','$id_kat_name','$id_kat_name');";
//echo "$query_kat";
$result_kat = mysql_query($query_kat);
}
else 
{
echo "";
//echo "Характеристика категории присутсвует<br />";
}
}
}
}
////////////////добавление категорий из справочника


////////////////добавление состава из справочника
foreach($xml as $el)
{
////////////////////////////////////////////////

for ($a = 0; $a < 100; $a++)  {

$id_sv=$el->Свойства->Свойство->ВариантыЗначений->Справочник[$a]->ИдЗначения;
$id_sv_name=$el->Свойства->Свойство->ВариантыЗначений->Справочник[$a]->Значение;

//echo "$a - $id_sv - $id_sv_name";

if ($id_sv=="")
{
echo "";
}
else 
{

$query_sv1 = "SELECT count(id) as cnt FROM `sostav_prod` where id_1c='$id_sv' limit 1";

$result_sv1 = mysql_query($query_sv1);
while($row = mysql_fetch_array($result_sv1, MYSQLI_ASSOC))
{
$cnt1sv=$row["cnt"];
}

if ($cnt1sv==0)
{
//echo "Характеристика категории отсутсвует - добавляем<br />";
$query_sv2 = "INSERT INTO `sostav_prod` ( `name`,  `id_1c`) VALUES ('$id_sv_name','$id_sv');";
//echo "$query_kat";
$result_sv2 = mysql_query($query_sv2);
}
else 
{
echo "";
//echo "Характеристика категории присутсвует<br />";
}
}
}
}
////////////////добавление состава из справочника

                                    
foreach($xml as $el)
{
/////////////////////////////////////////////////
for ($a = 0; $a < 10000; $a++)  {
$id_prod_1c=$el->Товары->Товар[$a]->Ид;
$art_prod=$el->Товары->Товар[$a]->Артикул;
$name_prod=$el->Товары->Товар[$a]->Наименование;
$catt=$el->Товары->Товар[$a]->Категория;
//echo "<p>$catt</p>";
$opis=$el->Товары->Товар[$a]->Описание;
$sostavv_id=$el->Товары->Товар[$a]->ЗначенияСвойств->ЗначенияСвойства[0]->Значение;




if ($id_prod_1c=="") {echo "";} else { 


//echo "$id_prod_1c - $kartinka_name111 - $img1<br />";
//echo "$id_prod_1c - $kartinka_name111 - $img1<br />";

//////////////////////добавляем товар
/////////////////1 узнаем категорию и подкатегорию/////////////

$query0 = "SELECT name FROM `sostav_prod` where id_1c='$sostavv_id' limit 1";
$result0 = mysql_query($query0);
while($row = mysql_fetch_array($result0, MYSQLI_ASSOC))
{
$name_sostav=$row["name"];
}



$query0 = "SELECT id,cat FROM `podr_trikotaj` where data_1c='$catt' limit 1";
$result0 = mysql_query($query0);
while($row = mysql_fetch_array($result0, MYSQLI_ASSOC))
{
$id_podr=$row["id"];
$id_cat=$row["cat"];
}
//echo "$id_cat - $id_podr<br />";

$query2 = "SELECT count(*) as cttt FROM `prod_trikotaj` where id_1c='$id_prod_1c'";
//echo "$query2<br />";
$result2 = mysql_query($query2);
while($row = mysql_fetch_array($result2, MYSQLI_ASSOC))
{
$cttt=$row["cttt"];
}
////проверяем есть ли такой товар
if ($cttt==0)
{

//товара нет - добавляем
$query_prod = "INSERT INTO `prod_trikotaj` (`art`, `name`, `cat`, `p`, `discr`, `id_1c`,`photo1`,`photo2`,`del`, `aktiv`, `sostav`)
 VALUES 
('$art_prod', '$name_prod', '$id_cat', '$id_podr','$opis','$id_prod_1c','$kartinka_name','$kartinka_name','1', '0', '$name_sostav');";

$result_prod = mysql_query($query_prod);
}
else 
{
//товар существует - ничего не делаем
//echo "ТОВАР СУЩЕСТВУЕТ НА САЙТЕ!<br />";
}
////проверяем есть ли такой товар

/////////////////1 узнаем категорию и подкатегорию/////////////
//////////////////////добавляем товар


}


}
}
/////////////////////////////////////////////////



                        echo "success\n";
                        echo session_name()."\n";
                        echo session_id()."\n";
                        //exit;
 
                } elseif ($xml && $this->filename == 'offers.xml') 
                {
                    




////////////////добавление цветов из справочника
//$sql_color = "TRUNCATE TABLE `color_prod`";
//$query = mysql_query($sql_color) or die('Ошибка чтения записи: '.mysql_error());
foreach($xml as $el)
{
////////////////////////////////////////////////

for ($a = 0; $a < 1000; $a++)  {

$id_color=$el->Свойства->Свойство[0]->ВариантыЗначений->Справочник[$a]->ИдЗначения;
$id_color_name=$el->Свойства->Свойство[0]->ВариантыЗначений->Справочник[$a]->Значение;
//echo "$id_color - $id_color_name<br />";
if ($id_color=="")
{
echo "";
}
else 
{


$query_z1 = "SELECT count(id) as cnt FROM `color_prod` where id_1c='$id_color' limit 1";
//echo "$query_z1<br />";
$result_z1 = mysql_query($query_z1);
while($row = mysql_fetch_array($result_z1, MYSQLI_ASSOC))
{
$cnt1=$row["cnt"];
}

if ($cnt1==0)
{
//echo "Характеристика цвета отсутсвует - добавляем<br />";
$query_color = "INSERT INTO `color_prod` ( `name`,  `id_1c`) VALUES ('$id_color_name','$id_color');";
//echo "$query_color<br />";
$result_color = mysql_query($query_color);
}
else 
{
echo "";
//echo "Характеристика цвета присутсвует<br />";
}



}
}
}
////////////////добавление цветов из справочника


////////////////добавление размеров из справочника
//$sql_razmer = "TRUNCATE TABLE `razmer_prod`";
//$query = mysql_query($sql_razmer) or die('Ошибка чтения записи: '.mysql_error());

foreach($xml as $el)
{
/////////////////////////////////////////////////
for ($a = 0; $a < 1000; $a++)  {
$id_razmer=$el->Свойства->Свойство[1]->ВариантыЗначений->Справочник[$a]->ИдЗначения;
$id_razmer_name=$el->Свойства->Свойство[1]->ВариантыЗначений->Справочник[$a]->Значение;
//echo "$id_razmer - $id_razmer_name<br />";
if ($id_razmer=="")
{
echo "";
}
else 
{


$query_z2 = "SELECT count(id) as cnt FROM `razmer_prod` where id_1c='$id_razmer' limit 1";
//echo "$query_z2<br />";
$result_z2 = mysql_query($query_z2);
while($row = mysql_fetch_array($result_z2, MYSQLI_ASSOC))
{
$cnt2=$row["cnt"];
}


if ($cnt2==0)
{
//echo "Характеристика размера отсутсвует - добавляем<br />";
$query_razmer = "INSERT INTO `razmer_prod` ( `name`,  `id_1c`) VALUES ('$id_razmer_name','$id_razmer');";
//echo "$query_razmer";
$result_razmer = mysql_query($query_razmer);

}
else 
{
echo "";
//echo "Характеристика размера присутсвует<br />";
}






}
}
}
////////////////добавление размеров из справочника

////////////////добавление расцветок из справочника
//$sql_rascv = "TRUNCATE TABLE `rascv_prod`";
//$query = mysql_query($sql_rascv) or die('Ошибка чтения записи: '.mysql_error());
foreach($xml as $el)
{
/////////////////////////////////////////////////
for ($a = 0; $a < 1000; $a++)  {
$id_rascv=$el->Свойства->Свойство[2]->ВариантыЗначений->Справочник[$a]->ИдЗначения;
$id_rascv_name=$el->Свойства->Свойство[2]->ВариантыЗначений->Справочник[$a]->Значение;
//echo "$id_rascv - $id_rascv_name<br />";
if ($id_rascv=="")
{
echo "";
}
else 
{


$query_z2 = "SELECT count(id) as cnt FROM `rascv_prod` where id_1c='$id_rascv' limit 1";
//echo "$query_z2<br />";
$result_z2 = mysql_query($query_z2);
while($row = mysql_fetch_array($result_z2, MYSQLI_ASSOC))
{
$cnt3=$row["cnt"];
}

if ($cnt3==0)
{
echo "";
//echo "Характеристика расцветки отсутсвует - добавляем<br />";
$query_rascv = "INSERT INTO `rascv_prod` ( `name`,  `id_1c`) VALUES ('$id_rascv_name','$id_rascv');";
//echo "$query_rascv<br />";
$result_rascv = mysql_query($query_rascv);

}
else 
{
echo "";
//echo "Характеристика расцветки присутсвует<br />";
}



}
}
}
////////////////добавление расцветок из справочника


////////////////////работаем с товаром////////////////////////////////////////

//$sql_price = "TRUNCATE TABLE `price_trikotaj`";
//$query_price = mysql_query($sql_price) or die('Ошибка чтения записи: '.mysql_error());



foreach($xml as $el)
{
for ($a = 0; $a < 10000; $a++)  {

$id_1c=$el->Предложения->Предложение[$a]->Ид;
$id_1c = explode("#", $id_1c);
$id_1c_1=$id_1c[0];
$id_1c_2=$id_1c[1];

$art_new=$el->Предложения->Предложение[$a]->Артикул;

$color_idd1=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[0]->Ид;
$color_idd2=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[1]->Ид;
$color_idd3=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[2]->Ид;


///////////////ищем размер

//////////////////////////////////////
switch ($color_idd1) {
    case 'fea5a0af-145c-11ef-8a7d-f4ce46b652e9':
$razmer=$el->Предложения->Предложение[$a]->ХарактеристикиТовара->ХарактеристикаТовара[0]->Значение;
$razmer_id=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[0]->Значение;
        break;
    case 'de67f8d4-1454-11ef-8a7d-f4ce46b652e9':
$color=$el->Предложения->Предложение[$a]->ХарактеристикиТовара->ХарактеристикаТовара[0]->Значение;
$color_id=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[0]->Значение;
        break;
    case 'e81832ea-7907-11ef-8a8b-f4ce46b652e9':
$rascvet=$el->Предложения->Предложение[$a]->ХарактеристикиТовара->ХарактеристикаТовара[0]->Значение;
$rascvet_id=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[0]->Значение;
        break;
default:
       echo "";
}
//////////////////////////////////////
//////////////////////////////////////
switch ($color_idd2) {
    case 'fea5a0af-145c-11ef-8a7d-f4ce46b652e9':
$razmer=$el->Предложения->Предложение[$a]->ХарактеристикиТовара->ХарактеристикаТовара[1]->Значение;
$razmer_id=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[1]->Значение;
        break;
    case 'de67f8d4-1454-11ef-8a7d-f4ce46b652e9':
$color=$el->Предложения->Предложение[$a]->ХарактеристикиТовара->ХарактеристикаТовара[1]->Значение;
$color_id=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[1]->Значение;
        break;
    case 'e81832ea-7907-11ef-8a8b-f4ce46b652e9':
$rascvet=$el->Предложения->Предложение[$a]->ХарактеристикиТовара->ХарактеристикаТовара[1]->Значение;
$rascvet_id=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[1]->Значение;
        break;
default:
       echo "";
}
//////////////////////////////////////


//////////////////////////////////////
switch ($color_idd3) {
    case 'fea5a0af-145c-11ef-8a7d-f4ce46b652e9':
$razmer=$el->Предложения->Предложение[$a]->ХарактеристикиТовара->ХарактеристикаТовара[2]->Значение;
$razmer_id=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[2]->Значение;
        break;
    case 'de67f8d4-1454-11ef-8a7d-f4ce46b652e9':
$color=$el->Предложения->Предложение[$a]->ХарактеристикиТовара->ХарактеристикаТовара[2]->Значение;
$color_id=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[2]->Значение;
        break;
    case 'e81832ea-7907-11ef-8a8b-f4ce46b652e9':
$rascvet=$el->Предложения->Предложение[$a]->ХарактеристикиТовара->ХарактеристикаТовара[2]->Значение;
$rascvet_id=$el->Предложения->Предложение[$a]->ЗначенияСвойств->ЗначенияСвойства[2]->Значение;
        break;
default:
       echo "";
}
//////////////////////////////////////




///[@Наименование=='Материал (Одежда)']

$price1=$el->Предложения->Предложение[$a]->Цены->Цена[0]->ЦенаЗаЕдиницу;
$price2=$el->Предложения->Предложение[$a]->Цены->Цена[1]->ЦенаЗаЕдиницу;
$price3=$el->Предложения->Предложение[$a]->Цены->Цена[2]->ЦенаЗаЕдиницу;
$price4=$el->Предложения->Предложение[$a]->Цены->Цена[3]->ЦенаЗаЕдиницу;
$price5=$el->Предложения->Предложение[$a]->Цены->Цена[4]->ЦенаЗаЕдиницу;
$price6=$el->Предложения->Предложение[$a]->Цены->Цена[5]->ЦенаЗаЕдиницу;
$price7=$el->Предложения->Предложение[$a]->Цены->Цена[6]->ЦенаЗаЕдиницу;

$kol=$el->Предложения->Предложение[$a]->Количество;




//////проверяем существование
if ($id_1c_1=="") {echo "";} else 
{


if ($kol>=0)
{
/*
echo "<p>111 <u>$color_idd</u></p>";
echo "<p>";
echo "ID_tovar - $id_1c_1<br />";
//echo "ID_razmer - $id_1c_2<br />";
echo "Цвет: $color<br />";
echo "Цвет_id: $color_id ($color_j)<br />";
echo "Размер: $razmer<br />";
echo "Размер_id: $razmer_id ($razmer_j)<br />";
echo "Цена: $price<br />";
echo "Количество: $kol<br />";
echo "</p>";
*/
///////////////проверяем наличие цвета товара
$query_colorr = "SELECT count(id) as count_tovar FROM `prod_trikotaj` where id_1c_color='$color_id' and id_1c='$id_1c_1' limit 1";
//echo "$query_colorr<br />";
$result_colorr = mysql_query($query_colorr);
while($row = mysql_fetch_array($result_colorr, MYSQLI_ASSOC))
{
$count_tovar=$row["count_tovar"];
}
//echo "<strong>Количество товара с этим цветом - $count_tovar</strong>";


if ($count_tovar==0) 
{
////делаем копию товара 

$query_dub_tovar = "SELECT * FROM `prod_trikotaj` where id_1c='$id_1c_1' and  del='1' limit 1";
//echo "$query_dub_tovar<br />";
$result_dub_tovar = mysql_query($query_dub_tovar);
while($row = mysql_fetch_array($result_dub_tovar, MYSQLI_ASSOC))
{
//$art=$row["art"];
$name=$row["name"];
$discr=$row["discr"];
$cat=$row["cat"];
$p=$row["p"];
$aktiv=$row["aktiv"];
$sostavvv=$row["sostav"];
//$id_1c=$row["id_1c"];
//$del=$row["del"];
//$id_1c_color=$row["id_1c_color"];
}
$name2="$name "."$color";

$query_prod_dbl = "INSERT INTO `prod_trikotaj` (`art`, `name`, `discr`, `cat`, `p`, `aktiv`, `id_1c`, `del`, `id_1c_color`, `sostav`)
 VALUES                                       ('$art_new', '$name2', '$discr', '$cat', '$p', '1', '$id_1c_1', '0', '$color_id','$sostavvv');";
//echo "$query_prod_dbl<br />";
$result_prod_dbl = mysql_query($query_prod_dbl);
///делаем копию товара 
}
else
{
echo "";
//echo "<u>Ничего не делаем этот товар уже есть!</u>";
/////////////////////////делать////////////////////////////////////


}


///////////////проверяем наличие цвета товара




////////////////проверяем наличие по количеству
//////////уднаем id товара
$query_razmer = "SELECT id FROM `prod_trikotaj` where id_1c='$id_1c_1' limit 1";
//echo "$query_razmer<br />";
$result_razmer = mysql_query($query_razmer);
while($row = mysql_fetch_array($result_razmer, MYSQLI_ASSOC))
{
$id_prod=$row["id"];
}


//$query_razmer1 = "SELECT count(id) as cnt,id FROM `prod_trikotaj_sv` where name='$razmer' limit 1";
$query_razmer1 = "SELECT count(id) as cnt,id FROM `razmer_prod` where id_1c='$razmer_id' limit 1";
//echo "******* - $query_razmer1<br />";
$result_razmer1 = mysql_query($query_razmer1);
while($row = mysql_fetch_array($result_razmer1, MYSQLI_ASSOC))
{
//$id_razmer="";
$id_razmer=$row["id"];
$cnt=$row["cnt"];
}

if ($cnt=="0") 
{
//echo "Размер не найден!";
}
else 
{
//echo "Номер размера - $id_razmer<br />";

//////////////проверяем наличие размера с ценой
$query_razmer11 = "SELECT count(id) as cnt FROM `price_trikotaj` where id_1c='$razmer_id' and id_1c_prod='$id_1c_1' and id_1c_color='$color_id' limit 1";
//echo "$query_razmer11<br />";
$result_razmer11 = mysql_query($query_razmer11);
while($row = mysql_fetch_array($result_razmer11, MYSQLI_ASSOC))
{
//$id_razmer="";
$cnt=$row["cnt"];
}
//////////////проверяем наличие размера



if ($cnt>0)
{
///цена уже есть - меняем
$query_prod_rzm0 = "UPDATE `price_trikotaj` SET price1='$price1',price2='$price2',price3='$price3',price4='$price4',price5='$price5',price6='$price6', price7='$price7', count='$kol' where id_1c='$razmer_id' and id_1c_prod='$id_1c_1' and id_1c_color='$color_id' ";
//echo "меняем цену и количество - $query_prod_rzm0<br />";
$result_prod_rzm0 = mysql_query($query_prod_rzm0);

}
else
{
///цены нет - добавляем
$query_prod_rzm = "INSERT INTO `price_trikotaj` (`id`, `id_p`, `sv`, `price1`, `price2`, `price3`,`price4`, `price5`, `price6`, `price7`, `colorr`, `count`, `ves`, `count2`,`id_1c`,`id_1c_prod`,`id_1c_color`) VALUES (NULL, '$id_prod', '$id_razmer', '$price1', '$price2', '$price3', '$price4', '$price5', '$price6', '$price7', '', '$kol', '', '','$razmer_id','$id_1c_1','$color_id');";
//echo "$query_prod_rzm<br />";
$result_prod_rzm = mysql_query($query_prod_rzm);

} 


//////////////проверяем наличие размера с ценой
$query_dll = "SELECT sum(count) as ct FROM `price_trikotaj` WHERE `id_1c_prod`='$id_1c_1' and  id_1c_color='$color_id' limit 1";
//echo "$query_dll<br />";
$result_dll = mysql_query($query_dll);
while($row = mysql_fetch_array($result_dll, MYSQLI_ASSOC))
{
//$id_razmer="";
$ct=$row["ct"];

if ($ct==0) {
$query_prod_dlll = "UPDATE `prod_trikotaj` SET aktiv='0' where `id_1c`='$id_1c_1' and  id_1c_color='$color_id' limit 1";
//echo "Нашелся товар $id_1c_1 - $query_prod_dlll<br />";
$result_prod_dlll = mysql_query($query_prod_dlll);
} else 
{
$query_prod_dlll = "UPDATE `prod_trikotaj` SET aktiv='1' where `id_1c`='$id_1c_1' and  id_1c_color='$color_id' limit 1";
//echo "Нашелся товар $id_1c_1 - $query_prod_dlll<br />";
$result_prod_dlll = mysql_query($query_prod_dlll);

}

}
//////////////проверяем наличие размера




$img_d1=$el->Предложения->Предложение[$a]->Картинка[0];
$img_d2=$el->Предложения->Предложение[$a]->Картинка[1];
$img_d3=$el->Предложения->Предложение[$a]->Картинка[2];
$img_d4=$el->Предложения->Предложение[$a]->Картинка[3];
$img_d5=$el->Предложения->Предложение[$a]->Картинка[4];
$img_d6=$el->Предложения->Предложение[$a]->Картинка[5];
$img_d7=$el->Предложения->Предложение[$a]->Картинка[6];
$img_d8=$el->Предложения->Предложение[$a]->Картинка[7];
$img_d9=$el->Предложения->Предложение[$a]->Картинка[8];
$img_d10=$el->Предложения->Предложение[$a]->Картинка[9];
$img_d11=$el->Предложения->Предложение[$a]->Картинка[10];
$img_d12=$el->Предложения->Предложение[$a]->Картинка[11];
$img_d13=$el->Предложения->Предложение[$a]->Картинка[12];
$img_d14=$el->Предложения->Предложение[$a]->Картинка[13];
$img_d15=$el->Предложения->Предложение[$a]->Картинка[14];


$d1=dopphoto($img_d1,$color_id,$id_1c_1);
//echo "<p>$d1</p>";

if ($d1=="")
{
echo "";
}
else 
{
$query_prod_photo0 = "UPDATE `prod_trikotaj` SET photo1='$d1',photo2='$d1' where id_1c='$id_1c_1' and id_1c_color='$color_id' ";
//echo "добавляем фото $query_prod_photo0<br />";
$result_prod_photo0 = mysql_query($query_prod_photo0);
}

$d2=dopphoto($img_d2,$color_id,$id_1c_1);
$d3=dopphoto($img_d3,$color_id,$id_1c_1);
$d4=dopphoto($img_d4,$color_id,$id_1c_1);
$d5=dopphoto($img_d5,$color_id,$id_1c_1);
$d6=dopphoto($img_d6,$color_id,$id_1c_1);
$d7=dopphoto($img_d7,$color_id,$id_1c_1);
$d8=dopphoto($img_d8,$color_id,$id_1c_1);
$d9=dopphoto($img_d9,$color_id,$id_1c_1);
$d10=dopphoto($img_d10,$color_id,$id_1c_1);
$d11=dopphoto($img_d11,$color_id,$id_1c_1);
$d12=dopphoto($img_d12,$color_id,$id_1c_1);
$d13=dopphoto($img_d13,$color_id,$id_1c_1);
$d14=dopphoto($img_d14,$color_id,$id_1c_1);
$d15=dopphoto($img_d15,$color_id,$id_1c_1);




}

////////////////проверяем наличие по количеству



}
else 
{
echo "";
}


//////проверяем существование
}
}
}


/////////выключаем товар у которого нет картинок





$query_prod_dl = "UPDATE `prod_trikotaj` SET aktiv='0' where del='1'";
$result_prod_dl = mysql_query($query_prod_dl);

$query_prod_dl = "delete from `prod_trikotaj` where  photo1='nophoto.jpg'";
$result_prod_dl = mysql_query($query_prod_dl);



////////////////////работаем с товаром////////////////////////////////////////



                    echo "success\n";
                        echo session_name()."\n";
                        echo session_id()."\n";
                    
                } 
                else 
                {
                        echo "Ошибка загрузки XML\n";
                        foreach (libxml_get_errors() as $error) {
                                echo "\t", $error->message;
                        }
                        exit;
                }
        }
 
}
session_start();
$exaple = new Exchange1c();
$exaple->run();




 ?>