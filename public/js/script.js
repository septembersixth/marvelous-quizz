(function() {
    'use strict';

    var app = angular.module('quizz', ['testFilters']);

    app.controller('quizzController', ['$http', function($http){
        var quizz = this;
        this.tests = [];
        this.currentTest = {};
        this.currentTestIndex = 0;
        this.answers = [];
        this.valid = false;
        this.optionsMapping = [];

        this.state = 0;

        $http.get('/json/tests').success(function(data){
            quizz.tests = data;
            quizz.currentTest = quizz.tests[0];
            quizz.initMapping(quizz.currentTest);
        });

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

        this.isCorrectOption = function(optionId) {
            return (this.currentTest.solutions.indexOf(optionId) != -1);
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
            if (this.state === 1) {
                this.state = 0;
                this.currentTest = this.tests[++this.currentTestIndex];
                this.valid = false;
                this.answers = [];
                this.initMapping(this.currentTest);
            } else {
                this.state = 1;
            }
        };

        this.map = function(optionId) {
            return 'A';
        };

    }]);

    /*
    app.filter('next', function(){
       return function(input){
           return (input === 0) ? 'Valider ' : 'Question suivante ';
       }
    });


    app.filter('validation', function(){
        return function(input){
            return input ? 'Bravo !' : 'Mauvaise réponse';
        };
    });


    app.filter('optionsMappingFilter', function(){
        return function(solutions, optionsMapping) {
            var result = [];
            for(solution in solutions) {
                result.push(optionsMapping[solutions[solution]]);
            }
            return result.join(', ');
        };
    });
     */

})();