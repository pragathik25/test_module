<?php

namespace Drupal\test_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implementing config form.
 */
class AdminConfig extends ConfigFormBase {

  const RESULT = "test_module.settings";

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return "test_module_settings";
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::RESULT,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config(static::RESULT);
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => 'Title',
      '#required' => TRUE,
      '#default_value' => $config->get("title"),
    ];

    $text_format = 'full_html';
    if ($config->get('text')['format']) {
      $text_format = $config->get('text')['format'];
    }
    $form['text'] = [
      '#type' => 'text_format',
      '#title' => 'Text',
      '#required' => TRUE,
      '#format' => $text_format,
      '#default_value' => $config->get("text")['value'],
    ];
    $form['display'] = [
      '#type' => 'checkbox',
      '#title' => 'Display',
      '#default_value' => $config->get("display"),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->config(static::RESULT);
    $config->set("title", $form_state->getValue('title'));
    $config->set("text", $form_state->getValue('text'));
    $config->set("display", $form_state->getValue('display'));
    $config->save();
  }

}
