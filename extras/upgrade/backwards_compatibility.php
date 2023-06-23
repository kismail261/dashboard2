<?php

/********************************************************************
 * COPYRIGHT NOTICE:                                                *
 * This Source Code Form is copyrighted 2022 to SimpleRisk, Inc.    *
 ********************************************************************/

/********************************************************************
 * NOTES:                                                           *
 * This SimpleRisk Extra enables the ability of SimpleRisk to       *
 * automatically upgrade the application and database.              *
 ********************************************************************/

$app_version = current_version("app");

// Determine what to do based on the current application version
switch ($app_version)
{
	case "20181103-001":
		global $lang;
		$lang['BackupDatabaseButton'] = "Backup the Database";
		$lang['UpdateSuccessful'] = "Update Successful";
		$lang['UpdateFailed'] = "Update Failed";
		$function_display_upgrades = true;
		$function_display_upgrade_extras = true;
		$function_gather_extra_upgrades = false;
		$function_available_extras = false;
		$function_available_extra_short_names = false;
		$function_is_purchased = false;
		$function_extra_current_version = false;
		$function_is_installed = false;
		break;
	case "20190105-001":
		global $lang;
		$lang['BackupDatabaseButton'] = "Backup the Database";
		$lang['UpdateSuccessful'] = "Update Successful";
		$lang['UpdateFailed'] = "Update Failed";
		$function_display_upgrades = true;
		$function_display_upgrade_extras = true;
		$function_gather_extra_upgrades = false;
		$function_available_extras = false;
		$function_available_extra_short_names = false;
		$function_is_purchased = false;
		$function_extra_current_version = false;
		$function_is_installed = false;
		break;
	case "20190210-001":
		global $lang;
		$lang['BackupDatabaseButton'] = "Backup the Database";
		$lang['UpdateSuccessful'] = "Update Successful";
		$lang['UpdateFailed'] = "Update Failed";
		$function_display_upgrades = true;
		$function_display_upgrade_extras = true;
		$function_gather_extra_upgrades = false;
		$function_available_extras = false;
		$function_available_extra_short_names = false;
		$function_is_purchased = false;
		$function_extra_current_version = false;
		$function_is_installed = false;
		break;
	case "20190331-001":
		global $lang;
		$lang['BackupDatabaseButton'] = "Backup the Database";
		$lang['UpdateSuccessful'] = "Update Successful";
		$lang['UpdateFailed'] = "Update Failed";
		$function_display_upgrades = true;
		$function_display_upgrade_extras = true;
		$function_gather_extra_upgrades = false;
		$function_available_extras = false;
		$function_available_extra_short_names = false;
		$function_is_purchased = false;
		$function_extra_current_version = false;
		$function_is_installed = false;
		break;
	case "20190630-001":
		global $lang;
		$lang['BackupDatabaseButton'] = "Backup the Database";
		$lang['UpdateSuccessful'] = "Update Successful";
		$lang['UpdateFailed'] = "Update Failed";
		$function_display_upgrades = true;
		$function_display_upgrade_extras = true;
		$function_gather_extra_upgrades = false;
		$function_available_extras = false;
		$function_available_extra_short_names = false;
		$function_is_purchased = false;
		$function_extra_current_version = false;
		$function_is_installed = true;
		break;
	case "20190930-001":
		$function_display_upgrades = false;
		$function_display_upgrade_extras = true;
		$function_gather_extra_upgrades = true;
		$function_available_extras = true;
		$function_available_extra_short_names = true;
		$function_is_purchased = true;
		$function_extra_current_version = true;
		$function_is_installed = true;
		break;
	case "20191130-001":
		$function_display_upgrades = false;
		$function_display_upgrade_extras = true;
		$function_gather_extra_upgrades = true;
		$function_available_extras = true;
		$function_available_extra_short_names = true;
		$function_is_purchased = true;
		$function_extra_current_version = true;
		$function_is_installed = true;
		break;
	default:
		$function_display_upgrades = false;
		$function_display_upgrade_extras = false;
		$function_gather_extra_upgrades = false;
		$function_available_extras = false;
		$function_available_extra_short_names = false;
		$function_is_purchased = false;
		$function_extra_current_version = false;
		$function_is_installed = false;
		break;
}



if ($function_display_upgrade_extras && !function_exists("display_upgrade_extras"))
{
        function display_upgrade_extras()
        {
                global $escaper;
                global $lang;

                // Display the table header
                echo "<p><h4>SimpleRisk Extras</h4></p>\n";
                echo "<table width=\"100%\" class=\"table table-bordered table-condensed\">\n";
                echo "<tbody>\n";
		echo "<tr>\n";
		echo "  <td>The SimpleRisk Extras table will provide updated information once the SimpleRisk Core has been updated.</td>\n";
		echo "</tr>\n";
		echo "</tbody>\n";
		echo "</table>\n";
	}
}

