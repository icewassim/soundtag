/// <reference path='../_all.ts' />

namespace soundTags {
  "use strict";

  let soundTagsApp = angular.module("app.core", [])
                            .controller("playlistController", PlaylistController)
                            .directive("song", songDirective)
                            .config(function($interpolateProvider) {
                              $interpolateProvider.startSymbol("##").endSymbol("##");
                            });
}
