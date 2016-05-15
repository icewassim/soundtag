/// <reference path='../../_all.ts' />

namespace playlist {
  "use strict";

  function todoEscape(): ng.IDirective {
    return{
      restrict: "E",
      templateUrl: "song.html",
      scope: {
        song: "=song"
      }
    };
  }
}
