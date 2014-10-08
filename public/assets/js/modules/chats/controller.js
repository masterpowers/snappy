/**
 * modules/chats/controller.js
 */
;(function() {
  "use strict";

  angular.module('Chats')
    .controller('ChatsController', function($rootScope, $scope, $state, $http, ContactFactory, ChatFactory) {
      $scope.chats    = ChatFactory.chats;
      $scope.contacts = ContactFactory.contacts;

      $http.get('api/v1/users/me')
        .success(function(res) {
          $rootScope.user = res.data;
        });

      $scope.newChat = function() {
        ChatFactory.newChat().success(function(res) {
          $state.go('chats.show', { chatId: res.data.id });
        });
      };

      ChatFactory.getChats().then(function() {
        $scope.chats = ChatFactory.chats;
      });

      ContactFactory.getContacts().then(function() {
        $scope.contacts = ContactFactory.contacts;
      });
    })

    .controller('ChatController', function($rootScope, $scope, ChatFactory, chat) {
      $scope.chat    = chat;
      $scope.message = '';
      $scope.cameraEnabled = false;

      var channel = pusher.subscribe('chat');

      channel.bind('new_message', function(data) {
        console.log(data);
        $scope.$apply(function() {
          $scope.chat.messages.data.push(JSON.parse(data).data);
          document.getElementById('messages-bottom').scrollIntoView();
        });
      });

      $scope.$watchCollection('chat', function(newVal) {
        console.log('changed');
      });

      $scope.postMessage = function(message, type) {
        ChatFactory.postMessage($scope.chat, message, type);
        $scope.message = '';
        document.getElementById('messages-bottom').scrollIntoView();
      };

      function enableCamera(cb) {
        Webcam.set({
          // live preview size
          width: 350,
          height: 260,
          
          // device capture size
          dest_width: 640,
          dest_height: 480,
          
          // final cropped size
          crop_width: 200,
          crop_height: 200,
          
          // format and quality
          image_format: 'jpeg',
          jpeg_quality: 30
        });

        $scope.cameraEnabled = true;

        Webcam.attach('#camera-preview-content');
      }

      $scope.capture = function() {
        if ($scope.cameraEnabled === false) {
          enableCamera();
        } else {
          Webcam.snap(function(dataUri) {
            // document.getElementsByClassName('webcam-preview')[0].innerHTML = '<img src="'+dataUri+'">';
            // document.getElementsByClassName('modal')[0].classList.add('modal-open');

            $scope.postMessage(dataUri, 'image');
          });
        }
      };

      $scope.addContact = function(contact) {
        ChatFactory.addContact($scope.chat, contact);
      };
    });
}());