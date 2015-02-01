//Setup Angular
var gallery = angular.module('gallery', ['ngRoute', 'ui.bootstrap', "angularFileUpload"]);

gallery.config(function ($routeProvider) {
  $routeProvider
    .when('/', {
      templateUrl: 'templates/start.html'
    })
    .when('/images', {
      templateUrl: 'templates/images.html',
    })
    .when('/images_new', {
      templateUrl: 'templates/images_new.html',
    })
    .when('/error', {
      templateUrl: 'templates/error.html',
    })
    ;
});


gallery.controller('ImagesController', function ($scope, $http, $upload, $location, AuthService) {
  $scope.auth = AuthService;
  $scope.updateSlides = function() {
    $http.get('api.php/images').then(function(response) {
      $scope.images = response.data.images;
    });
  };
  $scope.updateSlides();

  $scope.deleteImage = function(image) {
    $http.delete('api.php/images/' + image).then(function() {
      $scope.updateSlides();
    });
  };
});

gallery.controller('AddImageController', function($scope, $upload, $location, $route) {
  $scope.upload = function(file) {
    $upload.upload({
      url: "api.php/images",
      data: {tags: $scope.tags},
      file: $scope.file
    }).success(function() {
      $location.path('/images');
      $route.reload();
    }).error(function() {
      $location.path('/error');
    });
  };
  $scope.tags = [];
  $scope.push = function(input) {
    $scope.tags.push(input);
    $scope.input= "";
  };
});

gallery.controller('LoginController', function($scope, AuthService) {
  $scope.auth = AuthService;
  $scope.logInOut = {};
  $scope.logout = function () {
    $scope.logInOut.Username = "";
    $scope.logInOut.Password = "";
    AuthService.logout();
  };
});

gallery.service('AuthService', function ($http) {
  var AuthService = {
    loggedIn: false
  };
  AuthService.login = function(Username, Password) {
    return $http.post('api.php/auth', {
      Username: Username,
      Password: Password
    }).then(function(response) {
      AuthService.loggedIn = true;
      AuthService.Username = response.data.Username;
    }, function() {
      AuthService.loggedIn = false;
      AuthService.Username = undefined;
    });
  };
  AuthService.logout = function() {
    return $http.post('api.php/auth', {
      Logout: "Logout"
    }).then(function() {
      AuthService.loggedIn = false;
      AuthService.Username = undefined;
    });
  };
  AuthService.login();
  return AuthService;
});
