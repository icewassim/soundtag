namespace app.core {
  "use strict";

  export interface IPlaylistService {
    getSongs: () => ng.IPromise<any>;
  }

  export class PlaylistService implements IPlaylistService {
    static IID = "playlistService";
    static $inject: Array<string> = ["$http"];

    constructor(private $http: ng.IHttpService) {
    };

    getSongs: () => ng.IPromise<any> = () => {
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
