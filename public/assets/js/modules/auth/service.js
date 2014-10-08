/**
 * modules/auth/service.js
 */
;(function() {
  "use strict";

  angular.module('Auth')
    .service('AuthenticationService', function($http, SessionService) {
      var cacheSession = function() {
        SessionService.set('authenticated', true);
      };

      var uncacheSession = function() {
        SessionService.unset('authenticated');
      };

      return {
        login: function(credentials) {
          var req = $http.post('api/v1/login', credentials);
          req.success(cacheSession);
          return req;
        },
        logout: function() {
          var req = $http.get('api/v1/logout');
          req.success(uncacheSession);
          return req;
        },
        register: function(user) {
          return $http.post('api/v1/register', user);
        },
        authenticated: function() {
          return SessionService.get('authenticated');
        }
      };
    });
}());