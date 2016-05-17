
namespace app.components {
  "use strict";

  export function song(): ng.IDirective {
    return {
      restrict: "E",
      templateUrl: "/components/song/song.html",
      scope: {
        song: "="
      }
    };
  }

  angular.module("app.components").directive("song", song);
}
