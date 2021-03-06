namespace app.core {
  "use strict";

  let reverse = function() {
    return function(items) {
      if (items)
        return items.slice().reverse();
    };
  };

  angular.module("app.core").filter("reverse", reverse);
};
