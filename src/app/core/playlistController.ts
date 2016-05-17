/// <reference path="./core.module.ts"/>

namespace  app.core {
  "use strict";

  export class PlaylistController {
    public song: any;
    constructor() {
      console.log("helllo");
      this.song = {
        title: "sweet child o mine",
        artist: "slash",
        prevLyrics: "hello dude "
      };
    }
  }
  angular.module("app.core").controller("playlistController", PlaylistController);
}
