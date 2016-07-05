<?php
/**
 * @file
 * Contains \Drupal\currencies\CurrenciesController.
 */

namespace Drupal\currencies\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\currencies\BnrbCurrenciesService;
use Drupal\currencies\CurrenciesServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CurrenciesController.
 *
 * @package Drupal\currencies\Controller
 */
class CurrenciesController extends ControllerBase {

  /**
   * Currency service.
   */
  protected $currenciesService;

  /**
   * CurrenciesController constructor.
   */
  public function __construct(BnrbCurrenciesService $currenciesService) {
    $this->currenciesService = $currenciesService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('currencies.nbrb')
    );
  }

  /**
   * Get all currencies.
   */
  public function getAllCurrencies() {
    $currencies_block = \Drupal::service('plugin.manager.block')->createInstance('currencies_block', []);
    $currencies_block = $currencies_block->build();
    return [
      '#markup' => isset($currencies_block['#markup']) ? $currencies_block['#markup'] : '',
    ];
  }

}
