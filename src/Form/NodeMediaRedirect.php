<?php

namespace Drupal\basic_ingest\Form;

use Drupal\Core\Form\FormStateInterface;

/**
 * Helper; redirect to the related node when ingesting media belonging to a node.
 */
class NodeMediaRedirect {

  const NODE_COORDS = [
    'field_media_of',
    0,
    'target_id',
  ];

  /**
   * Delegated hook_form_alter().
   */
  public static function alter(array &$form, FormStateInterface $form_state) {
    $form['actions']['submit']['#submit'][] = [static::class, 'submit'];
  }

  /**
   * Form submission handler.
   */
  public static function submit(array &$form, FormStateInterface $form_state) {
    $node_id = $form_state->getValue(static::NODE_COORDS);
    if ($node_id) {
      $form_state->setRedirect('entity.node.canonical', [
        'node' => $node_id,
      ]);
    }
  }

}
