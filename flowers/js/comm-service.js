angular.module('sportsStoreAdmin-s', [])
.service("myHttp",function ($http,$q) {
    return{
        postTopicCollect: function (data,methon) {
            var deferred = $q.defer();
            var url = "http://";
            var url =url + methon +"?";

            for(var key in data){
                url+=key+"="+data[key]+"&";
            }
            var jsonpUrl = url+"callback=JSON_CALLBACK";
           
            alert(jsonpUrl)
            $http.jsonp(jsonpUrl
            ).success(function(data){
                alert(data);
                deferred.resolve(data);
                // location.href="mainHomepage.html";
//			$location.path("/main");
            }).error(function(error){
                alert('e');
                return deferred.promise(error);
            });

            return deferred.promise;
        }
    }
})