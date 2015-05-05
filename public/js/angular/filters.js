(function() {
    'use strict';

    angular.module('testFilters', [])

        .filter('next', function () {
            return function (input) {
                return (input === 0) ? 'valider ' : 'suivant ';
            }
        })

        .filter('validation', function () {
            return function (input) {
                return input ? 'Bravo !' : 'Mauvaise réponse';
            };
        })

        .filter('optionsMappingFilter', function () {
            return function (solutions, optionsMapping) {
                var result = [];
                for (var solution in solutions) {
                    result.push(optionsMapping[solutions[solution]]);
                }
                return result.join(', ');
            };
        })
    ;
})();