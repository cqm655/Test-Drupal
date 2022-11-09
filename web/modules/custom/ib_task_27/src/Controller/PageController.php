<?php

namespace Drupal\ib_task_27\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

/**
 * Class PageController.
 */
class PageController extends ControllerBase {

  /**
   * Variable used for dependency injection.
   *
   * @var my_Var
   */
  protected $connection;

  /**
   * Function constructor.
   */
  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  /**
   * Function to create dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
          $container->get('database')
        );
  }

  /**
   * Functon to fetch data from DB.
   */
  public function show() {

    $nodes = $this->connection
      ->select('node_field_data', 'n')
      ->fields('n', ['title', 'created'])
      ->range(0, 5)
      ->execute()
      ->fetchAll();

    $data = [];

    foreach ($nodes as $row) {
      $data[] = [
        'title' => $row->title,
        'created' => $row->created,
      ];
    }

    $header = ['Title', 'Created'];

    $build['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $data,
    ];

    return [
      $build,
    ];
  }

}
