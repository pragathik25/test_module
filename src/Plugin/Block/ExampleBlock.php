<?php

namespace Drupal\test_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a simple block.
 *
 * @Block(
 *   id = "test_block",
 *   admin_label = @Translation("testblock"),
 *   category = @Translation("testBlock"),
 * )
 */
class ExampleBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Construct function.
   *
   * @param array $configuration
   *   It is the configuration.
   * @param string $plugin_id
   *   It is the plugin id.
   * @param mixed $plugin_definition
   *   It is the Plugin definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   It is config factory service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritDoc}
   */
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

  /**
   * To invalidate cache.
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
