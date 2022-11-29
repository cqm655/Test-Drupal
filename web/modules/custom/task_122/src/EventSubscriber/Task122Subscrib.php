<?php

namespace Drupal\task_122\EventSubscriber;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Path\CurrentPathStack;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\task_122\Event\Task122Event;

/**
 * Class event subscriber.
 */
class Task122Subscrib implements EventSubscriberInterface {

  /**
   * Active route path.
   *
   * @var \Drupal\Core\Path\CurrentPathStack
   */
  protected $currentStackPath;

  /**
   * Constructs a logger_channel object.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * Default constructor.
   */
  public function __construct(CurrentPathStack $current_stack_path, LoggerChannelFactoryInterface $logger_factory) {
    $this->currentStackPath = $current_stack_path;
    $this->loggerFactory = $logger_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      Task122Event::EVENT_NAME => 'onLoad',
    ];
  }

  /**
   * Subscribe on event.
   */
  public function onLoad() {

    // Send message to logg.
    $this->loggerFactory->get('Simple Page')->alert('Simple Page Load');
  }

}
