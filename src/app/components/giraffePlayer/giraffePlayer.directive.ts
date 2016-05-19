namespace app.components {
  "use strict";

  interface IPlayerScope extends ng.IScope {
      isPlaying: boolean;
      currenPosition: number;
      start(song: ITrack): void;
      stop(): void;
  }

  export function giraffePlayer(): ng.IDirective {
    return {
      restrict: "E",
      templateUrl: "/components/giraffePlayer/giraffePlayer.html",
      scope: {
        track: "="
      },
      link: ($scope: IPlayerScope) => {
        $scope.start = function(song: ITrack){
          $scope.isPlaying = true;
          console.log("playing the song", song.title, song.artist);
        };
        $scope.stop = function() {
          $scope.isPlaying = false;
        };
      }
    };
  }

  angular.module("app.components").directive("giraffePlayer", giraffePlayer);
}
