namespace app.components {
  "use strict";
  const SPACE_KEY = 32;
  const UP_KEY = 38;
  const DOWN_KEY = 40;
  const ENTER_KEY = 13;

  interface ISearchScope extends ng.IScope {
    searchTerm: any;
    focusIndex: number;
    searchSuggestions: Array<app.components.ITrack>;
  }

  export function searchBox(searchService: app.core.ISearchService, playlistService: app.core.IPlaylistService): ng.IDirective {
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
        element.bind("keydown", (event) => {
          // console.log(event.keyCode);
          switch (event.keyCode) {
            case UP_KEY:
              focusUp();
            break;
            case DOWN_KEY:
              focusDown();
            break;
            case SPACE_KEY:
              searchService.getSearchSuggestions($scope.searchTerm)
              .then((data: any) => {
                $scope.searchSuggestions = data.results.trackmatches.track.map(function(track){
                  return {
                    title: track.name,
                    artist: track.artist,
                    image: track.image[0]["#text"]
                  };
                });
              });
            break;
            case ENTER_KEY:
              playlistService.addTrack($scope.searchSuggestions[$scope.focusIndex - 1]);
              $scope.searchSuggestions = [];
              $scope.searchTerm = "";
              $scope.focusIndex = 0;
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
