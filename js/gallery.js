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


gallery.controller('ImagesController', function ($scope, $http) {
  $scope.updateSlides = function() {
    $http.get('api.php/images').then(function(response) {
      $scope.slides = response.data.images;
    });
  };
  $scope.updateSlides();

  $scope.deleteImage = function(image) {
    $http.delete('api.php/images/' + image).then(function() {
      $scope.updateSlides();
    });
  };
});

gallery.controller('AddImageController', function($scope, $upload, $location) {
  $scope.upload = function() {
    $upload.upload({
      url: "api.php/images",
      file: $scope.file
    }).success(function() {
      $location.path('/images');
    }).error(function() {
      $location.path('/error');
    });
  };
});

gallery.controller('LoginController', function($scope, $http) {
  $scope.auth = false;
  $scope.login = function(Username, Password) {
    $http.post('api.php/auth', {
      Username: $scope.Username,
      Password: $scope.Password
    }).then(function() {
      $scope.auth = true;
    }, function() {
      $scope.auth = false;
    });
  };

  $scope.logout = function() {
    $http.post('api.php/auth', {
      Logout: "Logout"
    }).then(function() {
      $scope.Username = "";
      $scope.Password = "";
      $scope.auth = false;
    });
  };

});
