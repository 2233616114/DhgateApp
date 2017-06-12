angular.module('starter.controllers', [])

.controller('DashCtrl', function($scope) {})

.controller('ChatsCtrl', function($scope, Chats) {
  // With the new view caching in Ionic, Controllers are only called
  // when they are recreated or on app start, instead of every page change.
  // To listen for when this page is active (for example, to refresh data),
  // listen for the $ionicView.enter event:
  //
  //$scope.$on('$ionicView.enter', function(e) {
  //});

  $scope.chats = Chats.all();
  $scope.remove = function(chat) {
    Chats.remove(chat);
  };
})

.controller('ChatDetailCtrl', function($scope, $stateParams, Chats) {
  $scope.chat = Chats.get($stateParams.chatId);
})

.controller('AccountCtrl', function($scope) {
  $scope.settings = {
    enableFriends: true
  }
})
.controller("classFlowerInfoCtrl",function($scope,$http){
	$scope.back1=function(){
		window.history.back();
	}
	//模拟json显示在页面
	$http.get("data/flower.json")
	.success(function(data){
		$scope.datas=data;
	})
})
.controller("piciMessageCtrl",function($scope,$http){
	$scope.back1=function(){
		window.history.back();
	}
	$http.get("data/picimessage.json")
	.success(function(data){
		$scope.datas=data;
	})
})
.controller("statisticsCtrl",function($scope,$http){
	$scope.back1=function(){
		window.history.back();//返回上一个页面
	}
	/*用angularjs+ionic来判断*/
	$scope.dianji=function(type){
		$scope.type=type;
	}
	
	//第一种方法，把数据渲染在页面上
	$http.get("data/statics.json")
	.success(function(data){
		$scope.items=data;
	})
	$scope.gettext=function($index){
		var index=$index;
		console.log(index);
		var text=$("li").eq(index).text();
		$(".staticcon .statictext").html(text);
//	console.log(angular.element(document.querySelector('li:nth-child(index)')).text());
	}
})
.controller("comnpanyInfoCtrl",function($scope,$http){
	$scope.back1=function(){
		window.history.back();//返回上一个页面
	}
})
.controller("myClassCtrl",function($scope,$http){
	$scope.back1=function(){
		window.history.back();//返回上一个页面
	}
})
.controller("classDetailsCtrl",function($scope,$http){
	$scope.back1=function(){
		window.history.back();//返回上一个页面
	}
})
.controller("feedingRoomCtrl",function($scope,$http){
	$scope.back1=function(){
		window.history.back();//返回上一个页面
	}
	
	//选项卡效果
	$(".btns button").on("click",function(){
		var index=$(this).index();
		$(".allcontent .content").eq(index).css("display","block");
		$(".allcontent .content").eq(index).siblings().css("display","none");
	})
})
.controller("longweihaoCtrl",function($scope,$http){
	$scope.back1=function(){
		window.history.back();//返回上一个页面
	}
})
.controller("longweihao2Ctrl",function($scope,$http,$ionicActionSheet){
	$scope.back1=function(){
		window.history.back();//返回上一个页面
	}
	
	//函数picture
	$scope.picture = function(){
	 		$ionicActionSheet.show({ 
	 				buttons: [ 
	 				{ text: '<center>拍照</center>' },
	 				{ text: '<center ng-click="tupianshangchuan()">从手机相册选择</center>' } 
	 				], 
	 				cancelText: '关闭',
	 				cancel: function() { 
	 					//return true; 
	 				}, 
	 				buttonClicked: function(index) { 
	 					switch (index){ 
	 					case 0: takePhoto(); 
	 								break; 
	 					case 1: takePhoto1(); 
	 								break; 
	 					default: break; 
	 					} 
	 					return true; 
	 				} 
	 		}); 
	 		var takePhoto1=function(){
	 			alert(1);
	 		}
 	}
	//进行图片上传
})
.controller("listCtrl",function($scope,$http){
	$scope.back1=function(){
		window.history.back();
	}
})

function clickselect(){
	var vals=document.getElementsByTagName("select")[0];
  var vals=this.value;
	console.log(vals);
	vals=vals.options[vals.selectedIndex].value;
	var lcx=document.getElementsByClassName("text")[0];
	if(vals=="单位"){
		lcx.setAttribute("placeholder","单位名称搜索");
		lcx.setAttribute("placeholder","品种名称搜索");
	}
}