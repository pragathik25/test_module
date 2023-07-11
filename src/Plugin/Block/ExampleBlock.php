<?php

namespace Drupal\test_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;


/**
 *
 * @Block(
 *   id = "test_block",
 *   admin_label = @Translation("testblock"),
 *   category = @Translation("testBlock"),
 * )
 */

class ExampleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $configFactory;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }

  public function build() {

    $config = $this->configFactory->getEditable('test_module.settings');

    $title = $config->get('title');
    $text = $config->get('text')['value'];
    $display = $config->get('display');

    $data['title'] = [
      '#markup' => '<h3>' . $title . '</h3>',
    ];

    if ($display) {
      $data['text'] = [
        '#markup' => $text,
      ];
    }
    return $data;
  }
  public function getCacheMaxAge() {
    return 0;
  }

}
