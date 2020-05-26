<?php

session_start();
header("content-type=text/html;charset='utf8'");
if(!isset($_SESSION['username']))
{

	echo '<meta http-equiv="refresh" content="1;url=login.php"/>';
	exit();
}
require_once './PdoMySQL.class.php';
require_once './config.php';
$PdoMySQL=new PdoMySQL();
$player=isset ( $_GET ['player'] ) ? $_GET ['player'] : '';
$id=isset ( $_GET ['id'] ) ? $_GET ['id'] : '';


$tabName='user';
$row=$PdoMySQL->findById($tabName, $id);
$username=$row['username'];
$is_xianshou='true';

$table='chess_game';
$chess_game=$PdoMySQL->find($table,"first_player='{$id}'  AND gameover!='1' ");
if(empty($chess_game))
{
	$is_xianshou='false';
	$chess_game=$PdoMySQL->find($table,"later_player='{$id}' AND gameover!='1' ");
	
	$table_id=$chess_game['id'];
	

}
else {
	
	$table_id=$chess_game['id'];

}
$row=$PdoMySQL->find($tabName,"username='{$player}'");
$duizhanplayer=$row['id'];




?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>五子棋</title>
	<style type="text/css">
	*{
		margin: 10px;
		padding: 0px;
		font-size: 20px;
	}
	canvas{
		display: block;
		margin: 10px auto;
		box-shadow: -2px -2px 2px #EFEFEF,5px 5px 5px #B9B9B9;
	}

	</style>
		<script type="text/javascript" src="./js/jquery-2.1.1.js"></script>
	<script type="text/javascript">

	var is_xianshou=<?php echo $is_xianshou;?>;
		var n=15;//15行
		var count=0;
		var isOver=false;
		var me_id="<?php echo $id;?>";
	    var table_id="<?php echo $table_id;?>";
		var me=<?php echo $is_xianshou;?>;
		var chessFlag=[];//二维数组储存棋盘落子情况
		for (var i = 0; i < n; i++) {
			chessFlag[i]=[];
			for (var j = 0; j < n; j++) {
				chessFlag[i][j]='0';//0为无子，1为黑子，2为白子
			}
		}
		var is_xiazi=<?php echo $is_xianshou;?>;
        var duizhanplayer_id="<?php echo $duizhanplayer; ?>";


       
	$(document).ready(function() {



	     var chess=document.getElementById('chess');
		var context=chess.getContext('2d');
		context.strokeStyle="#BFBFBF";
       
		//true为黑棋，flase为白旗，先手为黑棋，后手白棋
		var oneStep=function( i, j,me)
		{
		
		    context.beginPath();
			context.arc(30+j*40,30+i*40,18,0,2*Math.PI);//0,2*Math.PI为弧度,13为半径
			context.closePath();
			//渐变
			var gradient=context.createRadialGradient(30+j*40+2,30+i*40-2,18,30+j*40+2,30+i*40-2,0);
			if(me)//判断是否下黑棋还是白旗
			{
				//黑棋
            gradient.addColorStop(0,"#0A0A0A");
			gradient.addColorStop(1,"#636766");
		
			}
			else{
			//白棋
			gradient.addColorStop(0,"#D1D1D1");
			gradient.addColorStop(1,"#F9F9F9");
			}
			context.fillStyle=gradient;
			context.fill();
		};

				function update_qipan()
       {
        $.ajax({
           url: "./admin/updateqipan.php",
           type: 'post',
           data:{'id':table_id},   //发送到后端的json数据
           dataType:'text',  //设置返回数据格式为: 文本格式
           success:function(data){  //成功返回数据时的回调函数
       
         
           var obj=JSON.parse(data);
           if(obj.code=='400')
           {
           	return;
           }
           if(chessFlag[obj.i][obj.j]=='0')
           {
           	if(obj.qizivalue=='1')
           {
           	var qizi=true;

           }
           else if (obj.qizivalue=='2') 
           {

           	var qizi=false;

           }
           else{
           	return;
           }



           oneStep(obj.i,obj.j,qizi);
           chessFlag[obj.i][obj.j]=obj.qizivalue;
          
           
           if(is_win(obj.i,obj.j)=='1')
           {
               if(is_xianshou)
               {
               	  alert("恭喜你战胜了<?php  echo $player;?>");
               	  $('#gameover').html("恭喜你战胜了<?php echo $player;?>");
               }
               else{
               	alert("你输给了<?php  echo $player;?>");
               	$('#gameover').html("你输给了<?php echo $player;?>");

               }
               
           }
           if(is_win(obj.i,obj.j)=='2')
           {

           	

           	
                if(is_xianshou)
               {

               		alert("你输给了<?php  echo $player;?>");
               	$('#gameover').html("你输给了<?php echo $player;?>");

               	
               }
               else{

               	  alert("恭喜你战胜了<?php  echo $player;?>");
               	  $('#gameover').html("恭喜你战胜了<?php echo $player;?>");
               
               }
               
           }
           if(is_win(obj.i,obj.j)=='0')
           {

           	alert("居然平局了！");
           	$('#gameover').html("居然平局了！");
           }
               
           if(is_win(obj.i,obj.j)!='gamenot_over')
           {
           	$.ajax({
         url: "./admin/querenover.php",
         type: 'post',
      
         data:{'id':table_id,'me_id':me_id,'player_id':duizhanplayer_id},   //发送到后端的json数据
           dataType:'text',  //设置返回数据格式为: 文本格式
           success:function(data){  //

           	// 成功返回数据时的回调函数

               },
               error:function(e){
                 alert('请求错误或失败');
               }
             });
           	return;
           }
           is_xiazi=true; 


       }
           
           },
           error:function(e){
               alert('请求错误或失败');
           }
       });


    }
		 var t2 = window.setInterval(update_qipan,3000);


		 // var lost=function() {

		 // 	 for (var i1 = 0; i1 < n; i1++) {
 
   //    	var a=""
   //    	for (var j1 = 0; j1 < n; j1++) {
   //    		a=a+" "+chessFlag[i1][j1]+" ";
     
      		
   //    	}
   //    	 		console.log(a);
      	
   //       }
		 // }

		 // var t2 = window.setInterval(lost,6000);



         
		 chess.onclick=function(e)
		{

			if(isOver)
			{

				return ;
			}





		 		if(is_xiazi==false)
			{
				alert('先等对方下子');
				return;
			}

			var x=e.offsetX;
			var y=e.offsetY;
			var j=Math.floor(x/40);
			var i=Math.floor(y/40);
			
			if(chessFlag[i][j]=='0')
			{

				
			 oneStep(i,j,me);
			   if(me)
			{
				chessFlag[i][j]='1';


			}
			else{
				chessFlag[i][j]='2';

			}

			

            is_xiazi=false;
			var code=is_win(i,j);
			if(code!='gamenot_over')
			{

				 $.ajax({
         url: "./admin/gameover.php",
         type: 'post',
         // data: "base_salary="+JSON.stringify(data),

         data:{'chessFlag':JSON.stringify(chessFlag),'i':i,'j':j,
         'qizivalue':chessFlag[i][j],'id':table_id,'code':code,'me_id':me_id,'player_id':duizhanplayer_id,'is_xianshou':is_xianshou},   //发送到后端的json数据
           dataType:'text',  //设置返回数据格式为: 文本格式
           success:function(data){  //

           	// 成功返回数据时的回调函数

               },
               error:function(e){
                 alert('请求错误或失败');
               }
             });


			}


				 if(code=='1')
           {
          
               if(is_xianshou)
               {
               	  alert("恭喜你战胜了<?php echo $player;?>");
               	  $('#gameover').html("恭喜你战胜了<?php echo $player;?>");
               }
               else{
               	alert("你输给了<?php echo $player;?>");
               	$('#gameover').html("你输给了<?php echo $player;?>");
               }

               isOver=true;
               return;
               
           }
           //hhh
           if(code=='2')
           {
         

           	if(is_xianshou)
               {
               	  alert("你输给了<?php echo $player;?>");
               	  $('#gameover').html("你输给了<?php echo $player;?>");
               }
               else{
               	alert("恭喜你战胜了<?php echo $player;?>");
               	 $('#gameover').html("恭喜你战胜了<?php echo $player;?>");
               }
               isOver=true;
               return;
               
           }

           //hhhh

             if(code=='0')
           {

           	alert("居然平局了！");
           	 $('#gameover').html("居然平局了！");
           	isOver=true;
               return;
           }


           //hhh

     
           $.ajax({
         url: "./admin/luozi.php",
         type: 'post',
         // data: "base_salary="+JSON.stringify(data),

         data:{'chessFlag':JSON.stringify(chessFlag),'i':i,'j':j,
         'qizivalue':chessFlag[i][j],'id':table_id},   //发送到后端的json数据
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
		}




		 //画棋盘

		 for (var i = 0; i < n; i++)
		 {
			context.moveTo(30+i*40,30);
			context.lineTo(30+i*40,590);
			context.stroke();
			context.moveTo(30,30+i*40);
			context.lineTo(590,i*40+30);
			context.stroke();


		}

		//jjljl

		//判断输赢函数，返回值'1'为黑子，即是先手胜，'2'为白子胜,'0'平局
	var is_win=function(i,j){
      var x = i;
      var y = j;
    for (var j = 0; j < n - 4; j++) {
        var str = '';
        for (var k = j; (k <= j+4) && (k<n) ; k++) {        
            str += chessFlag[x][k];
        }
        if (str == '11111') {        	         
            return '1';
        }
        if (str == '22222') {
            return '2';
        }

    }

    // 竖方向

    for (var i = 0; i< n - 4; i++) {
        var str = '';
        for (var k = i; (k <= i+ 4) && (k<n) ; k++) {
            str += chessFlag[k][y];

        }
        if (str=='11111') {       	          
            return '1';
        }
        if (str == '22222') {
            return '2';
        }

    }

    // 左斜45度
    if ((x + y) <= n) {
        for (var i = 0; i <= x + y - 4; i++) {
            var str = '';
            for (var k = i; (k <= i+4)  && (k<n) && (x+y-i<n); k++) {
          
                str += chessFlag[k][x + y - k];

            }
            if (str == '11111') {            	              
                return '1';
            }
            if (str == '22222') {
                return '2';
            }

        }

    } else {

        for (var i = x + y + 1 - n; i < n; i++) {
            var str = '';
            for (var k = i; (k <= i + 4) && (k<n) && (x+y-i) <n; k++) {
                str += chessFlag[k][x + y - k];

            }
            if (str == '11111') {
                return '1';
            }
            if (str == '22222') {
                return '2';
            }

        }

    }
    // 左斜45度结束
    // 右斜45度开始
    var b = y-x; //截距  y=x+b;
    if ((x-y)>=0) { 	
        // x1 = -b;
        // y1=n-1-b;//起点(0,x1),终点点(n-1,y1)
        for (var i = -b; i < n - 4; i++) {
            var str = '';
            for (var k = i; (k<=i+4) && (k<n) && (k+b<n); k++) {
                str += chessFlag[k][k + b];
            }
            if (str == '11111') {           
                return '1';
            }
            if (str == '22222') {
                return '2';;
            }
        }

    } 
    else {

        for (var i = 0; i <=n-b-5; i++) {
            var str = '';
            for (var k = i; (k <= i + 4)&& (k+b<n) && (k<n); k++) {
                str += chessFlag[k][k + b];

            }
            if (str == '11111') {
                return '1';
            }
            if (str == '22222') {
                return '2';
            }

        }
    }

    for (var i = 0; i < n; i++) {
        for (var j = 0; j < n; j++) {
            if (chessFlag[i][j] == '0') {
                return 'gamenot_over';
            }
        }

    }

    return '0';
	};

	});

    </script>
	





    
    
</head>
<body>
<div style="width: 600px; margin: 0px auto; text-align: center; margin-bottom: 10px;">
<h3 >欢迎你<?php  echo $username;?>&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
你的对手是<?php  echo $player;?>

</h3>

<h3  id="gameover" style="background: red;width: 200px;margin: 0 auto;">
</h3>

</div>

<canvas id="chess" width="700px" height="630px;"></canvas>
	
</body>
</html>