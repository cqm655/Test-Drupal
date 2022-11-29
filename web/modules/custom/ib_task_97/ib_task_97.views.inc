<?php

/**
 * @file
 * Provide a custom views field data that isn't tied to any other module.
 */

/**
 * Implements hook_views_data().
 *
 * Alter DB tables defined via hook_views_data().
 */
function ib_task_97_views_data() {
    $data['views']['table']['group'] = ('Custom Global');
    $data['views']['table']['join'] = [
      '#global' => [],
    ];
    $data['views']['counter_views_field'] = [
      'title' => ('ib_task_97 field'),
      'help' => ('Field that show dialogue window with number of nodes.'),
      'field' => [
        'id' => 'counter_views_field',
      ],
    ];
    return $data;
}