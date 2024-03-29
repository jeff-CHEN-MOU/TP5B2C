<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------


//加密cookie

function encryption($value,$type=0) {//type 0：加密 value 1：解密
	$key =config('encryption_key');
	if ($type == 0){
		//加密
		return str_replace('=','',base64_encode($value ^$key));
	}else{
		//解密
		$value = base64_decode($value);
		return $value ^ $key;
	}

	die();
}


//图片资源处理函数
function my_scandir($dir=UEDITOR)
{
    $files = array();
    //$path = $dir;
    //dir=ueditot是给之前目录定义了一个常量赋予了一个值
    //ueditor是之前定义好的路径
    $dir_list=scandir($dir);
    //scandir函数是列出images图片目录中的文件和目录
     //dump($dir_list);die();
    foreach ($dir_list as $file){
        if ($file != '.' &&  $file != '..'){
            if (is_dir($dir.'/'.$file)){
                $files[$file]=my_scandir($dir.'/'.$file);
            }else{
                $files[]=$dir.'/'.$file;
            }
        }
    }
    return $files;
}
// 应用公共文件
//PHP截取多余字符用省略号代替  字符串截取
function cut_str($sourcestr,$cutlength)
{
    $returnstr='';
    $i=0;
    $n=0;
    $str_length=strlen($sourcestr);//字符串的字节数
    while (($n<$cutlength) and ($i<=$str_length))
    {
        $temp_str=substr($sourcestr,$i,1);
        $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
        if ($ascnum>=224)    //如果ASCII位高与224，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
            $i=$i+3;            //实际Byte计为3
            $n++;            //字串长度计1
        }
        elseif ($ascnum>=192) //如果ASCII位高与192，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
            $i=$i+2;            //实际Byte计为2
            $n++;            //字串长度计1
        }
        elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,1);
            $i=$i+1;            //实际的Byte数仍计1个
            $n++;            //但考虑整体美观，大写字母计成一个高位字符
        }
        else                //其他情况下，包括小写字母和半角标点符号，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,1);
            $i=$i+1;            //实际的Byte数计1个
            $n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽…
        }
    }
    if ($str_length>$i){
        $returnstr = $returnstr . "…";//超过长度时在尾处加上省略号
    }
    return $returnstr;
}

//邮箱发送函数
//发送邮件

