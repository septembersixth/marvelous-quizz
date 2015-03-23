(function() {

    var app = angular.module('quizz', []);

    app.controller('quizzController', ['$http', function($http){
        var quizz = this;
        this.tests = [];
        this.currentTest = {};
        this.currentTestIndex = 0;
        this.answers = [];
        this.valid = false;

        this.state = 0;

        $http.get('/json/tests').success(function(data){
            quizz.tests = data;
            quizz.currentTest = quizz.tests[0];

        });

        this.setAnswer = function(optionId) {
            var index = this.answers.indexOf(optionId);
            if (index !== -1) {
                this.answers.splice(index, 1);
            } else {
                this.answers.push(optionId);
            }
            this.isTestValid();
        };

        this.isActiveOption = function(optionId) {
            return this.answers.indexOf(optionId) != -1 ;
        };

        this.isTestValid = function() {
            this.valid = false;

            if (this.currentTest.solutions.length !== this.answers.length) {
                this.valid = false;
                return false;
            }

            var count = 0;
            for(var answer in this.answers) {
                if (this.currentTest.solutions.indexOf(this.answers[answer]) !== -1) {
                    count++;
                }
            }
            if (count === this.currentTest.solutions.length) {
                this.valid = true;
                return this.valid;
            }

            return this.valid;
        };

        this.nextTest = function() {
            if (this.currentTestIndex + 1 == this.tests.length) {
                return;
            }
            this.currentTest = this.tests[++this.currentTestIndex];
            this.valid = false;
            this.answers = [];
        };

    }]);

    app.directive('testPanel', function(){
        return {
            restrict: 'E',
            templateUrl: 'js/template/testTemplate.html',
            controllerAs: 'quizz',
            controller: function() {
                this.tutu = 'tutututiioo ok';
            }
        };
    });

})();