<table>
    <tr id="caseRolesGroup" class="crm-scheduleReminder-form-block-case_roles_ids recipient" style="display: table-row;">
        <td class="label">{$form.case_roles.label}</td>
        <td>{$form.case_roles.html}</td>
    </tr>
</table>

{literal}
<script type="text/javascript">
    CRM.$(function($) {

        var isEntityActivity = false;

        var displayCaseRoles = {/literal}{if $display_case_roles}{$display_case_roles}{else}0{/if}{literal};
        $('#caseRolesGroup').insertAfter('#recipientList');

        function addCaseRolesOption() {
            if ($("#recipient option[value='caseroles']").length <= 0) {
                $("#recipient").append('<option value = "caseroles">Case Role(s)</option>');
            }

            var selectedCaseRoles = [];
            {/literal}
                {foreach from=$selected_case_roles item=selected_case_role}
                    {literal}
                        selectedCaseRoles.push({/literal}{$selected_case_role}{literal});
                    {/literal}
                {/foreach}
            {literal}

            if(displayCaseRoles) {
                $("#recipient").val('caseroles');
                $("#recipient").trigger('change');
                $('#case_roles').select2("val", selectedCaseRoles);
            }
        }

        $(document).ajaxComplete(function( event, xhr, settings ) {
            var m = settings.url.match(/civicrm\/ajax\/mapping(?=\/?[&?]).*[&?]mappingID=([0-9]+)/i)
            if(m) {
                isEntityActivity = (m[1] == '1');
                showOrHideCaseRoles();
            }
        });

        if ($("#recipient").val() != 'case_roles') {
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

        function showOrHideCaseRoles() {
            if(isEntityActivity || displayCaseRoles) {
                addCaseRolesOption();
            } else {
                $("#recipient").find("option[value='caseroles']").remove();
                $('#caseRolesGroup').hide();
            }
        }

    });
</script>
{/literal}