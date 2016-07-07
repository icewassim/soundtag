namespace app.core {
  "use strict";

  export interface ISearchService {
    getSearchSuggestions: (searchItem: string) => ng.IPromise<any>;
    getTrackLyrics: (track: app.components.ITrack) => ng.IPromise<any>;
    getSoundCloudID: (track: app.components.ITrack) => ng.IPromise<any>;
  }

  export class SearchService implements ISearchService {
    static IID = "searchService";
    static $inject: Array<string> = ["$http"];
    private searchSuggestionUrl: string;
    private searchLyricsUrl: string;
    private searchSoundCloudUrl: string;

    constructor(private $http: ng.IHttpService,
                        searchSuggestionUrl: string,
                        searchLyricsUrl: string,
                        searchSoundCloudUrl: string
                      ) {
        this.searchSuggestionUrl = searchSuggestionUrl || "http://ws.audioscrobbler.com/2.0/?method=track.search&api_key=543fc405ef684b058fa4808ce33ee018&format=json&limit=5&";
        this.searchLyricsUrl = searchLyricsUrl || "http://soundtag.me/soundtrack/getlyricsxmatch?";
        this.searchSoundCloudUrl = searchSoundCloudUrl || "http://api.soundcloud.com/tracks.json";
        // this.searchSuggestionUrl = "/mocks/searchTermMock.json?";
    };

    getSearchSuggestions: (searchItem: string) => ng.IPromise<any> = (searchItem: string) => {
      return this.$http.get(this.searchSuggestionUrl + "track=" + searchItem.trim())
                        .then((response: any) => {
                          return response.data;
                        })
                        .catch((error) => {
                          console.error("$http.get Failed with error", error);
                        });
    };

    getSoundCloudID: (track: app.components.ITrack) => ng.IPromise<any> = (track: app.components.ITrack) => {
      if (!track)
        return null;

      return this.$http.get(this.searchSoundCloudUrl + "q=" + track.title + " " + track.artist +
                                                    "&artist=" + track.artist +
                                                    "&limit=10" )
                        .then((response: any) => {
                          return response.data;
                        })
                        .catch((error) => {
                          console.error("$http.get Failed with error", error);
                        });
    };

    getTrackLyrics: (track: app.components.ITrack) => ng.IPromise<any> = (track: app.components.ITrack) => {
      if (!track)
        return null;

      return this.$http.get(this.searchLyricsUrl + "track=" + track.title + "&artist=" + track.artist)
                        .then((response: any) => {
                          return response.data;
                        })
                        .catch((error) => {
                          console.error("$http.get Failed with error", error);
                        });
    };
  }

  angular.module("app.core").service(SearchService.IID, SearchService);
}
