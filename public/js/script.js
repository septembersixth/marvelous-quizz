(function() {
    'use strict';

    var app = angular.module('quizz', ['testFilters', 'testServices']);

    app.controller('quizzController', ['$http', 'validatorService', function($http, validatorService){
        var quizz = this;
        this.tests = [];
        this.currentTest = {};
        this.currentTestIndex = 0;
        this.optionsMapping = [];

        this.validator = validatorService();

        this.state = 0;

        $http.get('/json/tests').success(function(data){
            quizz.tests = data;
            quizz.currentTest = quizz.tests[0];
            quizz.initMapping(quizz.currentTest);

            quizz.validator.setSolutions(data[0].solutions);
        });

        this.isActiveOption = function(optionId) {
            return this.validator.answers.indexOf(optionId) != -1 ;
        };

        this.isCorrectOption = function(optionId) {
            return (this.validator.solutions.indexOf(optionId) != -1);
        };

        this.addAnswer = function(optionId) {
            return (this.validator.addAnswer(optionId));
        };

        this.nextTest = function() {
            if (this.currentTestIndex + 1 == this.tests.length) {
                return;
            }
            if (this.state === 1) {
                this.state = 0;
                this.currentTest = this.tests[++this.currentTestIndex];
                this.validator.setSolutions(this.tests[this.currentTestIndex]);
                this.initMapping(this.currentTest);
            }else {
                this.state = 1;
            }
        };




        this.initMapping = function(test){
            var char = 'A';

            quizz.optionsMapping = [];
            for(var question in test.questions) {
                for(var option in test.questions[question].options) {
                    quizz.optionsMapping[test.questions[question].options[option].id] = char;
                    char = String.fromCharCode(char.charCodeAt() + 1);
                }
            }
        };


        this.map = function(optionId) {
            return 'A';
        };

    }]);

})();