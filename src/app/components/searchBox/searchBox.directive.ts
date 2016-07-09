namespace app.components {
  "use strict";
  const SPACE_KEY = 32;
  const UP_KEY = 38;
  const DOWN_KEY = 40;
  const ENTER_KEY = 13;
  const PRESS_KEY_TIMEOUT = 1000;

  interface ISearchScope extends ng.IScope {
    searchTerm: string;
    focusIndex: number;
    resetKey: number;
    searchSuggestions: Array<app.components.ITrack>;
    selectSuggestion: (suggestion: app.components.ITrack) => void;
    triggerSelectInput: () => void;
  }

  export function searchBox(searchService: app.core.ISearchService,
                            playlistService: app.core.IPlaylistService): ng.IDirective {
    return {
      restrict: "E",
      templateUrl: "/components/searchBox/searchBox.html",
      scope: {
        track: "="
      },
      link: ($scope: ISearchScope, element: JQuery) => {
        $scope.focusIndex = 0;
        let focusDown = () => {
          if ($scope.focusIndex > 4)
            $scope.focusIndex = 1;
          else
            $scope.focusIndex = $scope.focusIndex + 1;

          refreshDisplay();
        };
        let focusUp = () => {
          if ($scope.focusIndex < 2)
            $scope.focusIndex = 5;
          else
            $scope.focusIndex = $scope.focusIndex - 1;

          refreshDisplay();
        };

        let refreshDisplay = () => {
          $scope.searchTerm = $scope.searchSuggestions[$scope.focusIndex - 1].artist + " - " + $scope.searchSuggestions[$scope.focusIndex - 1].title;
          $scope.$apply();
        };

        let displaySearchSuggestions = ($scope: ISearchScope) => {
          searchService.getSearchSuggestions($scope.searchTerm)
          .then((data: any) => {
            $scope.searchSuggestions = data.results.trackmatches.track.map(function(track){
              return {
                title: track.name,
                splitted: track.name.split("").concat([" ", "-", " "]).concat(track.artist.split("")),
                artist: track.artist,
                image: track.image[0]["#text"]
              };
            });
          });
        };

        $scope.triggerSelectInput = () => {
          let searchBoxElm = document.getElementById("search-ipnut-group");
          searchBoxElm.setAttribute("class", "selected-input input-group-item");
          document.getElementById("search-box").focus();
        };

        $scope.selectSuggestion = (suggestion: app.components.ITrack) => {
          searchService.getTrackLyrics(suggestion)
            .then((response: any) => {
              suggestion.prevLyrics = response.lyrics.trim();
              playlistService.addTrack(suggestion);
            })
            .catch((error) => {
              console.error("$http.get Failed with error", error);
            });
          /*searchService.getSoundCloudID(suggestion)
              .then((response: any) => {
                debugger;
            });*/
          $scope.searchSuggestions = [];
          $scope.searchTerm = "";
          $scope.focusIndex = 0;
        };
        element.bind("keydown", (event) => {
          // console.log(event.keyCode);
          clearTimeout($scope.resetKey);
          $scope.resetKey = setTimeout(() => {
            displaySearchSuggestions($scope);
          }, PRESS_KEY_TIMEOUT);

          switch (event.keyCode) {
            case UP_KEY:
              focusUp();
            break;
            case DOWN_KEY:
              focusDown();
            break;
            case SPACE_KEY:
              clearTimeout($scope.resetKey);
              displaySearchSuggestions($scope);
            break;
            case ENTER_KEY:
              $scope.selectSuggestion($scope.searchSuggestions[$scope.focusIndex - 1]);
              $scope.$apply();
            break;
          }
        });
        $scope.$on("$destroy", () => { element.unbind("keydown"); });
      }
    };
  }

  angular.module("app.components").directive("searchBox", searchBox);
}
