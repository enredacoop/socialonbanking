'use strict';

angular.module('sobApp')
  .controller('OrgCtrl', ['$scope', '$routeParams', function ($scope, $routeParams) {
    // $scope.awesomeThings = [
    //   'HTML5 Boilerplate',
    //   'AngularJS',
    //   'Karma'
    // ];
    $scope.id = $routeParams.id;
  }]);
