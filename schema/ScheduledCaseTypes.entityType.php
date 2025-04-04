<?php
use CRM_Scheduledcaserecipients_ExtensionUtil as E;

return [
  'name' => 'ScheduledCaseTypes',
  'table' => 'civicrm_scheduledcasetypes',
  'class' => 'CRM_Scheduledcaserecipients_DAO_ScheduledCaseTypes',
  'getInfo' => fn() => [
    'title' => E::ts('Scheduled Case Types'),
    'title_plural' => E::ts('Scheduled Case Typeses'),
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
      'description' => E::ts('Unique ScheduledCaseTypes ID'),
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
    'case_type_id' => [
      'title' => E::ts('Case Type ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'EntityRef',
      'description' => E::ts('FK to Case Type'),
      'add' => '4.6',
      'entity_reference' => [
        'entity' => 'CaseType',
        'key' => 'id',
        'on_delete' => 'CASCADE',
      ],
    ],
  ],
];