if ($function_gather_extra_upgrades && !function_exists("gather_extra_upgrades"))
{
	function gather_extra_upgrades()
	{

		$available_extras = available_extra_short_names();

		$upgradeable = [];

		foreach($available_extras as $extra)
		{
			if (is_purchased($extra) && extra_current_version($extra) < latest_version($extra))
			{
				// Have to be upgraded    
				$upgradeable[] = $extra;
			}
		}
    
    		return $upgradeable;
	}
}

if ($function_available_extras && !function_exists("available_extras"))
{
	function available_extras()
	{
	        // The available SimpleRisk Extras
	        $extras = array(
	                array("short_name" => "upgrade", "long_name" => "Upgrade Extra"),
	                array("short_name" => "authentication", "long_name" => "Custom Authentication Extra"),
	                array("short_name" => "encryption", "long_name" => "Encrypted Database Extra"),
	                array("short_name" => "import-export", "long_name" => "Import-Export Extra"),
	                array("short_name" => "notification", "long_name" => "Email Notification Extra"),
	                array("short_name" => "separation", "long_name" => "Team-Based Separation Extra"),
	                array("short_name" => "assessments", "long_name" => "Risk Assessment Extra"),
	                array("short_name" => "api", "long_name" => "API Extra"),
	                array("short_name" => "complianceforgescf", "long_name" => "ComplianceForge SCF Extra"),
	                array("short_name" => "customization", "long_name" => "Customization Extra"),
	                array("short_name" => "advanced_search", "long_name" => "Advanced Search Extra"),
	                array("short_name" => "jira", "long_name" => "Jira Extra"),
	                array("short_name" => "ucf", "long_name" => "Unified Compliance Framework (UCF) Extra"),
	                array("short_name" => "vulnmgmt", "long_name" => "Vulnerability Management Extra")
	        );

	        // Return the array of available Extras
	        return $extras;
	}
}

if ($function_available_extra_short_names && !function_exists("available_extra_short_names"))
{
	function available_extra_short_names()
	{
	        // Get the list of available extras
	        $extras = available_extras();

	        // Get the values from the short_name column
	        $extra_short_names = array_column($extras, "short_name");

	        // Return the list of short name values
	        return $extra_short_names;
	}
}

if ($function_is_purchased && !function_exists("is_purchased"))
{
        function is_purchased($extra)
	{
	    //They're purchased by default
	    if (in_array($extra, ['upgrade', 'complianceforgescf']))
	        return true;

	    if (!empty($GLOBALS['purchased_extras'])) {
	        if (in_array($extra, $GLOBALS['purchased_extras'])) {
	            return true;
	        }
	    } else {
	        $GLOBALS['purchased_extras'] = [];
	    }

	    // Get the instance identifier
	    $instance_id = get_setting("instance_id");

	    // Get the services API key
	    $services_api_key = get_setting("services_api_key");

	    // Create the data to send
	    $parameters = array(
	        'action' => 'check_purchase',
	        'instance_id' => $instance_id,
	        'api_key' => $services_api_key,
	        'extra_name' => $extra,
	    );

	    // Ask the service if the extra is purchased
	    $response = simplerisk_service_call($parameters);
		$return_code = $response['return_code'];

		// If the SimpleRisk service call returned false
		if ($return_code !== 200)
		{
			write_debug_log("Unable to communicate with the SimpleRisk services API");

			// Return false
			return false;
		}
		// If we have valid results from the service call
		else
		{
			$results = $response['response'];
			$results = array($results);
			$regex_pattern = "/<result>1<\/result>/";

	    	foreach ($results as $line)
			{
				// If the service returned a success
				if (preg_match($regex_pattern, $line, $matches)) {
					$GLOBALS['purchased_extras'][] = $extra;
					return true;
				} else return false;
			}
	    }
	}
}

if ($function_extra_current_version && !function_exists("extra_current_version"))
{
	function extra_current_version($extra)
	{
		// Get the list of available extra names
		$available_extras = available_extra_short_names();

		// If the provided extra name is not in the list of available extras
		if (!in_array($extra, $available_extras))
		{
			return "N/A";
		}
		// The provided extra name is in the list of available extras
		else
		{
			// Get the path to the extra
			$path = realpath(__DIR__ . "/../extras/$extra/index.php");

			// If the extra is installed
			if (file_exists($path))
			{
				// Include the extra
				require_once($path);

				// Return the extra version
				switch ($extra) {
                                        case "advanced_search":
                                                return ADVANCED_SEARCH_EXTRA_VERSION;
                                        case "api":
                                                return API_EXTRA_VERSION;
                                        case "assessments":
                                                return ASSESSMENTS_EXTRA_VERSION;
                                        case "authentication":
                                                return AUTHENTICATION_EXTRA_VERSION;
                                        case "complianceforgescf":
                                                return COMPLIANCEFORGE_SCF_EXTRA_VERSION;
                                        case "customization":
                                                return CUSTOMIZATION_EXTRA_VERSION;
                                        case "encryption":
                                                return ENCRYPTION_EXTRA_VERSION;
                                        case "import-export":
                                                return IMPORTEXPORT_EXTRA_VERSION;
                                        case "jira":
                                                return JIRA_EXTRA_VERSION;
                                        case "notification":
                                                return NOTIFICATION_EXTRA_VERSION;
                                        case "separation":
                                                return SEPARATION_EXTRA_VERSION;
                                        case "ucf":
                                                return UCF_EXTRA_VERSION;
					case "upgrade":
						return UPGRADE_EXTRA_VERSION;
					default:
						return "N/A";
				}
			}
			else return "N/A";
		}
	}
}

