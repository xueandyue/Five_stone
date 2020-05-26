<?php 
session_start();
header("content-type=text/html;charset='utf8'");
$id=isset($_GET['id'])?$_GET['id']: '';
if(!isset($_SESSION['username']))
{

	echo '<meta http-equiv="refresh" content="1;url=login.php"/>';
	exit();
}
require_once 'PdoMySQL.class.php';
require_once 'config.php';
//3.得到连接对象
$PdoMySQL=new PdoMySQL();
$table='user';
$username=
$res=$PdoMySQL->find($table,"id='{$id}' ");
// var_dump($res);
$username=$res['username'];
$sum=$res['sum'];
$win_sum=$res['win_sum'];
$heju=$res['heju'];
$row=$PdoMySQL->find($table,"is_online='1'");//查找在线玩家


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>玩家个人主页</title>
	<style type="text/css">
	*{
		margin: 0;
		padding: 0;
	}
	#main{

		width: 600px;

		margin: 0 auto;
    border:1px solid;
    overflow: hidden;

	}


	</style>
	<script type="text/javascript" src="./js/jquery-2.1.1.js"></script>
	<script type="text/javascript">
  $(document).ready(function() {

	  
	  //获取数据是否有人邀请对战
     function is_yourenyaoqing()
      {
      
    	var me_id=$('#me_id').text();
        $.ajax({
         url: "./admin/getyaoqing.php",
         type: 'post',
           data:{'Later_player':me_id},   //发送到后端的json数据
           dataType:'text',  //设置返回数据格式为: 文本格式
           success:function(data){  //
            var a=JSON.parse(data);
            if(a.type=='0')
            {
              return;
            }
            if(a.type==1)
            {
            if(confirm("收到玩家"+a.first_player+"的对战邀请,确定接受邀请对战吗？")){

              $.ajax({
               url: "./admin/agreeyaoqing.php",
                type: 'post',
              data:{'later_player_agree':'1','Later_player':me_id},   //发送到后端的json数据
             dataType:'text',  //设置返回数据格式为: 文本格式
           success:function(data){  //成功返回数据时的回调函数
            var obj=JSON.parse(data);
                // alert(data);   //输出返回的文本
                if(obj.type=='1')
                {
                   window.location.href="fight.php?id="+me_id+"&player="+a.first_player;
                }
                else{
                  alert('同意邀请失败');
                  return;
                }

        
                 // temp.style.background='red';

               },
               error:function(e){
                 alert('请求错误或失败');
               }
             });







         		    
         		  }
         		  else{

      		   
         		  }
            }
//得到与数据库对比后要更新的数据
              

               },
               error:function(e){
                 alert('请求错误或失败');
               }
             });
      }


  
      var t1 = window.setInterval(is_yourenyaoqing,3000);




      //
       var updatelist=function()
  {

    var id=$('#me_id').text();


      $.ajax({
         url: "./admin/update_isonline.php",
         type: 'post',
         data:{'id':id},   //发送到后端的json数据
           dataType:'text',  //设置返回数据格式为: 文本格式
           success:function(data){  //
       

             var obj=JSON.parse(data);
           
          
          
             var str='<h4>玩家在线列表:</h4>';
             if(obj.length==1)
             {
           
              str+="<h3>暂时无其他玩家在线</h3>";
              $('#list').html(str);
              return;
             }

             
           for (var i = 0; i < obj.length; i++) {
             var str1="<h4>玩家在线列表:</h4>";
                  if(obj[i].id!=$('#me_id').html())
                  {

              var str2='<div style="overflow: hidden;"><div style="float: left;"><h4 style="width: 100px;">'+obj[i].username+'</h4></div>  <div style="float: left;margin-left: 50px;">';
   var str3='<h3 class="duifang_id" style="display: none;">'+obj[i].id+'</h3>';
   var str4='<button class="yaoqingduizhan" onclick="yaoqingduizhan(this);" >邀请对战</button></div></div>';
  str+=str2+str3+str4;

          
                  
                }
            
           }
     
           $('#list').html(str);






           

               },
               error:function(e){
                 alert('请求错误或失败');
               }
             });



  };

   var t1 = window.setInterval(updatelist,8000);

      ///
  
// hjh
    
  });
    

	</script>



  <script type="text/javascript">
  $(document).ready(function() {

    function player_agree()
    {

      var first_player=$('#me_id').text();

      $.ajax({
           url: "./admin/firstplayergetagree.php",
           type: 'post',
           data:{'first_player':first_player},   //发送到后端的json数据
           dataType:'text',  //设置返回数据格式为: 文本格式
           success:function(data){  //成功返回数据时的回调函数
           
           var obj=JSON.parse(data);
           if(obj.type=='1')
           {
            alert("玩家"+obj.laterplayer+"同意对战");
  window.location.href="fight.php?id="+first_player+"&player="+obj.laterplayer;
           }
           else{
            return;
           }
          
            
              // var jsonObj = eval("("+data+")");  //将json字符串转为json对象
             //  var test=jsonObj.username+jsonObj.password;
            // alert(jsonObj.username);
            // alert(jsonObj.password)
           // alert(test);
              
           },
           error:function(e){
               alert('请求错误或失败');
           }
       });


    }

var t2 = window.setInterval(player_agree,3000);

    



  });


  </script>
  <script type="text/javascript">
    function yaoqingduizhan (_this){

       var that = $(_this);
     

    var me_id=$('#me_id').text();
    var duifang_id=that.parent('div').find('.duifang_id ').text();
   
   
    $.ajax({
         url: "./admin/isyaoqing.php",
         type: 'post',
           data:{'first_player':me_id,'Later_player':duifang_id},   //发送到后端的json数据
           dataType:'text',  //设置返回数据格式为: 文本格式
           success:function(data){  //成功返回数据时的回调函数
           //输出返回的文本
//得到与数据库对比后要更新的数据
         

               },
               error:function(e){
                 alert('请求错误或失败');
               }
             });
     
   }



  </script>

  
