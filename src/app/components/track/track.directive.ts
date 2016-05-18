
namespace app.components {
  "use strict";

  interface ITrackScope extends ng.IScope {
      playTrack(song: ITrack): void;
  }

  export function track(): ng.IDirective {
    return {
      restrict: "E",
      templateUrl: "/components/track/track.html",
      scope: {
        track: "="
      },
      link: ($scope: ITrackScope) => {
        $scope.playTrack = function(song: ITrack){
          console.log("playing the song", song.title, song.artist);
        };
      }
    };
  }

  angular.module("app.components").directive("track", track);
}
