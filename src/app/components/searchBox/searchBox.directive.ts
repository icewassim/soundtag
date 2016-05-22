namespace app.components {
  "use strict";

  export function searchBox(): ng.IDirective {
    return {
      restrict: "E",
      templateUrl: "/components/searchBox/searchBox.html",
      scope: {
        track: "="
      },
    };
  }

  angular.module("app.components").directive("searchBox", searchBox);
}
