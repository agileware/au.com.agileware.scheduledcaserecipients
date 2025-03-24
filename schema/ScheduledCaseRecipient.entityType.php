<?php
use CRM_Scheduledcaserecipients_ExtensionUtil as E;

return [
  'name' => 'ScheduledCaseRecipient',
  'table' => 'civicrm_scheduledcaserecipient',
  'class' => 'CRM_Scheduledcaserecipients_DAO_ScheduledCaseRecipient',
  'getInfo' => fn() => [
    'title' => E::ts('Scheduled Case Recipient'),
    'title_plural' => E::ts('Scheduled Case Recipients'),
    'description' => E::ts('FIXME'),
    'log' => TRUE,
    'add' => '4.6',
  ],
  'getFields' => fn() => [
    'id' => [
      'title' => E::ts('ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Number',
      'required' => TRUE,
      'description' => E::ts('Unique ScheduledCaseRecipient ID'),
      'add' => '4.6',
      'primary_key' => TRUE,
      'auto_increment' => TRUE,
    ],
    'reminder_id' => [
      'title' => E::ts('Reminder ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'EntityRef',
      'description' => E::ts('FK to Scheduled Reminder'),
      'add' => '4.6',
      'entity_reference' => [
        'entity' => 'ActionSchedule',
        'key' => 'id',
        'on_delete' => 'CASCADE',
      ],
    ],
    'case_role_id' => [
      'title' => E::ts('Case Role ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'EntityRef',
      'description' => E::ts('FK to Relationship Type'),
      'add' => '4.6',
      'entity_reference' => [
        'entity' => 'RelationshipType',
        'key' => 'id',
        'on_delete' => 'CASCADE',
      ],
    ],
  ],
];
