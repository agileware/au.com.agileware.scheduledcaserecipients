au.com.agileware.scheduledcaserecipients
------

CiviCRM extension to extend Scheduled Reminders to provide ability to send the reminder to particular roles of the Case an Activity is filed against; send a scheduled reminder for Activities filed against Cases with the selected Types & Statuses

This extends the Scheduled Reminder configuration in CiviCRM, adding case
related configuration: 

 * **Set _Case Role(s)_ as recipients** :- send the reminder to particular roles
   of the Case an Activity is filed against.
 * **Filter Activities by _Case Types_ and _Case Statuses_** :- only send a
   scheduled reminder for activities filed against cases with the selected Types
   & Statuses 
 * Adds tokens to the Scheduled reminder (requires patch to CiviCRM):
     * `{case.id}`
     * `{case.subject}`

Installation
------

1. To allow use of case tokens, download and apply patch to CiviCRM:
   [civicrm-core-case-tokens.patch](civicrm-core-case-tokens.patch)
1. Download the [latest version of this extension](https://github.com/agileware/au.com.agileware.scheduledcaserecipients/archive/master.zip)
1. Unzip in the CiviCRM extension directory, as defined in 'System Settings / Directories'.
1. Go to "Administer / System Settings / Extensions" and enable the "Scheduled Reminder Case Recipients (au.com.agileware.scheduledcaserecipients)" extension.

Usage
------

When creating a new scheduled reminder for Activities:
 * Select ‘Case Role(s)’ for Recipients to direct the schedule reminder to a
   contact related to a case.
 * Use the two new fields ‘Case Types’ and ‘Case Status’ to conditionally send
   the schedule reminder according to the Type and Status of the Case it's filed
   against.
 * Insert the added tokens in your Email Subject and Body using the ‘Tokens’
   drop-down.

About the Authors
------

This CiviCRM extension was developed by the team at [Agileware](https://agileware.com.au).

[Agileware](https://agileware.com.au) provide a range of CiviCRM services including:

  * CiviCRM migration
  * CiviCRM integration
  * CiviCRM extension development
  * CiviCRM support
  * CiviCRM hosting
  * CiviCRM remote training services

Support your Australian [CiviCRM](https://civicrm.org) developers, [contact Agileware](https://agileware.com.au/contact) today!


![Agileware](logo/agileware-logo.png)  
