(function($) {
  'use strict';

  if ($(".js-example-basic-single").length) {
    $(".js-example-basic-single").select2();
  }

  function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
      return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
      return null;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if (data.text.indexOf(params.term) > -1) {
      var modifiedData = $.extend({}, data, true);
      modifiedData.text += ' (matched)';

      // You can return modified objects from here
      // This includes matching the `children` how you want in nested data sets
      return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
  }

  function matchStart(params, data) {
    if ($.trim(params.term) === '') {
        return data;
    }

    var filteredData = [];
    $.each(data, function (idx, option) {
        if (option.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
            filteredData.push(option);
        }
    });

    return filteredData;
}
  
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2({
        matcher: matchCustom
    });
  }
  
  if ($(".select2-search").length) {
    $(".select2-search").select2({
        matcher: matchStart
    });
  }
})(jQuery);
