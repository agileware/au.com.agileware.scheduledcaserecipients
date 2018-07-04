<table>
    <tr id="caseRolesGroup" class="crm-scheduleReminder-form-block-case_roles_ids recipient" style="display: table-row;">
        <td class="label">{$form.case_roles.label}</td>
        <td>{$form.case_roles.html}</td>
    </tr>
    <tr id="caseTypesGroup" class="crm-scheduleReminder-form-block-case_types_ids recipient" style="display: table-row;">
        <td class="label">{$form.case_types.label}</td>
        <td>{$form.case_types.html}</td>
    </tr>
    <tr id="caseStatusesGroup" class="crm-scheduleReminder-form-block-case_statuses_ids recipient" style="display: table-row;">
        <td class="label">{$form.case_statuses.label}</td>
        <td>{$form.case_statuses.html}</td>
    </tr>
</table>

{literal}
<script type="text/javascript">
    CRM.$(function($) {

        // Use global object for assignements from smarty, to prevent closure based duplication
        CRM.scheduledCaseRecipients = {
            isEntityActivity: false,
            displayCaseRoles: {/literal}{if $display_case_roles}{$display_case_roles}{else}0{/if}{literal},
            displayCaseTypes: {/literal}{if $display_case_types}{$display_case_types}{else}0{/if}{literal},
            displayCaseStatuses: {/literal}{if $display_case_statuses}{$display_case_statuses}{else}0{/if}{literal},
            selectedCaseTypes: [{/literal} {foreach from=$selected_case_types item=selected_case_types}
                {$selected_case_types},
            {/foreach} {literal}],
            selectedCaseStatuses: [{/literal} {foreach from=$selected_case_statuses item=selected_case_status}
                {$selected_case_status},
            {/foreach} {literal}],
            selectedCaseRoles: [{/literal} {foreach from=$selected_case_roles item=selected_case_role}
                {$selected_case_role},
            {/foreach} {literal}],
        }

        var C = CRM.scheduledCaseRecipients;

        $('#caseRolesGroup').insertAfter('#recipientList');
        $('#caseTypesGroup').insertBefore('.crm-scheduleReminder-form-block-when');
        $('#caseStatusesGroup').insertBefore('.crm-scheduleReminder-form-block-when');

        function addCaseTypesOption() {
            if(C.displayCaseTypes) {
                $('#case_types').select2("val", C.selectedCaseTypes);
            }
        }

        function addCaseStatusesOption() {
            if(C.displayCaseStatuses) {
                $('#case_statuses').select2("val", C.selectedCaseStatuses);
            }
        }

        function addCaseRolesOption() {
            if ($("#recipient option[value='caseroles']").length <= 0) {
                $("#recipient").append('<option value = "caseroles">Case Role(s)</option>');
            }

            if(C.displayCaseRoles) {
                $("#recipient").val('caseroles');
                $("#recipient").trigger('change');
                $('#case_roles').select2("val", C.selectedCaseRoles);
            }
        }

        // Guard ajax completion callback so that that it's only added once.
        if (!('scheduledCaseRecipients-ajax' in CRM)) {
            $(document).ajaxComplete(function( event, xhr, settings ) {
                var m = settings.url.match(/civicrm\/ajax\/mapping(?=\/?[&?]).*[&?]mappingID=([0-9]+)/i)
                if(m) {
                    C.isEntityActivity = (m[1] == '1');
                    showOrHideCaseRoles();
                    showOrHideCaseTypes();
                    showOrHideCaseStatuses();
                }
            });

            CRM['scheduledCaseRecipients-ajax'] = 1;
        }

        if ($("#recipient").val() != 'caseroles') {
            $('#caseRolesGroup').hide();
        }
        else {
            $('#caseRolesGroup').show();
        }

        $('#recipient').change(function() {
            if ($(this).val() == 'caseroles') {
                $('#caseRolesGroup').show();
            }
            else {
                $('#caseRolesGroup').hide();
            }
        });

        function showOrHideCaseTypes() {
            if(C.isEntityActivity || C.displayCaseRoles) {
                $('#caseTypesGroup').show();
                addCaseTypesOption();
            } else {
                $('#caseTypesGroup').hide();
            }
        }

        function showOrHideCaseRoles() {
            if(C.isEntityActivity || C.displayCaseRoles) {
                addCaseRolesOption();
            } else {
                $("#recipient").find("option[value='caseroles']").remove();
                $('#caseRolesGroup').hide();
            }
        }

        function showOrHideCaseStatuses() {
            if(C.isEntityActivity) {
                $('#caseStatusesGroup').show();
                if(C.displayCaseStatuses) {
                    addCaseStatusesOption();
                }
            } else {
                $('#caseStatusesGroup').hide();
            }
        }

    });
</script>
{/literal}