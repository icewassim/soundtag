
namespace  app.core {
  "use strict";

  interface ISong {
      title: string;
      artist: string;
      prevLyrics: string;
      soundCloudId?: string;
      albumThumbnail?: string;
      soundCloudPermalink?: string;
  }

  export class PlaylistController {
    public song: ISong;
    constructor(private playlistService: app.core.IPlaylistService) {
      this.playlistService.getSongs().then((result: Array<ISong>) => {
        this.song = result[0];
      });
    }
  }
  angular.module("app.core").controller("playlistController", PlaylistController);
}
