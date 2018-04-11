-- /*******************************************************
-- *
-- * civicrm_scheduledcaserecipient
-- *
-- *******************************************************/
CREATE TABLE `civicrm_scheduledcaserecipient` (
     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique ScheduledCaseRecipient ID',
     `reminder_id` int unsigned    COMMENT 'FK to Scheduled Reminder',
     `case_role_id` int unsigned    COMMENT 'FK to Relationship Type',
      PRIMARY KEY ( `id` ),
      CONSTRAINT FK_civicrm_scheduledcaserecipient_reminder_id FOREIGN KEY (`reminder_id`) REFERENCES `civicrm_action_schedule`(`id`) ON DELETE CASCADE,
      CONSTRAINT FK_civicrm_scheduledcaserecipient_case_role_id FOREIGN KEY (`case_role_id`) REFERENCES `civicrm_relationship_type`(`id`) ON DELETE CASCADE
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- /*******************************************************
-- *
-- * civicrm_scheduledcasetypes
-- *
-- *
-- *******************************************************/
CREATE TABLE `civicrm_scheduledcasetypes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique ScheduledCaseTypes ID',
  `reminder_id` int unsigned    COMMENT 'FK to Scheduled Reminder',
  `case_type_id` int unsigned    COMMENT 'FK to Case Type',
  PRIMARY KEY ( `id` ), CONSTRAINT FK_civicrm_scheduledcasetypes_reminder_id FOREIGN KEY (`reminder_id`) REFERENCES `civicrm_action_schedule`(`id`) ON DELETE CASCADE,          CONSTRAINT FK_civicrm_scheduledcasetypes_case_type_id FOREIGN KEY (`case_type_id`) REFERENCES `civicrm_case_type`(`id`) ON DELETE CASCADE
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;

-- /*******************************************************
-- *
-- * civicrm_scheduledcasestatuses
-- *
-- *
-- *******************************************************/
CREATE TABLE `civicrm_scheduledcasestatuses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique ScheduledCaseStatuses ID',
  `reminder_id` int unsigned    COMMENT 'FK to Scheduled Reminder',
  `case_status_id` int unsigned    COMMENT 'FK to Case Status',
  PRIMARY KEY ( `id` ), CONSTRAINT FK_civicrm_scheduledcasestatuses_reminder_id FOREIGN KEY (`reminder_id`) REFERENCES `civicrm_action_schedule`(`id`) ON DELETE CASCADE,          CONSTRAINT FK_civicrm_scheduledcasestatuses_case_status_id FOREIGN KEY (`case_status_id`) REFERENCES `civicrm_option_value`(`id`) ON DELETE CASCADE
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;