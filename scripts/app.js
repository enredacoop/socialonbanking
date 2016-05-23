'use strict';

angular.module('sobApp', [
  'ngCookies',
  'ngResource',
  'ngSanitize'
])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/organizations/', {
        templateUrl: 'views/organizations.html',
        // controller: 'OrgsCtrl'
      })
      .when('/organizations/:id', {
        templateUrl: 'views/organization.html',
        controller: 'OrgCtrl'
      })
      .when('/charts', {
        templateUrl: 'views/charts.html',
        // controller: 'StatsCtrl'
      })
      .when('/dictionary', {
        templateUrl: 'views/dictionary.html',
        // controller: 'DictCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
