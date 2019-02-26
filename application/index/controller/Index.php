<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller{
    public function index(){
        return view();
    }
    public function clock(){
    	return view();
    }
    public function javascript(){
    	return view();
    }
    public function backup_database(){	// php备份数据库
        $doc_root=$_SERVER['DOCUMENT_ROOT'];
        var_dump($doc_root);
        $file_path_name=$doc_root.'/sqlbackup';
        $name = 'backup_'.date('YmdHis').".sql";
        if(!file_exists($file_path_name)){
            mkdir($file_path_name,0777);
        }
        $mysqldump_url='D:\phpStudy\MySQL\bin\mysqldump.exe';//mysqldump.exe的绝对路径，安装mysql自带的有，可以搜索一下路径
        $host='127.0.0.1';//数据库所在的服务器地址
        $User='root';//数据库用户名
        $Password='root';//数据库密码
        $databaseName='photovoltaic';//数据库名
        $process=$mysqldump_url." -h".$host." -u".$User."  -p".$Password."  ".$databaseName." >".$file_path_name."/".$name;
        $er=system($process);//system()执行外部程序，并且显示输出
        if($er!==false){
            echo json_encode('success!');
        }else{
            echo json_encode('error!');
        }
    }
}
