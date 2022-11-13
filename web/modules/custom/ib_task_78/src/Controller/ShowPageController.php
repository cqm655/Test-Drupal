<?php

namespace Drupal\ib_task_78\Controller;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Cache\CacheBackendInterface;

/**
 * Class ShowPageController.
 */
class ShowPageController extends ControllerBase {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;


  /**
   * Drupal\Core\Cache\CacheBackendInterface definition.
   *
   * @var Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cache;

  /**
   * {@inheritdoc}
   */
  public function __construct(AccountProxy $current_user, CacheBackendInterface $static_cache) {
    $this->currentUser = $current_user;
    $this->cache = $static_cache;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
      $container->get('cache.default'),
    );
  }

  /**
   * Functon to return data.
   */
  public function index() {

    $current_user_name = $this->currentUser()->getAccountName();

    $current_user_id = $this->currentUser()->id();

    if ($cached_data = $this->cache()->get($current_user_id)) {

      $cached_user = $cached_data->data;
    }

    $display_current_user = '';

    if ($cached_data == $current_user_name) {

      $display_current_user = $cached_user;

    }

    else {

      $display_current_user = $current_user_name;

      $this->cache()->delete($current_user_id);

      $this->cache()->set($current_user_id, $current_user_name, cache::PERMANENT);
    }
    return [
      '#markup' => $display_current_user,
    ];
  }

}
