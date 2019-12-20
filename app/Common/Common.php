<?php 

//公共函数文件

function showMsg(){
	echo "延安归故里";
}
function hh(){
	echo "绵绵思远道";
}
 
function getCateId($cateInfo,$parent_id){
    static $id=[];
    $id[$parent_id]=$parent_id;
    foreach ($cateInfo as $k => $v) {
     if($v['parent_id']==$parent_id){
        $id['cate_id']=$v['cate_id'];
        getCateId($cateInfo,$v['cate_id']);
     }
    }
    return $id;
}
 ?>