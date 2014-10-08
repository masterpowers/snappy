/**
 * modules/contacts/controller.js
 */
;(function() {
  "use strict";

  angular.module('Contacts')
    .controller('ContactsController', function($scope, $http) {
      $http.get('api/v1/users')
        .then(function(res) {
          $scope.contacts = res.data.data;
        });

      $scope.talk = function() {

      };
    });
}());