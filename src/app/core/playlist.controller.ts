
namespace  app.core {
  "use strict";

  export class PlaylistController {
    private tracks: Array<app.components.ITrack>;
    constructor(private playlistService: app.core.IPlaylistService, $rootScope: ng.IRootScopeService) {
      this.playlistService.getTrackList().then((result: Array<app.components.ITrack>) => {
        this.tracks = result;
      });
      let unbind = $rootScope.$on("newTrackAdded", function(evt, data){
          this.tracks.push(data);
      }.bind(this));
    }
  }
  angular.module("app.core").controller("playlistController", PlaylistController);
}
