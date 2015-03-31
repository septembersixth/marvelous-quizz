(function() {
    'use strict';

    var app = angular.module('quizz', ['testFilters', 'testServices', 'testsInitService']);

    app.controller('quizzController', ['$http', 'validatorService', 'mappingService', 'testCollectorService', 'getTestsJsonService',
        function($http, validatorService, mappingService, testCollectorService, getTestsJsonService){

        var quizz = this;
        this.optionsMapping = [];
        this.validator = validatorService();
        this.collector = testCollectorService();

        this.state = 0;

        /*
        $http.get('/json/tests').success(function(data){
            quizz.collector.setTests(data);
            quizz.optionsMapping = mappingService(quizz.getCurrentTest());
            quizz.validator.setSolutions(quizz.getCurrentTest().solutions);
        });
        */

        this.collector.setTests(getTestsJsonService());
        this.optionsMapping = mappingService(this.collector.currentTest);
        this.validator.setSolutions(this.collector.currentTest.solutions);

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