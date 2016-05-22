namespace app.core {
  "use strict";

  export interface ISearchService {
    getSearchSuggestions: (searchItem: string) => ng.IPromise<any>;
  }

  export class SearchService implements ISearchService {
    static IID = "searchService";
    private serviceUrl: string;
    private searchResult: app.components.ITrack;
    static $inject: Array<string> = ["$http"];

    constructor(private $http: ng.IHttpService, url: string) {
      // this.serviceUrl = url || "http://ws.audioscrobbler.com/2.0/?method=track.search&api_key=543fc405ef684b058fa4808ce33ee018&format=json&limit=5&";
        this.serviceUrl = "/mocks/searchTermMock.json?";
    };

    getSearchSuggestions: (searchItem: string) => ng.IPromise<any> = (searchItem: string) => {
      return this.$http.get(this.serviceUrl + "track=" + searchItem)
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
