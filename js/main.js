$().ready(function() {
	$("#login_form").validate({
		rules: {
			username: "required",
			password: {
				required: true,
				minlength: 6
			},
		},
		messages: {
			username: "请输入有效邮箱",
			password: {
				required: "请输入密码",
				minlength: jQuery.format("密码不能小于{0}个字 符")
			},
		},

		 submitHandler:function(form){
            $.ajax({
            type: "post",
            url: "./admin/loginform.php?act=login",     
            data: $("#login_form").serialize(),    
            success: function(data) {
            	 var jsonObj = eval("("+data+")");  //将json字符串转为json对象
            	
            	switch (jsonObj.type) {
            		case '0':
            		alert('用户名或密码错误');
            			break;
            					case '1':
            					form.submit();
            			
            			break;
            			case '2':
            					alert('请先登录邮箱激活');
            			break;
            				default:
            					// statements_def
            					break;
            	
            	}
             
            },
            error: function(data) {
//                 alert(data);

            }
        });
        }    
	});
	$("#register_form").validate({
		rules: {
			username: "required",
			password: {
				required: true,
				minlength: 6
			},
			rpassword: {
				equalTo: "#register_password"
			},
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			username: "请输入用户名",
			password: {
				required: "请输入密码",
				minlength: jQuery.format("密码不能小于{0}个字 符")
			},
			rpassword: {
				equalTo: "两次密码不一样"
			},
			email: {
				required: "请输入邮箱",
				email: "请输入有效邮箱"
			}
		},
		 submitHandler:function(form){
		 	$.ajax({
            type: "post",
            url: "./admin/loginform.php?act=reg",     
            data: $("#register_form").serialize(),    
            success: function(data) {
            	 var jsonObj = eval("("+data+")");  //将json字符串转为json对象
            	
            	switch (jsonObj.type) {
            		case '0':
            		alert("该邮箱已注册");
            			break;
            					case '1':
            					form.submit();
            			
            			break;
            			
            				default:
            					// statements_def
            					break;
            			
            			
            	
            	}
             
            },
            error: function(data) {

            }
        });





		 }
	});
});
$(function() {
	$("#register_btn").click(function() {
		$("#register_form").css("display", "block");
		$("#login_form").css("display", "none");
	});
	$("#back_btn").click(function() {
		$("#register_form").css("display", "none");
		$("#login_form").css("display", "block");
	});
});