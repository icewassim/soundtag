namespace app.components {
  "use strict";

  export interface IPlayerScope extends ng.IScope {
      isPlaying: boolean;
      currenPosition: number;
      start(song: ITrack): void;
      stop(): void;
  }

  export function giraffePlayer(): ng.IDirective {
    return {
      restrict: "E",
      templateUrl: "/components/giraffePlayer/giraffePlayer.html",
      link: ($scope: IPlayerScope) => {
          $scope.start = function(song: app.components.ITrack){
            $scope.isPlaying = true;
          };
          $scope.stop = function() {
            $scope.isPlaying = false;
          };
      }
    };
  }

  angular.module("app.components").directive("giraffePlayer", giraffePlayer);
}
