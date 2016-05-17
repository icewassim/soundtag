/// <reference path="./_all.ts"/>
/// <reference path="./core/core.module.ts"/>
/// <reference path="./components/components.module.ts"/>

namespace app {
  "use strict";

  angular.module("app", [
    "app.core",
    "app.components"
  ]).config(function($interpolateProvider) {
    $interpolateProvider.startSymbol("##").endSymbol("##");
  });
}
