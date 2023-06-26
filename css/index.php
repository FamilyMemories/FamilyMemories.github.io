<?php
function googleTable(
    $gid = 0, 
    $id = '1jchFjReK8KlENyXd7hUwyCtOiL741Ms1pJ_hPVOw-Ig'
    )
{
	$csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
	$csv = explode("\r\n", $csv);
	$result = array_map('str_getcsv', $csv);

    $array = []; $array2 = [];
    foreach($result as $key => $value)
    {
        if ($key == 0)
        {
            $v = $value;
        }
        else
        {
            foreach($value as $key2 => $value2)
            {
                $array[$v[$key2]] = $value[$key2];
            }
            $array2[] = $array;
        }
    }
    return $array2;
}
function translit($value)
{
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
 
		'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
		'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
		'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
		'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
		'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
		'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
		'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
	);
 
	$value = strtr($value, $converter);
	return $value;
}
?>
<style>
 .div {
    border: 1px solid #333;
    padding: 8px 12px;
 }
</style>
<link rel="stylesheet" href='https://raw.githubusercontent.com/FamilyMemories/FamilyMemories.github.io/main/css/1.css'>

<form method='post'>
<div align='center'>
    <input type='text' placeholder='Search...' name='Search' class='enjoy-css-10 radius medium'>
<input class='genric-btn info radius medium' id='Searchsend' name='Searchsend' type='submit' value='&#128269;'>
</div>
</form>

<?php
$items = GoogleTable();
json_encode($items, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

if (isset($_POST['Searchsend']))
{
    $needle = $_POST['Search'];
    
    $needletag = translit(mb_strtolower($needle));
    $pos = strripos($tags, $needletag);
    foreach($items as $key => $value) {
        $name = translit(mb_strtolower($value["Name"]));
        $surname = translit(mb_strtolower($value["Surname"]));
        $middleName = translit(mb_strtolower($value["Middle name"]));
        if (($name == $needletag) || ($surname == $needletag) || ($middleName == $needletag)){
            echo "<div class='div'>";
            foreach($value as $k => $v) {
                if ($v != '')
                {
                    echo $k .": ".$v."<br>";
                    $pos = true;
                }
            }
            echo "</div><br>";
            $err = 0;
        }
        elseif ($pos === false)
            {
                $err = 1;
            }
    }
    if ($err == 1)
    {
        ?>
        <div align="center">
        <div class="col-xl-8 col-lg-8" align="center">	
            <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo  'Поиск по ключевому слову "'.$needle.'" не дал результатов!' ;?>
        </div></div></div>
        <?php
    }
}