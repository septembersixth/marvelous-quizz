(function(){
    'use strict';

    angular.module('testServices', [])

        .factory('validatorService', function(){
            var validator = {
                solutions: [],
                answers: [],
                valid: false,

                setSolutions: function(solutions) {
                    this.solutions = solutions;
                    this.setAnswers([]);
                    this.verifyValidation();
                },

                setAnswers: function(answers) {
                    this.answers = answers;
                    this.verifyValidation();
                },
                addAnswer: function(answer) {
                    var index = this.answers.indexOf(answer);
                    if (index !== -1) {
                        this.answers.splice(index, 1);
                    } else {
                        this.answers.push(answer);
                    }
                    this.verifyValidation();
                },

                verifyValidation: function() {
                    this.valid = false;

                    if (this.solutions.length !== this.answers.length) {
                        this.valid = false;
                        return false;
                    }

                    var intersection = 0;
                    for(var answer in this.answers) {
                        if (this.solutions.indexOf(this.answers[answer]) !== -1) {
                            intersection++;
                        }
                    }
                    if (intersection === this.solutions.length) {
                        this.valid = true;
                        return this.valid;
                    }

                    return this.valid;
                }
            };

            return function() {
                return validator;
            };
        })

        .factory('mappingService', function(){
            var optionsMapping = [];

            return function(test) {
                var char = 'A';
                for(var question in test.questions) {
                    for(var option in test.questions[question].options) {
                        optionsMapping[test.questions[question].options[option].id] = char;
                        char = String.fromCharCode(char.charCodeAt() + 1);
                    }
                }
                return optionsMapping;
            };
        })

        .factory('testCollectorService', function(){
            var collector   = {
                tests       : [],
                currentTest : {},
                count       : 0,
                correct     : 0,
                wrong       : 0,

                setTests             : function(tests) {
                    this.tests       = tests;
                    this.count       = 0;
                    this.correct     = 0;
                    this.wrong       = 0;
                    this.currentTest = this.tests[this.count];
                },

                saveOneCorrect : function() {
                    this.correct++;
                },

                saveOneWrong : function() {
                    this.wrong++;
                },

                addCount : function(isValid) {
                    this.count++;
                    if (isValid) {
                        this.saveOneCorrect();
                    }else {
                        this.saveOneWrong();
                    }
                },

                next : function(){
                    if (this.tests.length <= this.count) {
                        window.location.href = window.location.origin + '/result/' + this.correct + '/' + this.wrong;
                        return;
                    } else {
                        this.currentTest = this.tests[this.count];
                    }

                    return true;
                }
            };

            return function(tests) {
                collector.tests = tests;
                return collector;
            };

        })
    ;

})();