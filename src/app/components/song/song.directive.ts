/// <reference path="../components.module.ts"/>

namespace app.components {
  "use strict";

  interface ISong {
    title: string;
    artist: string;
    prevLyrics: string;
    soundCloudId?: string;
    albumThumbnail?: string;
    soundCloudPermalink?: string;
  }

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
