<?php

namespace Drupal\ib_task_94\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Plugin\PluginManagerBase;
use Symfony\Component\HttpFoundation\Request;

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
   * Function showIndex to return output.
   */
  public function showIndex(Request $request) {

    $output = [];
    $output['#markup'] = '<h1 class="bodyTag"></h1>';
    $output['#attached']['library'][] = 'ib_task_94/ib_task_94';

    $config = [];

    $block_manager = $this->blockPluginManager->createInstance('ib_task_94_Block', $config);

    $render = $block_manager->build();

    return [
      $output,
      $render,
    ];
  }

}
