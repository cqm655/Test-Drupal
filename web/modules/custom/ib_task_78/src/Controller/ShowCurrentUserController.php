<?php

namespace Drupal\ib_task_78\Controller;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Cache\CacheBackendInterface;

/**
 * Class ShowCurrentUserController.
 */
class ShowCurrentUserController extends ControllerBase {

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
   * Function to return data.
   */
  public function showCurrentUserName() {

    $current_user_name = $this->currentUser()->getAccountName();

    $cache_id = $this->currentUser()->id();

    $display_current_user_name = '';

    if ($cached_data = $this->cache()->get($cache_id)) {

      $cached_data = $cached_data->data;

      $display_current_user_name = $cached_data;
    }

    else {

      $display_current_user_name = $current_user_name;

      $this->cache()->set($cache_id, $current_user_name, cache::PERMANENT);
    }
    return [
      '#markup' => $display_current_user_name,
    ];
  }

}
