/// <reference path='../libs/angular/angular.d.ts' />

namespace app {
  "use strict";

  angular.module("app", [
    "app.core",
    "app.components"
  ]).config(function($interpolateProvider) {
    $interpolateProvider.startSymbol("##").endSymbol("##");
  });
}

/// <reference path="./core/core.module.ts"/>
/// <reference path="./components/components.module.ts"/>
