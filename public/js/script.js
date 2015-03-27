(function() {
    'use strict';

    var app = angular.module('quizz', ['testFilters', 'testServices']);

    app.controller('quizzController', ['$http', 'validatorService', 'mappingService', 'testCollectorService',
        function($http, validatorService, mappingService, testCollectorService){

        var quizz = this;
        this.tests = [];
        this.optionsMapping = [];
        this.validator = validatorService();
        this.collector = testCollectorService();

        this.state = 0;

        $http.get('/json/tests').success(function(data){
            quizz.collector.setTests(data);
            quizz.optionsMapping = mappingService(quizz.getCurrentTest());
            quizz.validator.setSolutions(quizz.getCurrentTest().solutions);
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

        this.getCurrentTest = function() {
            return this.collector.currentTest;
        };

        this.updateMapping = function() {
            this.optionMapping = mappingService(this.getCurrentTest());
        };

        this.nextTest = function() {
            if (this.state === 0) {
                this.state++;
            } else {
                if (this.collector.next(this.validator.valid)) {
                    this.validator.setSolutions(this.getCurrentTest().solutions);
                    this.updateMapping();
                    this.state = 0;
                }
            }
        };

    }]);

})();