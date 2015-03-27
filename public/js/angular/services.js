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
    ;

})();