/**
 * modules/auth/controller.js
 */
;(function() {
  "use strict";

  angular.module('Auth')
    .controller('LoginController', function($scope, $state, AuthenticationService, SessionService) {
      $scope.credentials = { email_address: '', password: '' };

      $scope.login = function() {
        AuthenticationService.login($scope.credentials).success(function(res) {
          SessionService.set('user', res.data);
          $state.go('chats');
        });
      };
    })
    .controller('RegisterController', function($scope, $state, AuthenticationService, SessionService) {
      $scope.user = { email_address: '', password: '', name: '' };

      $scope.register = function() {
        AuthenticationService.register($scope.user).success(function(res) {
          $state.go('login');
        });
      };
    });
}());