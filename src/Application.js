/// <reference path='../_all.ts' />
var playlist;
(function (playlist) {
    "use strict";
    var SoundTagsController = (function () {
        function SoundTagsController() {
            console.log("hello");
        }
        return SoundTagsController;
    }());
    playlist.SoundTagsController = SoundTagsController;
})(playlist || (playlist = {}));
/// <reference path='../libs/jquery/jquery.d.ts' />
/// <reference path='../libs/angular/angular.d.ts' />
/// <reference path='core/soundTagsController.ts'/>
/// <reference path='core/core.module.ts'/>
/// <reference path='../_all.ts' />
var playlist;
(function (playlist) {
    "use strict";
    var soundTagsApp = angular.module("app.core", [])
        .controller("SoundTagsController", playlist.SoundTagsController);
})(playlist || (playlist = {}));
