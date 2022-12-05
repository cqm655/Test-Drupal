<?php

namespace Drupal\ib_task_102\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Plugin\PluginManagerBase;

/**
 * Class ContentTypeController.
 */
class ContentTypeController extends ControllerBase {

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
         $container->get('plugin.manager.block'),
       );
  }

  /**
   * Function showIndex to return output.
   */
  public function setData() {

    $link = '<a href="/form-data" class="use-ajax" data-dialog-type="modal">Add data to Factory</a>';

    return [
      '#markup' => $link,
      '#attached' => [
        'library' => [
          'core/drupal.dialog.ajax',
          'core/jquery.form',
        ],
      ],
    ];
  }

}
