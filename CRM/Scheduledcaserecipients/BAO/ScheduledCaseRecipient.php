<?php
use CRM_Scheduledcaserecipients_ExtensionUtil as E;

class CRM_Scheduledcaserecipients_BAO_ScheduledCaseRecipient extends CRM_Scheduledcaserecipients_DAO_ScheduledCaseRecipient {
  public static function findEmailsByCaseRoles($scheduledcaseroleids, $caseid) {
    $contactIds = civicrm_api3("Relationship", "get", array(
      "case_id"                => $caseid,
      "relationship_type_id"   => array("IN" => $scheduledcaseroleids),
      "return"                 => array("contact_id_b"),
      "sequential"             => TRUE,
    ));
    $contactIds = array_column($contactIds["values"], "contact_id_b");
    $contactIds = array_unique($contactIds);

    $contactEmails = civicrm_api3("Email", "get", array(
      "contact_id" => array("IN" => $contactIds),
      "is_primary" => TRUE,
    ));

    $contactEmails = array_column($contactEmails["values"], "email");
    return $contactEmails;
  }

}
