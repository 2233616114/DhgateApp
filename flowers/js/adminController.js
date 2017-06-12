angular.module("sportsStoreAdmin",[])
.controller("authCtrl",function($scope,$http,$state,$location){
	//点击验证登录
	$scope.authenticate=function(user,pass){
		var url="data/login2.json";
		$http.get(url)
		.success(function(data){
			
			/*//获取登录信息
			var username=data.login.username;
			var password=data.login.password;
			var state=data.unlogin.state;//获取非登录状态
			var unlogin=state=data.login.state;
			if(user==username && pass==password){
				$location.path('/main');//angularjs进行路由
                //$state.go("/main");
				$scope.state=state;
			}else if(user==1234 && pass==1234){
				$location.path('/classApplicant');
			}else if(user==12345 && pass==12345){
				$location.path('/useCfeeder');
			}else if(user==123456 && pass==123456){
				$location.path('/UseCMan');
			}else{
				alert("用户名或密码有误!");
				$scope.state=unlogin;
			}*/
			for(var i=0;i<data.login.length;i++){
				var username1=data.login[i].username; 
				var password1=data.login[i].password;
				if(user==username1 && pass==password1){
					$location.path(data.login[i].url);
				}
			}
			
		})
		.error(function(data){
			$scope.authenticationError=error;
		})
	}
})
