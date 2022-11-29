<?php

namespace Drupal\ib_task_97\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines ShowNodesController class.
 */
class ShowNodesController extends ControllerBase {

  /**
   * Entity type manager.
   *
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Entity tipe manager constructor.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Get number of nodes of the same type.
   *
   * @return array
   *   Return count and type of a node using $node_id.
   */
  public function getCount(int $node_id) {
    $node_storage = $this->entityTypeManager->getStorage('node');
    $node = $node_storage->load($node_id);
    $query = $node_storage->getQuery()
      ->condition('type', $node->bundle());

    return $query->count()->execute();
  }

  /**
   * Display the number of nodes in a dialogue window.
   */
  public function countResponse(int $node_id = 0): AjaxResponse {
    if ($node_id < 1) {
      $content['#markup'] = $this->t('Invalid node !');
    }
    else {
      $count = $this->getCount($node_id);
      $title = $this->t('Nodes count');
      $content['#markup'] = $this->t(
        'Number of nodes with the same type is: @count',
        ['@count' => $count]
      );
    }
    $content['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $options = [
      'minHeight' => 200,
      'resizeble' => TRUE
    ];
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand($title, $content, $options));

    return $response;
  }

}
