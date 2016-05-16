/// <reference path="../../_all.ts"/>

namespace soundTags {
  "use strict";

  export function songDirective(): ng.IDirective {
    return {
      restrict: "E",
      templateUrl: "/components/song/song.html",
      scope: {
        song: "=song"
      }
    };
  }
}
