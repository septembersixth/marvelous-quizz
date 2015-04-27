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
            if (this.state === 0) {
                return (this.validator.addAnswer(optionId));
            }
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
                this.collector.addCount(this.validator.valid);
            } else {
                if (! this.collector.next()) {
                    window.location.href = window.location.origin + '/result/' + this.collector.correct + '/' + this.collector.wrong;
                }
                this.validator.setSolutions(this.getCurrentTest().solutions);
                this.updateMapping();
                this.state = 0;
            }
        };

    }]);

})();