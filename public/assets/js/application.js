/**
 * application.js
 */
;(function() {
  "use strict";

  window.pusher = new Pusher('dac165bd3bc889882eeb');

  angular.module('SnappyChat', [
    'ui.router',
    'Auth',
    'Contacts',
    'Chats'
  ]).config(function($httpProvider, $stateProvider, $urlRouterProvider) {
    var authenticationInterceptor = function($location, $q, SessionService) {
      var success = function(response) {
        return response;
      };

      var error = function(response) {
        if (response.status === 401) {
          SessionService.unset('authenticated');
          SessionService.unset('user');
          $location.path('/login');
        }

        return $q.reject(response);
      };

      return function(promise) {
        return promise.then(success, error);
      };
    };

    $httpProvider.responseInterceptors.push(authenticationInterceptor);
    $httpProvider.defaults.headers.common.Accept = 'application/json';

    $urlRouterProvider.otherwise('/chats');

    $stateProvider
      .state('login', {
        url: '/login',
        templateUrl: '/assets/html/login.html',
        controller: 'LoginController'
      })
      .state('logout', {
        url: '/logout',
        template: '<ui-view />',
        controller: function(AuthenticationService) {
          AuthenticationService.logout();
        }
      })
      .state('register', {
        url: '/register',
        templateUrl: '/assets/html/register.html',
        controller: 'RegisterController'
      })
      .state('chats', {
        url: '/chats',
        templateUrl: '/assets/html/chats.html',
        controller: 'ChatsController'
      })
      .state('new-chat', {
        url: '/new-chat',
        templateUrl: '/assets/html/chat.html',
        controller: 'ChatController',
        resolve: {
          chat: function($q, ChatFactory) {
            var deferred = $q.defer();

            ChatFactory.newChat().success(function(res) {
              deferred.resolve(res.data);
            });

            return deferred.resolve;
          }
        }
      })
      .state('chats.show', {
        url: '/:chatId',
        templateUrl: '/assets/html/chat.html',
        controller: 'ChatController',
        resolve: {
          chat: function($stateParams, $q, ChatFactory) {
            var deferred = $q.defer();

            ChatFactory.openChat($stateParams.chatId)
              .then(function(data) {
                deferred.resolve(data.data.data);
              });

            return deferred.promise;
          }
        }
      });
    })
    .controller('ApplicationController', function($rootScope) {
      $rootScope.newChat = function() {
        ChatFactory.newChat();
      };
    });
}());