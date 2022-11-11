<?php

namespace Drupal\ib_task_28\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Plugin\PluginManagerBase;

/**
 * Class PageController.
 */
class PageController extends ControllerBase {

  /**
   * Drupal\Core\Form\FormBuilderInterface $formbuilder.
   *
   * @var blockPluginManager
   */
  protected $blockPluginManager;

  /**
   * Default constructor for managing plugin blocks.
   */
  public function __construct(PluginManagerBase $block_plugin_manager) {
    $this->blockPluginManager = $block_plugin_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
         $container->get('plugin.manager.block')
       );
  }

  /**
   * Function index, receive arg from URL, return arg number of blocks.
   */
  public function index($arg) {

    // You can hard code configuration or you load from settings.
    $config = [];

    $block_manager = $this->blockPluginManager->createInstance('ib_task_28_Block', $config);

    $blocks_to_dysplay = [];

    $i = 0;

    while ($i++ < $arg) {

      $render = $block_manager->build();
      $blocks_to_dysplay[] = $render;
    };
    return [
      $blocks_to_dysplay,
    ];
  }

}
