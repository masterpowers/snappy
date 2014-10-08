/**
 * modules/chats/factory.js
 */
;(function() {
  "use strict";

  angular.module('Chats')
    .factory('ChatFactory', function($http) {
      var vm = this, activeChat;

      vm.chats = [];

      vm.newChat = function() {
        return $http.post('api/v1/chats?include=messages,messages.author,recipients')
          .success(function(res) {
            vm.chats.push(res.data);
          })
          .error(function() {
            console.error('whoops');
          });
      };

      vm.postMessage = function(chat, message, type) {
        $http.post('api/v1/chats/' + chat.id + '/messages?include=author', { content: message, type: type });
      };

      vm.addContact = function(chat, contactId) {
        $http.post('api/v1/chats/' + chat.id + '/recipients', { recipient_id: contactId })
          .success(function(res) {
            chat.recipients.data.push(res.data);
          })
          .error(function() {
            console.error('Whoops');
          });
      };

      vm.openChat = function(chatId) {
        return $http.get('api/v1/chats/' + chatId + '?include=messages,messages.author,recipients')
          .success(function(res) {
            vm.activeChat = res.data;
          });
      };

      vm.getChats = function() {
        return $http.get('api/v1/chats?include=messages,messages.author,recipients')
          .success(function(data) {
            vm.chats = data.data;
          })
          .error(function() {
            console.error('Whoops');
          });
      };

      vm.deleteChat = function(chat) {
        $http.delete('api/v1/chats/' + chat.id)
          .success(function() {
            vm.messages.splice(chat, 1);
          })
          .error(function() {
            console.error('Whoops');
          });
      };

      return vm;
    });
}());