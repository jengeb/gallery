//Setup Angular
var gallery = angular.module('gallery', ['ngRoute', 'ui.bootstrap']);

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
