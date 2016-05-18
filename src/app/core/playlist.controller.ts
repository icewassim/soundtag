
namespace  app.core {
  "use strict";

  interface ITrack {
    title: string;
    artist: string;
    prevLyrics: string;
    soundCloudId?: string;
    albumThumbnail?: string;
    soundCloudPermalink?: string;
  }


  export class PlaylistController {
    public tracks: Array<ITrack>;
    constructor(private playlistService: app.core.IPlaylistService) {
      this.playlistService.getSongs().then((result: Array<ITrack>) => {
        this.tracks = result;
      });
    }
  }
  angular.module("app.core").controller("playlistController", PlaylistController);
}
