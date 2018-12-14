# Scheduled Reminder Case Recipients for CiviCRM #

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

## Installation ##

1. To allow use of case tokens, download and apply patch to CiviCRM:
   [civicrm-core-case-tokens.patch](civicrm-core-case-tokens.patch)
2. Download [an archive](https://github.com/agileware/au.com.agileware.scheduledcasecrecipients/archive/1.1.tar.gz)
   of the extension
3. Extract the contents of the extension archive into your CiviCRM Extensions
   Directory
4. Select the “Install” button from the Extensions page of your CiviCRM
   interface ( /civicrm/admin/extensions?reset=1 )


## Usage ##

When creating a new scheduled reminder for Activities:
 * Select ‘Case Role(s)’ for Recipients to direct the schedule reminder to a
   contact related to a case.
 * Use the two new fields ‘Case Types’ and ‘Case Status’ to conditionally send
   the schedule reminder according to the Type and Status of the Case it's filed
   against.
 * Insert the added tokens in your Email Subject and Body using the ‘Tokens’
   drop-down.
