/**
 * @file
 * Simple JavaScript hello world file.
 */

 (function ($, Drupal, settings) {

    "use strict";
  
    Drupal.behaviors.ib_task_94 = {
      attach: function (context, settings) {

        // Create an object with current Date/Time.
        let todayDateJs = new Date();
        // Save in bodyTag variable className tag of body.
        let bodyTag = document.getElementsByTagName("body")[0].className;

        $('.myBicycle').html(todayDateJs);
        $('.bodyTag').html(bodyTag);
      }
    }
})(jQuery, Drupal, drupalSettings);