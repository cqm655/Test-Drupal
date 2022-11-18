<?php

namespace Drupal\ib_task_56\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Plugin\PluginManagerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class ModalFormController.
 */
class ModalFormController extends ControllerBase {

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
   * Functon to out some data.
   */
  public function modalShow() {

    $config = [];
    // Create a instance of our custom block.
    $block_manager = $this->blockPluginManager->createInstance('Ib_task_56_Block', $config);

    $render = $block_manager->build();

    // Connection to js.
    $output['#attached']['library'][] = 'ib_task_56/ib_task_56';

    return [
      $render,
    ];
  }

}
