<?php
use CRM_Scheduledcaserecipients_ExtensionUtil as E;

return [
  'name' => 'ScheduledCaseStatuses',
  'table' => 'civicrm_scheduledcasestatuses',
  'class' => 'CRM_Scheduledcaserecipients_DAO_ScheduledCaseStatuses',
  'getInfo' => fn() => [
    'title' => E::ts('Scheduled Case Statuses'),
    'title_plural' => E::ts('Scheduled Case Statuseses'),
    'description' => E::ts('FIXME'),
    'log' => TRUE,
    'add' => '4.4',
  ],
  'getFields' => fn() => [
    'id' => [
      'title' => E::ts('ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Number',
      'required' => TRUE,
      'description' => E::ts('Unique ScheduledCaseStatuses ID'),
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
    'case_status_id' => [
      'title' => E::ts('Case Status ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'EntityRef',
      'description' => E::ts('FK to Case Status'),
      'add' => '4.6',
      'entity_reference' => [
        'entity' => 'OptionValue',
        'key' => 'id',
        'on_delete' => 'CASCADE',
      ],
    ],
  ],
];
