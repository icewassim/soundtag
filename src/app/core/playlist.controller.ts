
namespace  app.core {
  "use strict";

  export class PlaylistController {
    public tracks: Array<app.components.ITrack>;
    constructor(private playlistService: app.core.IPlaylistService) {
      this.playlistService.getTrackList().then((result: Array<app.components.ITrack>) => {
        this.tracks = result;
      });
    }
  }
  angular.module("app.core").controller("playlistController", PlaylistController);
}
