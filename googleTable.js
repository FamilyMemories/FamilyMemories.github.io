function getTable(id,gid){
var csv, array;
csv = file_get_contents(id, gid);
csv = explode("\r\n", $csv);
array = array_map('str_getcsv', csv);
return array; // возвращаем результат
}