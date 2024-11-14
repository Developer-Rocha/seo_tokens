<?php

namespace Drupal\seo_tokens\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SeoTokenSettingsForm extends ConfigFormBase {

  public function getFormId() {
    return 'seo_token_settings_form';
  }

  protected function getEditableConfigNames() {
    return ['seo_tokens.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('seo_tokens.settings');
    $content_types = \Drupal\node\Entity\NodeType::loadMultiple();

    foreach ($content_types as $type) {
      $fields = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', $type->id());
      $title_fields = ['' => $this->t('- None -')];
      $text_fields = ['' => $this->t('- None -')];
      $image_fields = ['' => $this->t('- None -')];

      foreach ($fields as $field_name => $field) {
        if (in_array($field->getType(), ['text']) && $field_name !== 'field_seo_tokens_title') {
          $title_fields[$field_name] = $field->getLabel();
        }
        if (in_array($field->getType(), ['text', 'text_long']) && $field_name !== 'field_seo_tokens_description') {
          $text_fields[$field_name] = $field->getLabel();
        }
        if (in_array($field->getType(), ['image', 'entity_reference']) && $field_name !== 'field_seo_tokens_image' && $field->getSetting('target_type') == 'media') {
          $image_fields[$field_name] = $field->getLabel();
        }
      }

      if (!empty($text_fields)) {
        $form['content_types'][$type->id()] = [
          '#type' => 'details',
          '#title' => $type->label(),
          '#open' => TRUE,
        ];

        $form['content_types'][$type->id()]['fallback_field_title-' . $type->id()] = [
          '#type' => 'select',
          '#title' => $this->t('Fallback field for SEO title'),
          '#options' => $title_fields,
          '#default_value' => $config->get('content_types.' . $type->id() . '.fallback_field_title-' . $type->id()) ?: '',
        ];

        $form['content_types'][$type->id()]['fallback_field_description-' . $type->id()] = [
          '#type' => 'select',
          '#title' => $this->t('Fallback field for SEO description'),
          '#options' => $text_fields,
          '#default_value' => $config->get('content_types.' . $type->id() . '.fallback_field_description-' . $type->id()) ?: '',
        ];

        $form['content_types'][$type->id()]['fallback_field_image-' . $type->id()] = [
          '#type' => 'select',
          '#title' => $this->t('Fallback field for SEO image'),
          '#options' => $image_fields,
          '#default_value' => $config->get('content_types.' . $type->id() . '.fallback_field_image-' . $type->id()) ?: '',
        ];
      } else {
        $form['content_types'][$type->id()] = [
          '#type' => 'markup',
          '#markup' => $this->t('No text fields available for @content_type', ['@content_type' => $type->label()]),
        ];
      }
    }

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('seo_tokens.settings');
    $content_types = \Drupal\node\Entity\NodeType::loadMultiple();

    foreach ($content_types as $type) {
      $title_value = $form_state->getValue('fallback_field_title-' . $type->id());
      $description_value = $form_state->getValue('fallback_field_description-' . $type->id());
      $image_value = $form_state->getValue('fallback_field_image-' . $type->id());

      if (isset($title_value) && !empty($title_value)) {
        $config->set('content_types.' . $type->id() . '.fallback_field_title-' . $type->id(), $title_value);
      }

      if (isset($description_value) && !empty($description_value)) {
        $config->set('content_types.' . $type->id() . '.fallback_field_description-' . $type->id(), $description_value);
      }

      if (isset($image_value) && !empty($image_value)) {
        $config->set('content_types.' . $type->id() . '.fallback_field_image-' . $type->id(), $image_value);
      }
    }

    $config->save();
    parent::submitForm($form, $form_state);
  }
}
