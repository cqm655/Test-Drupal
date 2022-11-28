<?php

namespace Drupal\ib_task_122\Event;

use Drupal\Component\EventDispatcher\Event;

/**
 * Event to show a loaded node.
 */
class Task122Event extends Event {

  const EVENT_NAME = 'simple_page_load';

  /**
   * Implements the construct for a class object.
   */
  public function __construct() {
    \Drupal::messenger()->addStatus('Simple Page Loaded');
  }

}
