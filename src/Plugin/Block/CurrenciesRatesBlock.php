<?php
/**
 * @file
 * Contains \Drupal\currencies\Plugin\Block\CurrenciesRatesBlock.
 */

namespace Drupal\currencies\Plugin\Block;

use Behat\Mink\Exception\Exception;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provide a CurrenciesRatesBlock plugin.
 *
 * @Block(
 *   id = "currencies_block",
 *   admin_label = @Translation("Currencies block"),
 * )
 */
class CurrenciesRatesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();
    $currencies = \Drupal::service('currencies.nbrb')->getAllCurrencies();

    if (isset($config['currencies_list'])) {
      foreach ($currencies as $key => $curriency) {
        if (!in_array($key, $config['currencies_list'])) {
          unset($currencies[$key]);
        }
      }
    }

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

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $options = \Drupal::service('currencies.nbrb')->getAllCurrencies();

    $form['currencies_list'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Select currencies'),
      '#description' => $this->t('If none selected all currencies will be displayed'),
      '#options' => array_combine(array_keys($options), array_keys($options)),
      '#default_value' => isset($config['currencies_list']) ? $config['currencies_list'] : '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['currencies_list'] = [];
    foreach ($form_state->getValue('currencies_list') as $key => $value) {
      if (!$value) {
        continue;
      }
      $this->configuration['currencies_list'][$key] = $value;
    }
  }

}
