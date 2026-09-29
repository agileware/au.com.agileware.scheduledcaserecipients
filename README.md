# Scheduled Reminder Case Recipients (au.com.agileware.scheduledcaserecipients)

This is a [CiviCRM](https://civicrm.org) extension which extends **Scheduled Reminders**
(Administer / Communications / Scheduled Reminders) to support Activities filed against
**Cases**. It solves the problem of not being able to target a Scheduled Reminder at the
people involved in a Case (e.g. the Case Coordinator, Client, or other Case Role) or to
restrict a reminder to only fire for specific Case Types or Case Statuses.

Provides the following features for Scheduled Reminders where the entity is **Activities**:

* Send the reminder to particular **Case Role(s)** (e.g. Client, Case Coordinator) of the
  Case that the triggering Activity is filed against, instead of (or as well as) the
  standard recipient options.
* Restrict the reminder to only send for Activities filed against Cases with the selected
  **Case Type(s)**.
* Restrict the reminder to only send for Activities filed against Cases with the selected
  **Case Status(es)**.
* Adds tokens for use in the reminder's Subject/Body (requires a core patch, see
  [Special Configuration Requirements](#special-configuration-requirements) below):
  * `{case.id}` - the ID of the Case the Activity is filed against.
  * `{case.subject}` - the Subject of the Case the Activity is filed against.
  * `{activity.activity_target}` - the display name(s) of the Activity's Target contact(s).

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Usage

The extension adds new fields and options directly to the existing **Scheduled Reminders**
form, they only appear when the reminder's **Entity** is set to **Activities**:

1. Go to **Administer / Communications / Scheduled Reminders** and add or edit a reminder.
2. Set **Send this reminder for** to **Activities**.
3. Under **Recipients**, a new option **Case Role(s)** is added to the recipient type
   drop-down. Selecting it reveals a **Roles** field where you can pick one or more
   Relationship Types (e.g. Case Coordinator is Client of) - the reminder will be sent to
   the contact(s) who hold that role on the Case the triggering Activity is filed against.
4. Two additional fields, **Case Types** and **Case Status**, are shown for
   Activity-triggered reminders regardless of the recipient type chosen. Select one or
   more Case Types and/or Case Statuses to restrict the reminder so it is only sent when
   the Activity's Case matches. Leaving these blank means the reminder is not filtered by
   Case Type or Status.
5. If the core token patch (see below) is applied, insert `{case.id}`, `{case.subject}` or
   `{activity.activity_target}` into the reminder's Subject or Body using the **Insert
   Tokens** drop-down, in addition to the standard Activity/Contact tokens.

Internally, the extension stores the selected Case Roles, Case Types and Case Statuses for
each reminder using three private CiviCRM API v3 entities (`ScheduledCaseRecipient`,
`ScheduledCaseTypes`, `ScheduledCaseStatuses`). These are implementation details managed
automatically by the Scheduled Reminders form and are not intended to be used directly by
end users.

## Special Configuration Requirements

* **Core patch required for tokens** - The `{case.id}`, `{case.subject}` and
  `{activity.activity_target}` tokens rely on Case/Activity data being passed through to
  the mail-sending hook, which CiviCRM core does not do by default. To enable these
  tokens, a sysadmin/developer must download and apply
  [civicrm-core-case-tokens.patch](civicrm-core-case-tokens.patch) to the CiviCRM core
  codebase (patches `CRM/Core/BAO/ActionSchedule.php`). Without this patch, the Case Type
  and Case Status filtering and the `{activity.activity_target}` token will not function,
  and the `{case.id}`/`{case.subject}` tokens will not be replaced with real values.
* No settings page, API keys, or additional permissions are required for the rest of the
  extension's functionality (Case Role recipients). The standard CiviCRM permission to
  administer Scheduled Reminders (`administer CiviCRM`) applies as usual.
* No dependent extensions are required, only CiviCRM's built-in CiviCase and Scheduled
  Reminder functionality.

## Requirements

* CiviCRM 5.51+
* CiviCRM core patched with [civicrm-core-case-tokens.patch](civicrm-core-case-tokens.patch)
  (required only for token support, see above)

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin
Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/). After
installing, go to **Administer / System Settings / Extensions** and enable "Scheduled
Reminder Case Recipients (au.com.agileware.scheduledcaserecipients)".

# About the Authors

This CiviCRM extension was developed by the team at
[Agileware](https://agileware.com.au).

[Agileware](https://agileware.com.au) provide a range of CiviCRM
services including:

* CiviCRM migration
* CiviCRM integration
* CiviCRM extension development
* CiviCRM support
* CiviCRM hosting
* CiviCRM remote training services

Support your Australian [CiviCRM](https://civicrm.org) developers,
[contact Agileware](https://agileware.com.au/contact) today!

![Agileware](logo/agileware-logo.png)
