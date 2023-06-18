function getTable(id,gid){
var csv, array;
var gid = 0;
var id = '1lSdGFGr-X-uNSNv4_3PFKJgvRNt_YOEYffCHP-WWAkM';
csv = file_get_contents(id, gid);
csv = explode("\r\n", $csv);
array = array_map('str_getcsv', csv);
return array; // возвращаем результат
}