if ($function_display_upgrades && !function_exists("display_upgrades"))
{
	function display_upgrades()
	{
		global $escaper;
		global $lang;

		echo $escaper->escapeHtml($lang['UpgradeInstructions']);
		echo "<br />\n";

		// If the application is updated, but the database does not match
		if (!is_upgrade_needed() && is_db_upgrade_needed())
		{
			echo "<form name=\"upgrade_simplerisk\" method=\"post\" action=\"".$_SESSION['base_url']."/extras/upgrade/index.php\" target=\"_blank\">\n";
			echo "<b><u>Step 1</u></b><br />\n";
			echo "<input type=\"submit\" name=\"backup\" id=\"backup\" value=\"" . $escaper->escapeHtml($lang['BackupDatabase']) . "\" />\n";
			echo "</form>";
			echo "<form name=\"upgrade_simplerisk\" method=\"get\" action=\"".$_SESSION['base_url']."/admin/upgrade.php\" target=\"_blank\">\n";
			echo "<b><u>Step 2</u></b><br />\n";
			echo "<input type=\"submit\" name=\"db_upgrade\" id=\"db_upgrade\" value=\"" . $escaper->escapeHtml($lang['UpgradeDatabase']) . "\" />\n";
			echo "</form>\n";
		}
		// If an upgrade is not needed
		else if (!is_upgrade_needed())
		{
			echo "<br /><p><font color=\"green\"><b>" . $escaper->escapeHtml($lang['NoUpgradeNeeded']) . "</b></font></p><br />\n";
			echo "<form name=\"upgrade_simplerisk\" method=\"post\" action=\"".$_SESSION['base_url']."/extras/upgrade/index.php\" target=\"_blank\">\n";
			echo "<input type=\"submit\" name=\"backup\" id=\"backup\" value=\"" . $escaper->escapeHtml($lang['BackupDatabase']) . "\" />\n";
			echo "</form>\n";
		}
		// An upgrade is needed
		else
		{
			echo "<form name=\"upgrade_simplerisk\" method=\"post\" action=\"".$_SESSION['base_url']."/extras/upgrade/index.php\" target=\"_blank\" style='margin-bottom: 0px'>\n";
			echo "<b><u>Step 1</u></b><br />\n";
			echo "<input type=\"submit\" name=\"backup\" id=\"backup\" value=\"" . $escaper->escapeHtml($lang['BackupDatabase']) . "\" />\n";
			echo "<br />\n";
			echo "<b><u>Step 2</u></b><br />\n";
			echo "<input type=\"submit\" name=\"app_upgrade\" id=\"app_upgrade\" value=\"" . $escaper->escapeHtml($lang['UpgradeApplication']) . "\" />\n";
			echo "</form>";
			echo "<form name=\"upgrade_simplerisk\" method=\"get\" action=\"".$_SESSION['base_url']."/admin/upgrade.php\" target=\"_blank\">\n";
			echo "<b><u>Step 3</u></b><br />\n";
			echo "<input type=\"submit\" name=\"db_upgrade\" id=\"db_upgrade\" value=\"" . $escaper->escapeHtml($lang['UpgradeDatabase']) . "\" />\n";
			echo "</form>\n";
		}
	}
}
else
{
	function display_upgrades()
	{
		new_display_upgrades();
	}
}

if ($function_is_installed && !function_exists("is_installed"))
{
	function is_installed($extra_name)
	{
                // Check the Extra Name
                switch ($extra_name)
                {
                        case "upgrade":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/upgrade/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "complianceforgescf":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/complianceforgescf/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "authentication":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/authentication/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "encryption":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/encryption/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "import-export":
                            // If the extra exists
                           if (file_exists(realpath(__DIR__ . '/../extras/import-export/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "notification":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/notification/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "separation":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/separation/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "assessments":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/assessments/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "api":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/api/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "customization":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/customization/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "advanced_search":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/advanced_search/index.php')))
                            {
                                // Return true
                                return true;
                            }
                        case "jira":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/jira/index.php')))
                            {   
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        case "ucf":
                            // If the extra exists
                            if (file_exists(realpath(__DIR__ . '/../extras/ucf/index.php')))
                            {
                                // Return true
                                return true;
                            }
                            // Otherwise, return false
                            else return false;
                        default:
                            return false;
		}
	}
}

?>
