<?php
use CRM_Scheduledcaserecipients_ExtensionUtil as E;

class CRM_Scheduledcaserecipients_BAO_ScheduledCaseTypes extends CRM_Scheduledcaserecipients_DAO_ScheduledCaseTypes {

  /**
   * Create a new ScheduledCaseTypes based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Scheduledcaserecipients_DAO_ScheduledCaseTypes|NULL
   *
  public static function create($params) {
    $className = 'CRM_Scheduledcaserecipients_DAO_ScheduledCaseTypes';
    $entityName = 'ScheduledCaseTypes';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
