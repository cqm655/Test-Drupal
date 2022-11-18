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
        let bodyTag = $("body").attr("class");
       
        $('.currentDate').html(todayDateJs);
        $('.bodyTag').html(bodyTag);
      }
    }
})(jQuery, Drupal, drupalSettings);