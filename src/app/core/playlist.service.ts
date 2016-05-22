namespace app.core {
  "use strict";

  export interface IPlaylistService {
    getTrackList: () => ng.IPromise<any>;
    addTrack: (track: app.components.ITrack) => void;
    getCurrentTrack: () => app.components.ITrack;
    setCurrentTrack: (track: app.components.ITrack) => void;
  }

  export class PlaylistService implements IPlaylistService {
    static IID = "playlistService";
    private currentTrack: app.components.ITrack;
    static $inject: Array<string> = ["$http"];

    constructor(private $http: ng.IHttpService) {
    };

    setCurrentTrack: (track: app.components.ITrack) => void = (track: app.components.ITrack) => {
      this.currentTrack = track;
    };

    getCurrentTrack: () => app.components.ITrack  = () => {
      return this.currentTrack;
    };

    addTrack: (track: app.components.ITrack) => void = (track: any) => {
      console.log("adding to track", track);
    }

    getTrackList: () => ng.IPromise<any> = () => {
      let playlistUrl = "/mocks/playlistMock.json";
      return this.$http.get(playlistUrl)
                        .then((response: any) => {
                          return response.data;
                        })
                        .catch((error) => {
                          console.error("$http.get Failed with error", error);
                        });
    };
  }

  angular.module("app.core").service(PlaylistService.IID, PlaylistService);
}
