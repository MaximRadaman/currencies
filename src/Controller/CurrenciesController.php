<?php
/**
 * @file
 * Contains \Drupal\currencies\CurrenciesController.
 */

namespace Drupal\currencies\Controller;

use Drupal\Core\Controller\ControllerBase;
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
  public function __construct(CurrenciesServiceInterface $currenciesService) {
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

    /**
     * Render All currencies page using block.
     *
     * $currencies_block = \Drupal::service('plugin.manager.block')->createInstance('currencies_block', []);
     * $currencies_block = $currencies_block->build();
     * $output = isset($currencies_block['#markup']) ? $currencies_block['#markup'] : '';
     */

    // Render All currencies page using service.
    $currencies = $this->currenciesService->getAllCurrencies();
    $output = "<table width='100%'>";
    foreach ($currencies as $curriency) {
      $output .= "<tr>";
      $output .= "<td>{$curriency->CharCode}/BYN </td>";
      $output .= "<td>{$curriency->Rate}</td>";
      $output .= "</tr>";
    }
    $output .= "</table>";

    return [
      '#markup' => $output,
    ];
  }

}
