<?php

require_once 'scheduledcaserecipients.civix.php';
use CRM_Scheduledcaserecipients_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function scheduledcaserecipients_civicrm_config(&$config) {
  _scheduledcaserecipients_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function scheduledcaserecipients_civicrm_install() {
  _scheduledcaserecipients_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function scheduledcaserecipients_civicrm_enable() {
  _scheduledcaserecipients_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function scheduledcaserecipients_civicrm_buildForm($formName, &$form) {
  if ($formName == "CRM_Admin_Form_ScheduleReminders" && ($form->getAction() & CRM_Core_Action::ADD || $form->getAction() & CRM_Core_Action::UPDATE)) {
    $caseRoles = array();
    $displayCaseRoles = FALSE;
    $displayCaseTypes = FALSE;
    $displayCaseStatuses = FALSE;

    if ($form->getVar('_id')) {
      $values = $form->getVar('_values');
      if ($values["mapping_id"] == 1) {
        $caseRoles = civicrm_api3("ScheduledCaseRecipient", "get", array(
            "reminder_id" => $values["id"],
        ));

        if ($caseRoles["count"]) {
          $displayCaseRoles = TRUE;
          $caseRoles = array_column($caseRoles["values"], "case_role_id");
          $form->assign('selected_case_roles', $caseRoles);
        }

        $caseTypes = civicrm_api3("ScheduledCaseTypes", "get", array(
            "reminder_id" => $values["id"],
        ));

        if ($caseTypes["count"]) {
          $displayCaseTypes = TRUE;
          $caseTypes = array_column($caseTypes["values"], "case_type_id");
          $form->assign('selected_case_types', $caseTypes);
        }

        $caseStatuses = civicrm_api3("ScheduledCaseStatuses", "get", array(
          "reminder_id" => $values["id"],
        ));

        if ($caseStatuses["count"]) {
          $displayCaseStatuses = TRUE;
          $caseStatuses = array_column($caseStatuses["values"], "case_status_id");
          $form->assign('selected_case_statuses', $caseStatuses);
        }
      }
    }
    $form->assign('display_case_roles', $displayCaseRoles);
    $form->assign('display_case_types', $displayCaseTypes);
    $form->assign('display_case_statuses', $displayCaseStatuses);

    $form->addEntityRef('case_roles', ts('Roles'), array(
        'entity' => 'RelationshipType',
        'placeholder' => ts('- Select Roles -'),
        'select' => array('minimumInputLength' => 0, 'multiple' => TRUE, 'value' => $caseRoles),
    ));

    $form->addEntityRef('case_types', ts('Case Types'), array(
      'entity' => 'CaseType',
      'placeholder' => ts('- Select Types-'),
      'select' => array('minimumInputLength' => 0, 'multiple' => TRUE),
    ));

    $form->addEntityRef('case_statuses', ts('Case Status'), array(
      'entity' => 'OptionValue',
      'placeholder' => ts('- Select Status-'),
      'api' => array(
        'params' => array('option_group_id' => 'case_status'),
      ),
      'select' => array('minimumInputLength' => 0, 'multiple' => TRUE),
    ));

    CRM_Core_Region::instance('page-body')->add(array(
        'template' => 'CRM/Scheduledcaserecipients/Form/Roles.tpl',
    ));
  }
}

/**
 * Implements hook_civicrm_postProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postProcess
 */
function scheduledcaserecipients_civicrm_postProcess($formName, &$form) {
  if ($formName == "CRM_Admin_Form_ScheduleReminders") {
    $formid = $form->get('id');

    $caseRoleIds = CRM_Utils_Array::value('case_roles', $form->_submitValues);
    $caseTypeIds = CRM_Utils_Array::value('case_types', $form->_submitValues);
    $caseStatusIds = CRM_Utils_Array::value('case_statuses', $form->_submitValues);

    $actionScheduleCount = civicrm_api3('ActionSchedule', 'getcount', array(
      'id' => $formid,
    ));

    if ($caseRoleIds != "") {
      $caseRoleIds = explode(",", $caseRoleIds);
      $scheduledcaseids = civicrm_api3("ScheduledCaseRecipient", "get", array(
        "reminder_id" => $formid,
        "return"      => "id",
      ));
      $scheduledcaseids = array_column($scheduledcaseids["values"], "id");
      foreach ($scheduledcaseids as $scheduledcaseid) {
        civicrm_api3("ScheduledCaseRecipient", "delete", array(
            "id" => $scheduledcaseid,
        ));
      }
      if ($form->_submitValues['entity'][0] == 1 && $form->_submitValues['recipient'] == 'caseroles') {
        foreach ($caseRoleIds as $caseRoleId) {
          $params = array(
            'reminder_id' => $formid,
            'case_role_id' => $caseRoleId,
          );
          if ($actionScheduleCount) {
            civicrm_api3("ScheduledCaseRecipient", "create", $params);
          }
        }
      }
    }

    $scheduledcasetypeids = civicrm_api3("ScheduledCaseTypes", "get", array(
      "reminder_id" => $formid,
      "return"      => "id",
    ));
    $scheduledcasetypeids = array_column($scheduledcasetypeids["values"], "id");
    foreach ($scheduledcasetypeids as $scheduledcasetypeid) {
      civicrm_api3("ScheduledCaseTypes", "delete", array(
          "id" => $scheduledcasetypeid,
      ));
    }

    if ($form->_submitValues['entity'][0] == 1 && $caseTypeIds != "") {
      $caseTypeIds = explode(",", $caseTypeIds);
      foreach ($caseTypeIds as $caseTypeId) {
        $params = array(
          'reminder_id' => $formid,
          'case_type_id' => $caseTypeId,
        );
        if ($actionScheduleCount) {
          civicrm_api3("ScheduledCaseTypes", "create", $params);
        }
      }
    }

    $scheduledcasestatusids = civicrm_api3("ScheduledCaseStatuses", "get", array(
      "reminder_id" => $formid,
      "return"      => "id",
    ));
    $scheduledcasestatusids = array_column($scheduledcasestatusids["values"], "id");
    foreach ($scheduledcasestatusids as $scheduledcasestatusid) {
      civicrm_api3("ScheduledCaseStatuses", "delete", array(
          "id" => $scheduledcasestatusid,
      ));
    }

    if ($form->_submitValues['entity'][0] == 1 && $caseStatusIds != "") {
      $caseStatusIds = explode(",", $caseStatusIds);
      foreach ($caseStatusIds as $caseStatusId) {
        $params = array(
          'reminder_id' => $formid,
          'case_status_id' => $caseStatusId,
        );
        if ($actionScheduleCount) {
          civicrm_api3("ScheduledCaseStatuses", "create", $params);
        }
      }
    }
  }
}

/**
 * Implements hook_civicrm_alterMailParams().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterMailParams
 */
function scheduledcaserecipients_civicrm_alterMailParams(&$params, $context) {
  if ($params['groupName'] == "Scheduled Reminder Sender" && $params['entity'] == "action_schedule" && isset($params["token_params"])) {

    $reminder_id = $params['entity_id'];
    $scheduledcaseroleids = civicrm_api3("ScheduledCaseRecipient", "get", array(
        "reminder_id" => $reminder_id,
        "sequential"  => TRUE,
        "return"      => array("case_role_id"),
    ));

    if (count($scheduledcaseroleids["values"]) && isset($params["token_params"]) && isset($params["token_params"]["case_id"])) {
      $scheduledcaseroleids = array_column($scheduledcaseroleids["values"], "case_role_id");
      $contactEmails = CRM_Scheduledcaserecipients_BAO_ScheduledCaseRecipient::findEmailsByCaseRoles($scheduledcaseroleids, $params["token_params"]["case_id"]);
      if (count($contactEmails)) {
        $contactEmails = implode(",", $contactEmails);
        $params["toEmail"] = $contactEmails;
      }
    }

    if (isset($params["token_params"]) && isset($params["token_params"]["activity_id"])) {
      $activityId = $params["token_params"]["activity_id"];
      $targetContacts = civicrm_api3('ActivityContact', 'get', array(
        'sequential' => 1,
        'return' => "contact_id",
        'record_type_id' => "Activity Targets",
        'activity_id' => $activityId,
      ));
      $targetContacts = array_column($targetContacts["values"], "contact_id");
      $targetContacts = array_unique($targetContacts);

      $targetContactNames = civicrm_api3('Contact', 'get', array(
        'sequential' => 1,
        'return'     => "display_name",
        'contact_id' => array("IN" => $targetContacts),
      ));

      $targetContactNames = array_column($targetContactNames["values"], "display_name");

      $targetContactNames = implode(",", $targetContactNames);

      $params['html'] = str_replace("[activityTarget]", $targetContactNames, $params['html']);
      $params['subject'] = str_replace("[activityTarget]", $targetContactNames, $params['subject']);
      $params['text'] = str_replace("[activityTarget]", $targetContactNames, $params['text']);
    }

    if (isset($params["token_params"]) && isset($params["token_params"]["case_id"])) {
      $caseId = $params["token_params"]["case_id"];

      $caseInfo = civicrm_api3("Case", "get", array(
          "id"         => $caseId,
          "sequential" => 1,
      ));
      if ($caseInfo["count"]) {
        $caseInfo = $caseInfo["values"][0];
      }

      $params['html'] = str_replace("[activityCaseId]", $caseId, $params['html']);
      $params['subject'] = str_replace("[activityCaseId]", $caseId, $params['subject']);
      $params['text'] = str_replace("[activityCaseId]", $caseId, $params['text']);

      $params['html'] = str_replace("[activityCaseSubject]", $caseInfo["subject"], $params['html']);
      $params['subject'] = str_replace("[activityCaseSubject]", $caseInfo["subject"], $params['subject']);
      $params['text'] = str_replace("[activityCaseSubject]", $caseInfo["subject"], $params['text']);

      $caseTypeId = $caseInfo["case_type_id"];

      $allScheduledCaseTypesCount = civicrm_api3("ScheduledCaseTypes", "getcount", array(
        "reminder_id"  => $reminder_id,
      ));

      $scheduledCaseTypesCount = civicrm_api3("ScheduledCaseTypes", "getcount", array(
         "case_type_id" => $caseTypeId,
         "reminder_id"  => $reminder_id,
      ));

      $caseStatusId = $caseInfo["status_id"];

      $allScheduledCaseStatusesCount = civicrm_api3("ScheduledCaseStatuses", "getcount", array(
        "reminder_id"  => $reminder_id,
      ));

      $scheduledCaseStatusesCount = civicrm_api3("ScheduledCaseStatuses", "getcount", array(
        "case_status_id" => $caseStatusId,
        "reminder_id"  => $reminder_id,
      ));

      if (($allScheduledCaseTypesCount && !$scheduledCaseTypesCount) || ($allScheduledCaseStatusesCount && !$scheduledCaseStatusesCount)) {
        $params["abortMailSend"] = TRUE;
      }
    }
  }
}

/**
 * Implements hook_civicrm_tokenValues().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokenValues
 */
function scheduledcaserecipients_civicrm_tokenValues(&$values, $cids, $job = NULL, $tokens = array(), $context = NULL) {
  if (!is_array($cids)) {
    $values['case.id'] = "[activityCaseId]";
    $values['case.subject'] = "[activityCaseSubject]";
    $values['activity.activity_target'] = "[activityTarget]";
  }
  else {
    foreach ($cids as $cid) {
      $values[$cid]['case.id'] = "[activityCaseId]";
      $values[$cid]['case.subject'] = "[activityCaseSubject]";
      $values[$cid]['activity.activity_target'] = "[activityTarget]";
    }
  }
}

/**
 * Implements hook_civicrm_tokens().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokens
 */
function scheduledcaserecipients_civicrm_tokens(&$tokens) {
  $tokens['case'] = array(
    'case.subject' => ts("Case Subject"),
    'case.id'      => ts("Case ID"),
  );
  $tokens['activity'] = array(
    'activity.activity_target' => ts("Activity Target"),
  );
}

/**
 * Implements hook_civicrm_entityTypes().
 */

// function scheduledcaserecipients_civicrm_entityTypes(&$entityTypes) {
//   if (!isset($entityTypes['CRM_Scheduledcaserecipients_DAO_ScheduledCaseRecipient'])) {
//     $entityTypes['CRM_Scheduledcaserecipients_DAO_ScheduledCaseRecipient'] = array(
//       'name' => 'ScheduledCaseRecipient',
//       'class' => 'CRM_Scheduledcaserecipients_DAO_ScheduledCaseRecipient',
//       'table' => 'civicrm_scheduledcaserecipient',
//     );
//   }
//   if (!isset($entityTypes['CRM_Scheduledcaserecipients_DAO_ScheduledCaseTypes'])) {
//     $entityTypes['CRM_Scheduledcaserecipients_DAO_ScheduledCaseTypes'] = array(
//       'name' => 'ScheduledCaseTypes',
//       'class' => 'CRM_Scheduledcaserecipients_DAO_ScheduledCaseTypes',
//       'table' => 'civicrm_scheduledcasetypes',
//     );
//   }
//   if (!isset($entityTypes['CRM_Scheduledcaserecipients_DAO_ScheduledCaseStatuses'])) {
//     $entityTypes['CRM_Scheduledcaserecipients_DAO_ScheduledCaseStatuses'] = array(
//       'name' => 'ScheduledCaseStatuses',
//       'class' => 'CRM_Scheduledcaserecipients_DAO_ScheduledCaseStatuses',
//       'table' => 'civicrm_scheduledcasestatuses',
//     );
//   }
// }
