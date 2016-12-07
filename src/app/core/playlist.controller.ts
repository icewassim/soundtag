
namespace  app.core {
  "use strict";

  export class PlaylistController {
        private tracks: Array<app.components.ITrack>;
        private currentTrack: app.components.ITrack;

        constructor(private playlistService: app.core.IPlaylistService, $scope: app.components.IPlayerScope, $rootScope: ng.IRootScopeService) {

        let unbindAdded,
            unbindPlaying;

        unbindPlaying = $rootScope.$on("playing", function(evt, track){
            console.log(this.currentTrack);
            this.currentTrack = track;
        }.bind(this));

        this.playlistService.getTrackList()
            .then((result: Array<app.components.ITrack>) => {
                this.tracks = result;
            });

        unbindAdded = $rootScope.$on("newTrackAdded", function(evt, data){
            this.tracks.push(data);
        }.bind(this));
    }
  }
  angular.module("app.core").controller("playlistController", PlaylistController);
}
