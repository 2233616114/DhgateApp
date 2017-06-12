// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['ionic','ngCordova', 'starter.controllers', 'starter.services','sportsStoreAdmin'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      cordova.plugins.Keyboard.disableScroll(true);

    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider) {

  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider

  // setup an abstract state for the tabs directive
  // 
  // 
   .state('login',{
    url:'/login',
    // abstract:true,
    templateUrl:'templates/login.html',
    controller:"authCtrl"
   })
  // 
  // 登录的主页
  .state('main',{
  	url:'/main',
  	templateUrl:'templates/main.html',
  	controller:'DashCtrl'
  })
  .state('classApplicant',{//课题申请人
  	url:'/classApplicant',
  	templateUrl:'templates/classApplicant.html',
  	controller:'DashCtrl'
  })
  .state('useCfeeder',{//使用单位管理员
  	url:'/useCfeeder',
  	templateUrl:'templates/UseCfeeder.html',
  	controller:'DashCtrl'
  })
  .state('UseCMan',{//使用单位饲养员
  	url:'/UseCMan',
  	templateUrl:'templates/UseCMan.html',
  	controller:'DashCtrl'
  })
  //main页面的路由跳转
  .state('classFlowerInfo',{
  	url:'/classFlowerInfo',
  	templateUrl:'templates/classFlowerInfo.html',
	  controller:'classFlowerInfoCtrl'
  })
  .state('details',{
  	url:'/details',
  	templateUrl:'templates/details.html',
  	controller:'detailsCtrl'
  })
  .state('statistics',{
  	url:'/statistics',
  	templateUrl:'templates/statistics.html',
  	controller:'statisticsCtrl'
  })
  .state('companyInfo',{
  	url:'/companyInfo',
  	templateUrl:'templates/companyInfo.html',
  	controller:'comnpanyInfoCtrl'
  })
  /*新增加的方法*/
  //main下面页面的路由跳转至批次处理页面
  .state('piciMessage',{
  	url:'/piciMessage',
  	templateUrl:'templates/piciMessage.html',
	  controller:'piciMessageCtrl'
  })
  //点击classApplicant页面
  .state('myClass',{
  	url:'/myClass',
  	templateUrl:'templates/myClass.html',
	  controller:'myClassCtrl'
  })
  .state('classDetails',{
  	url:'/classDetails',
  	templateUrl:'templates/classDetails.html',
	  controller:'classDetailsCtrl'
  })
  //UseCfeeder页面的跳转
  .state('feedingRoom',{
  	url:'/feedingRoom',
  	templateUrl:'templates/feedingRoom.html',
	  controller:'feedingRoomCtrl'
  })
  .state('longweihao',{
  	url:'/longweihao',
  	templateUrl:'templates/longweihao.html',
	  controller:'longweihaoCtrl'
  })
  .state('longweihao2',{
  	url:'/longweihao2',
  	templateUrl:'templates/longweihao2.html',
	  controller:'longweihao2Ctrl'
  })
  .state('list',{
  	url:'/list',
  	templateUrl:'templates/list.html',
	  controller:'listCtrl'
  })
  
  
  .state('tab', {
    url: '/tab',
    abstract: true,
    templateUrl: 'templates/tabs.html'
  })

  // Each tab has its own nav history stack:

  .state('tab.dash', {
    url: '/dash',
    views: {
      'tab-dash': {
        templateUrl: 'templates/tab-dash.html',
        controller: 'DashCtrl'
      }
    }
  })

  .state('tab.chats', {
      url: '/chats',
      views: {
        'tab-chats': {
          templateUrl: 'templates/tab-chats.html',
          controller: 'ChatsCtrl'
        }
      }
    })
    .state('tab.chat-detail', {
      url: '/chats/:chatId',
      views: {
        'tab-chats': {
          templateUrl: 'templates/chat-detail.html',
          controller: 'ChatDetailCtrl'
        }
      }
    })

  .state('tab.account', { 
    url: '/account',
    views: {
      'tab-account': {
        templateUrl: 'templates/tab-account.html',
        controller: 'AccountCtrl'
      }
    }
  });

  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/login');

});