</head>
<body>
<div  id="me_id"style="display:none;"><?php echo $id;?></div>

<div id="main" style="margin-top:50px;">
<div style="overflow: hidden; ">
<div style="float: left;"><h4>欢迎来到五子棋网络对战平台</h4></div>
	<div style="float: right;"><a href="./exit.php?id=<?php echo $id;?>">


  <button>退出登录</button></a></div>
	

</div>

<div>
<div style="overflow: hidden;text-align: center; font-size: 20px;"><span><?php echo $username; ?>个人主页</span></div>
<div style="border:1px solid; border-radius: 10px 10px 10px 10px;">
	<h4>玩家战绩信息</h4>
	<h4>对战局数:<?php echo $sum;?></h4>
	<h4>已赢局数:<?php echo $win_sum;?></h4>
	<h4>和:<?php echo $heju;?></h4>

</div>

<div  id="list" style=" overflow: hidden; margin-top: 20px;">
<h4>玩家在线列表:</h4>
<?php 
  if($row=='')
  {
  	echo "<h3>暂时无其他玩家在线</h3>";
  }
  else{

  
  foreach ($row as $value)
  {
    if(is_array($value)==false)
    {
      echo "<h3>暂时无其他玩家在线</h3>";
      return ;

    }

  	if($value['id']!=$id)
  	{
  			 
  
  ?>
  

	
	
	<div style="overflow: hidden;">
	<div style="float: left;"><h4 style="width: 100px;"><?php echo $value['username'];?></h4></div>
	<div style="float: left;margin-left: 50px;">
  <h3  class="duifang_id" style="display: none;"><?php echo  $value['id']?></h3>
	<button class="yaoqingduizhan" onclick="yaoqingduizhan(this);">邀请对战</button>
	</div>
	</div>
	
	<?php 
	
  	}
	
	}
	}
	
	
	
	
	?>
</div>
</div>
</div>




</body>
</html>
