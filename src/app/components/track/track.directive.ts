namespace app.components {
    "use strict";

    interface ITrackScope extends ng.IScope {
        addComment(song: ITrack): void;
        playTrack(song: ITrack): void;
    }

    export function track(playlistService: app.core.IPlaylistService): ng.IDirective {
        return {
            restrict: "E",
            templateUrl: "/components/track/track.html",
            scope: {
                track: "="
            },
            link: ($scope: ITrackScope, elm, attr) => {
                $scope.addComment = (song: ITrack) => {
                    if (!song.comments) {
                        song.comments = [];
                    }
                    song.comments.push({
                        content: song.comment,
                        authorName: "elwiss",
                        authorPic: "/pics/icon.png",
                        date: "2/2/2016"
                    });
                    song.comment = "";
                };

                $scope.playTrack = (song: ITrack) => {
                    playlistService.setCurrentTrack(song);
                };
            }
        };
    }

    angular.module("app.components").directive("track", track);
}
