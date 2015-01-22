angular.module('gallery', ['ngAnimate'])
    .controller('MainController', function ($scope) {
      $scope.slides = [
      {image: 'Images/IMG_0805.JPG', text: 'Image 05'},
      {image: 'Images/IMG_0806.JPG', text: 'Image 06'},
      {image: 'Images/IMG_0808.JPG', text: 'Image 08'},
      {image: 'Images/IMG_0809.JPG', text: 'Image 09'},
      {image: 'Images/IMG_0810.JPG', text: 'Image 10'},
      {image: 'Images/IMG_0811.JPG', text: 'Image 11'}
      ];

      $scope.currentIndex = 0;

      $scope.setCurrentSlideIndex = function (index) {
          $scope.currentIndex = index;
      };

      $scope.isCurrentSlideIndex = function (index) {
          return $scope.currentIndex === index;
      };

      $scope.previousSlide = function () {
          $scope.currentIndex = ($scope.currentIndex < $scope.slides.length - 1) ? (++ $scope.currentIndex) : 0;
      };

      $scope.nextSlide = function () {
          $scope.currentIndex = ($scope.currentIndex > 0) ? (-- $scope.currentIndex) : ($scope.slides.length - 1);
      };

    });
