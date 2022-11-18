/**
 * @file
 * Simple JavaScript hello world file.
 */

 (function ($, Drupal, settings) {

    "use strict";
  
    Drupal.behaviors.ib_task_94 = {
      attach: function (context, settings) {

      let todayDateJs = new Date();
      console.log(todayDateJs)

      $.ajax({
        type: 'POST',
        url: '/show-content',
        data: {todayDateJs: 'todayDateJs'},
        contentType: 'application/json; charset=utf-8',
        success: function (response) {
            alert('succes' );
        },
        error: function () {
            alert('error' );
        }
      });
      }
    }
  })(jQuery, Drupal, drupalSettings);