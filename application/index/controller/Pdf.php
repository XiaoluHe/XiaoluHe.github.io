<?php
namespace app\index\controller;
header("Content-type:html/text; charset=utf-8");

class Pdf {
	public function index(){
		if (input("post.")) {	// 如果有post数据，那么则执行打印

    		$html=input("post.print-content");
    		$filename = "test";
		    //Turn on output buffering
		    ob_start();
		    $date = date("Y年m月d日");
		 	
		    $html='<meta lang="uft-8">
		    <link rel="stylesheet" href="css/common.css" rel="external nofollow" rel="external nofollow" >
		    <link rel="stylesheet" href="css/myCenter.css" rel="external nofollow" rel="external nofollow" >
		    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$html;
		    //这儿可以引入生成的Html的样式表 路径可以是绝对路径也可以是相对路径，也可以把样式表文件复制到临时html文件的目录下 即这儿的demo文件目录下（默认） 也可以直接把样式写在html页面中直接传递过来
		    //$html = ob_get_contents();
		    //$html=$html1.$html;
		    $filename = "hld";
		    //save the html page in tmp folder 保存的html临时文件位置 可以是相对路径也是可以是绝对路径 下面用相对路径
		    file_put_contents("{$filename}.html", $html);
		 	
		    //Clean the output buffer and turn off output buffering
		    ob_end_clean();
		 
		    //convert HTML to PDF
		    shell_exec("wkhtmltopdf -q {$filename}.html {$filename}.pdf");
		    if(file_exists("{$filename}.pdf")){
		      header("Content-type:application/pdf");
		      header("Content-Disposition:attachment;filename={$filename}.pdf");
		      echo file_get_contents("{$filename}.pdf");
		      //echo "{$filename}.pdf";
		    }else{
		      exit;
		    }
    	}
		return view();
	}
}