<?php
namespace app\admin\controller;
use app\base\controller\Admin;

class Index2 extends Admin
{
    public function checkDb(){
//        连接实例数据库
        $shili_database = require_once IA_ROOT.'/data/shili_config.php';
        $shili_db = new \DB($shili_database);

        //获取当前连接数据库名称
        $ret = pdo_fetch("show tables");
        $database = '';
        foreach ($ret as $key => $item) {
            $database = str_replace("Tables_in_","",$key);
            break;
        }

        //获取当前项目的所有表
        $tables = pdo_fetchall("
            SHOW TABLE STATUS
            FROM `".$database."`
            where name like '%\_sqtg\_sun\_%'
        ");

//        获取实例中的所有表
        $tables_shili = $shili_db->fetchall("
            SHOW TABLE STATUS
            FROM `".$shili_database['database']."`
            where name like '%\_sqtg\_sun\_%'
        ",null,'Name');
        $tables_shili = array_keys($tables_shili);

        $not_exists_tables = [];
        $table_not_exists_fields = [];

//        对比表
        foreach ($tables as $item) {
            if (!in_array($item['Name'],$tables_shili)){
                $not_exists_tables[] = $item['Name'];
            }else{
                $not_exists_fields = [];
//                表结构
                $fields = pdo_fetchall("show columns from `".$item['Name']."`",null,'Field');

//                实例中的表结构
                $fields_shili = $shili_db->fetchall("show columns from `".$item['Name']."`",null,'Field');
                $fields_shili = array_keys($fields_shili);
//                对比表结构
                foreach ($fields as $field) {
                    if (!in_array($field['Field'],$fields_shili)){
                        $not_exists_fields[] = $field['Field'];
                    }
                }
                if(count($not_exists_fields)){
                    $table_not_exists_fields[$item['Name']] = $not_exists_fields;
                }
            }
        }

        echo '------------------- not exists tables ------------------------<br>';
        echo '<pre>';
        print_r($not_exists_tables);
        echo '</pre>';

        echo '------------------- not exists fields ------------------------<br>';
        echo '<pre>';
        print_r($table_not_exists_fields);
        echo '</pre>';


    }
}
