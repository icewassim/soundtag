namespace app.components {
  "use strict";

  interface IPlayerScope extends ng.IScope {
      playTrack(song: ITrack): void;
  }

  export function giraffePlayer(): ng.IDirective {
    return {
      restrict: "E",
      templateUrl: "/components/giraffePlayer/giraffePlayer.html",
      scope: {
        track: "="
      },
      link: ($scope: IPlayerScope) => {
        $scope.playTrack = function(song: ITrack){
          console.log("playing the song", song.title, song.artist);
        };
      }
    };
  }

  angular.module("app.components").directive("giraffePlayer", giraffePlayer);
}
