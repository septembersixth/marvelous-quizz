(function() {

    var app = angular.module('quizz', []);


    app.controller('quizzController', ['$http', function($http){
        var quizz   = this;
        quizz.tests = [];

        $http.get('/json/tests').success(function(data){
            quizz.tests = data;
        });
    }]);

    app.directive('testPanel', function(){
        return {
            'restrict': 'E',
            'templateUrl': 'js/template/testTemplate.html'
        };
    });

})();