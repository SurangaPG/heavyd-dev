// Contains all the JS that should be included on any page.
(function ($) {
  'use strict';

  Drupal.behaviors.menuToggle = {
    attach: function(context, settings) {
      $(context).find('.menu-toggle').on('click', function() {
        $(this).toggleClass('-active')
        $($(this).attr('data-selector')).toggleClass('open')
      })
    }
  }
})(jQuery);

