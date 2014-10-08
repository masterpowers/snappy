/**
 * modules/contacts/factory.js
 */
;(function() {
  "use strict";

  angular.module('Contacts')
    .factory('ContactFactory', function ContactFactory($http) {
      var vm = this;

      vm.contacts = [];

      vm.getContact = function(contactId) {
        for (var i = 0; i < vm.contacts.length; i++) {
          if (vm.contacts[i].id === contactId) {
            return vm.contacts[i];
          }
        }
      };

      vm.getContacts = function() {
        return $http.get('api/v1/users')
          .success(function(data) {
            vm.contacts = data.data;
          })
          .error(function() {
            console.error('Whoops');
          });
      };

      return vm;
    });
}());