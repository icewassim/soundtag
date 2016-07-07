
namespace app.components {
  "use strict";

  interface ITrackScope extends ng.IScope {
  playTrack(song: ITrack): void;
  addComment(song: ITrack): void;
}

export function track(): ng.IDirective {
  return {
    restrict: "E",
    templateUrl: "/components/track/track.html",
    scope: {
      track: "="
    },
    link: ($scope: ITrackScope) => {
      $scope.addComment = (song: ITrack) => {
        if (!song.comments)
          song.comments = [];

        song.comments.push({
          content: song.comment,
          authorName: "elwiss",
          authorPic: "/pics/icon.png",
          date: "2/2/2016"
        });
        song.comment = "";
      };

      $scope.playTrack = (song: ITrack) => {
        console.log("playing the song", song.title, song.artist);
      };
    }
  };
}

angular.module("app.components").directive("track", track);
}
