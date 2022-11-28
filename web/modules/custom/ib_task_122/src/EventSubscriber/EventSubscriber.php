<?php

namespace Drupal\ib_task_122\EventSubscriber;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Path\CurrentPathStack;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\ib_task_122\Event\Task122Event;

/**
 * Class event subscriber.
 */
class EventSubscriber implements EventSubscriberInterface {

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
  protected $loggerChanel;

  /**
   * Default constructor.
   */
  public function __construct(CurrentPathStack $current_stack_path, LoggerChannelFactoryInterface $logger_channel) {
    $this->currentStackPath = $current_stack_path;
    $this->loggerChanel = $logger_channel;
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

    // Get current path.
    $current_path = $this->currentStackPath->getPath();

    if ($current_path == '/page-example') {

      $this->loggerChanel->get('Simple Page')->info('Simple Page Loaded');

    }

  }

}
