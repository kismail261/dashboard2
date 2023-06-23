<?php

/********************************************************************
 * COPYRIGHT NOTICE:                                                *
 * This Source Code Form is copyrighted 2022 to SimpleRisk, Inc and *
 * cannot be used or duplicated without express written permission. *
 ********************************************************************/

// Include the required files
require_once(realpath(__DIR__ . '/../../../includes/functions.php'));
require_once(realpath(__DIR__ . '/../../../includes/services.php'));
require_once(realpath(__DIR__ . '/../../../includes/upgrade.php'));
require_once(realpath(__DIR__ . '/../index.php'));

/********************************
 * FUNCTION: GET UPGRADE ROUTES *
 ********************************/
function get_upgrade_routes() {

    // These functionalities can only be called by an admin, so if the user isn't an admin these routes aren't even registered
    if (is_admin()) {
    	// Call /api/upgrade/version to get the version of the API Extra
        getRoute()->get('/upgrade/version', 'api_version_upgrade');

        // Call /api/upgrade/version/app to get the version of the SimpleRisk application
        getRoute()->get('/upgrade/version/app', 'api_version_simplerisk_app');

    	// Call /api/upgrade/upgrade/app to upgrade the Upgrade Extra
        getRoute()->get('/upgrade/upgrade/app', 'api_upgrade_app_upgrade');
    
    	// Call /api/upgrade/backup/app to backup the SimpleRisk application files
    	getRoute()->get('/upgrade/backup/app', 'api_backup_simplerisk_app');
    
    	// Call /api/upgrade/backup/db to backup the SimpleRisk database
    	getRoute()->get('/upgrade/backup/db', 'api_backup_simplerisk_db');
    
    	// Call /api/upgrade/upgrade/simplerisk/app to upgrade the SimpleRisk Core application files
    	getRoute()->get('/upgrade/upgrade/simplerisk/app', 'api_upgrade_simplerisk_app');
    
    	// Call /api/upgrade/upgrade/simplerisk/db to upgrade the SimpleRisk Core database
    	getRoute()->get('/upgrade/upgrade/simplerisk/db', 'api_upgrade_simplerisk_db');

    	// Routes for the app upgrades of other extras
    	getRoute()->get('/advanced_search/upgrade/app', 'api_upgrade_app_advanced_search');
    	getRoute()->get('/api/upgrade/app', 'api_upgrade_app_api');
    	getRoute()->get('/assessments/upgrade/app', 'api_upgrade_app_assessments');
    	getRoute()->get('/authentication/upgrade/app', 'api_upgrade_app_authentication');
    	getRoute()->get('/complianceforgescf/upgrade/app', 'api_upgrade_app_complianceforge_scf');
    	getRoute()->get('/customization/upgrade/app', 'api_upgrade_app_customization');
    	getRoute()->get('/encryption/upgrade/app', 'api_upgrade_app_encryption');
    	getRoute()->get('/import-export/upgrade/app', 'api_upgrade_app_import_export');
    	getRoute()->get('/incident_management/upgrade/app', 'api_upgrade_app_incident_management');
    	getRoute()->get('/jira/upgrade/app', 'api_upgrade_app_jira');
    	getRoute()->get('/notification/upgrade/app', 'api_upgrade_app_notification');
    	getRoute()->get('/organizational_hierarchy/upgrade/app', 'api_upgrade_app_organizational_hierarchy');
        getRoute()->get('/separation/upgrade/app', 'api_upgrade_app_separation');
        getRoute()->get('/vulnmgmt/upgrade/app', 'api_upgrade_app_vulnmgmt');
    	getRoute()->get('/ucf/upgrade/app', 'api_upgrade_app_ucf');
    }
}

/*********************************
 * FUNCTION: API VERSION UPGRADE *
 *********************************/
function api_version_upgrade() {
    json_response(200, "Extra Version Information", array("version" => UPGRADE_EXTRA_VERSION));
}

/************************************************
 * FUNCTION: API VERSION SIMPLERISK APPLICATION *
 ************************************************/
function api_version_simplerisk_app() {
    require_once(realpath(__DIR__ . '/../../../includes/version.php'));
    json_response(200, "SimpleRisk Application Version Information", array("version" => APP_VERSION));
}

/*********************************************
 * FUNCTION: API UPGRADE APP ADVANCED SEARCH *
 *********************************************/
function api_upgrade_app_advanced_search() {
    api_download_extra('advanced_search');
}

/*********************************
 * FUNCTION: API UPGRADE APP API *
 *********************************/
function api_upgrade_app_api() {
    api_download_extra('api');
}

/*****************************************
 * FUNCTION: API UPGRADE APP ASSESSMENTS *
 *****************************************/
function api_upgrade_app_assessments() {
    api_download_extra('assessments');
}

/********************************************
 * FUNCTION: API UPGRADE APP AUTHENTICATION *
 ********************************************/
function api_upgrade_app_authentication() {
    api_download_extra('authentication');
}

/*************************************************
 * FUNCTION: API UPGRADE APP COMPLIANCEFORGE SCF *
 *************************************************/
function api_upgrade_app_complianceforge_scf() {
    api_download_extra('complianceforgescf');
}

/*******************************************
 * FUNCTION: API UPGRADE APP CUSTOMIZATION *
 *******************************************/
function api_upgrade_app_customization() {
    api_download_extra('customization');
}

/****************************************
 * FUNCTION: API UPGRADE APP ENCRYPTION *
 ****************************************/
function api_upgrade_app_encryption() {
    api_download_extra('encryption');
}

/*******************************************
 * FUNCTION: API UPGRADE APP IMPORT EXPORT *
 *******************************************/
function api_upgrade_app_import_export() {
    api_download_extra('import-export');
}

/*************************************************
 * FUNCTION: API UPGRADE APP INCIDENT MANAGEMENT *
 *************************************************/
function api_upgrade_app_incident_management() {
    api_download_extra('incident_management');
}

/**********************************
 * FUNCTION: API UPGRADE APP JIRA *
 **********************************/
function api_upgrade_app_jira() {
    api_download_extra('jira');
}

/******************************************
 * FUNCTION: API UPGRADE APP NOTIFICATION *
 ******************************************/
function api_upgrade_app_notification() {
    api_download_extra('notification');
}

/*******************************************
 * FUNCTION: API UPGRADE APP ORG HIERARCHY *
 *******************************************/
function api_upgrade_app_organizational_hierarchy() {
    api_download_extra('organizational_hierarchy');
}

/****************************************
 * FUNCTION: API UPGRADE APP SEPARATION *
 ****************************************/
function api_upgrade_app_separation() {
    api_download_extra('separation');
}

/******************************************************
 * FUNCTION: API UPGRADE APP Vulnerability Management *
 ******************************************************/
function api_upgrade_app_vulnmgmt() {
    api_download_extra('vulnmgmt');
}

/*********************************
 * FUNCTION: API UPGRADE APP UCF *
 *********************************/
function api_upgrade_app_ucf() {
    api_download_extra('ucf');
}

/*************************************
 * FUNCTION: API UPGRADE APP UPGRADE *
 *************************************/
function api_upgrade_app_upgrade() {
    api_download_extra('upgrade');
}

/***************************************
 * FUNCTION: API BACKUP SIMPLERISK APP *
 ***************************************/
function api_backup_simplerisk_app()
{
	global $lang;

	$source = $simplerisk_dir = realpath(__DIR__) . '/../../../';
	$timestamp = date("Ymd-His");
	$target_dir_root = sys_get_temp_dir() . '/simplerisk-backup/';
	$target_dir_app = $target_dir_root . '/app/';
	$target_dir_simplerisk = $target_dir_root . '/app/simplerisk';
	$target_tar_simplerisk = $target_dir_root . '/app/simplerisk-' . $timestamp . '.tar';
	$target_tar_gz_simplerisk = $target_dir_root . '/app/simplerisk-' . $timestamp . '.tar.gz';
	$target_tgz_simplerisk = $target_dir_root . '/app/simplerisk-' . $timestamp . '.tgz';

	// If the root backup directory does not exist
	if (!is_dir($target_dir_root))
	{
		// If the temp directory is not writeable
		if (!is_writeable(sys_get_temp_dir()))
		{
			// Return a json 403 response
			$message = _lang('BackupDirectoryNotWriteable', array('location' => sys_get_temp_dir()), false);
			$data = array( 
				'path' => sys_get_temp_dir(),
			);
			json_response(403, $message, $data);
		}

		// If the root directory structure can not be created
		if (!mkdir($target_dir_root))
		{
			// Return a json 403 response
			$message = _lang('BackupFailedToCreateDirectories', array('location' => $target_dir_root), false);
			$data = array(
				'path' => $target_dir_root,
			);
			json_response(403, $message, $data);
		}
	}

    // If the app backup directory does not exist
    if (!is_dir($target_dir_app))
    {       
        // If the root directory is not writeable
        if (!is_writeable($target_dir_root))
        {       
            // Return a json 403 response
        	$message = _lang('BackupDirectoryNotWriteable', array('location' => $target_dir_root), false);
        	$data = array(
        		'path' => $target_dir_root,
        	);
        	json_response(403, $message, $data);
        }
        
        // If the app directory structure can not be created 
        if (!mkdir($target_dir_app))
        {       
            // Return a json 403 response
        	$message = _lang('BackupFailedToCreateDirectories', array('location' => $target_dir_app), false);
        	$data = array(
        		'path' => $target_dir_app,
        	);
        	json_response(403, $message, $data);
        }
    }

    // If the simplerisk backup directory does not exist
    if (!is_dir($target_dir_simplerisk))
    {       
        // If the app directory is not writeable
        if (!is_writeable($target_dir_app))
        {       
            // Return a json 403 response
			$message = _lang('BackupDirectoryNotWriteable', array('location' => $target_dir_app), false);
			$data = array(
				'path' => $target_dir_app,
			);
			json_response(403, $message, $data);
        }
        
        // If the simplerisk directory structure can not be created 
        if (!mkdir($target_dir_simplerisk))
        {       
            // Return a json 403 response
			$message = _lang('BackupFailedToCreateDirectories', array('location' => $target_dir_simplerisk), false);
			$data = array(
				'path' => $target_dir_simplerisk,
			);
			json_response(403, $message, $data);
        }
    }

	// Copy the application files over
	$copy_success = recurse_copy($source, $target_dir_simplerisk);

	// If the copy was successful
	if ($copy_success)
	{
		// Try to compress the directory
		try
		{
			// Create the tar file
			$a = new PharData($target_tar_simplerisk);

			// Add the directory to the tar file
			$a->buildFromDirectory($target_dir_simplerisk);

			// Compress the tar file
			$a->compress(Phar::GZ);

			// Rename from .tar.gz to .tgz
			rename($target_tar_gz_simplerisk, $target_tgz_simplerisk);

			// Remove the simplerisk backup directory
			delete_dir($target_dir_simplerisk);

			// Remove the tar file
			unlink($target_tar_simplerisk);
		}
		catch (Exception $e)
		{
			$message = "There was an error creating the tgz file backup.";
			$data = array(
				'path' => $target_tar_simplerisk,
			);
			json_response(403, $message, $data);
		}

		// If the tgz file was created successfully
		if (file_exists($target_tgz_simplerisk) && filesize($target_tgz_simplerisk) > 0)
		{
			$message = "SimpleRisk application files backed up successfully to " . $target_tgz_simplerisk;
			$data = array(
				'path' => $target_dir_app,
				'file' => 'simplerisk-' . $timestamp . '.tgz',
			);
			json_response(200, $message, $data);
		}
		else
		{
			$message = "The SimpleRisk application back up process completed, but the tgz file does not exist.";
			$data = array(
				'path' => $target_dir_app,
				'file' => 'simplerisk-' . $timestamp . '.tgz',
			);
			json_response(403, $message, $data);
		}
	}
	// If the copy was not successful
	else {
		$message = "There was an error backing up the SimpleRisk application files.";
		$data = array(
			'path' => $target_dir_simplerisk,
		);
		json_response(403, $message, $data);
	}
}

/**************************************
 * FUNCTION: API BACKUP SIMPLERISK DB *
 **************************************/
function api_backup_simplerisk_db() {

    $timestamp = date("Ymd-His");
    $target_dir_root = sys_get_temp_dir() . '/simplerisk-backup/';
    $target_dir_db = $target_dir_root . '/db/';

    // If the root backup directory does not exist
    if (!is_dir($target_dir_root)) {
        // If the temp directory is not writeable
        if (!is_writeable(sys_get_temp_dir())) {
            // Return a json 403 response
    		$message = _lang('BackupDirectoryNotWriteable', array('location' => sys_get_temp_dir()), false);
    		$data = array(
    			'path' => sys_get_temp_dir(),
    		);
    		json_response(403, $message, $data);
        }

        // If the root directory structure can not be created
        if (!mkdir($target_dir_root)) {
            // Return a json 403 response
        	$message = _lang('BackupFailedToCreateDirectories', array('location' => $target_dir_root), false);
        	$data = array( 
        		'path' => $target_dir_root,
        	);
        	json_response(403, $message, $data);
        }
    }

    // If the db backup directory does not exist
    if (!is_dir($target_dir_db)) {
        // If the root directory is not writeable
        if (!is_writeable($target_dir_root)) {
            // Return a json 403 response
    		$message = _lang('BackupDirectoryNotWriteable', array('location' => $target_dir_root), false);
    		$data = array(
    			'path' => $target_dir_root,
    		);
    		json_response(403, $message, $data);
        }

        // If the db directory structure can not be created 
        if (!mkdir($target_dir_db)) {
            // Return a json 403 response
    		$message = _lang('BackupFailedToCreateDirectories', array('location' => $target_dir_db), false);
    		$data = array(
    			'path' => $target_dir_db,
    		);
    		json_response(403, $message, $data);
        }
    }

    // If a mysqldump service does not exist
    if(!is_process('mysqldump')) {
    	// Load the path from the SimpleRisk database
    	$mysqldump_path = get_setting('mysqldump_path');
    }
    // Otherwise use the defined service
    else $mysqldump_path = "mysqldump";
    
    // Path to the database backup file
    $db_backup_file = $target_dir_db . '/simplerisk-' . $timestamp . '.sql';

	// Get the mysqldump command
	$cmd = upgrade_get_mysqldump_command();

	// Add the output redirect to the mysqldump command
	$db_backup_cmd = $cmd . ' > ' . escapeshellarg($db_backup_file);

    // Backup the database
    $mysqldump = system($db_backup_cmd);
    
    // If the backup file exists and the size is not zero
    if (file_exists($db_backup_file) && filesize($db_backup_file) > 0) {
    	$message = "SimpleRisk database files backed up successfully to " . $db_backup_file;
    	$data = array(
    		'path' => $target_dir_db,
    		'file' => 'simplerisk-' . $timestamp . '.sql',
    	);
    	json_response(200, $message, $data);
    } else {
        json_response(403, "There was an error backing up the SimpleRisk database files.");
    }
}

/****************************************
 * FUNCTION: API UPGRADE SIMPLERISK APP *
 ****************************************/
function api_upgrade_simplerisk_app()
{
    // Doing a pre-upgrade check to prevent starting an upgrade that might fail
    do_pre_upgrade_check();

    // Get the latest application version
	$latest_version = latest_version("app");

	// Get the current application version
	$current_version = current_version("app");

	// Get the next application version
	$next_version = next_version($current_version);

	// If the current version is not the latest
	if ($current_version != $latest_version)
	{
		// If a version was specified through the API query
		if (isset($_GET['version']))
		{
			// Get the version information
			$version = $_GET['version'];

			// If the version provided is formatted as expected (YYYYMMDD-XXX)
			if (preg_match('/^\d{8}-\d{3}$/', $version))
			{
				// Use that as the version to upgrade to
				$file_name = "simplerisk-" . $version;
			}
			// The version provided was not formatted properly
			else
			{
				$message = "The provided version was not properly formatted as YYYYMMDD-XXX.";
				$data = array(
					'latest_version' => $latest_version,
					'current_version' => $current_version,
					'next_version' => $next_version,
				);
				json_response(403, $message, $data);
			}
		}
		// Otherwise upgrade to the latest release
		else $file_name = "simplerisk-" . $latest_version;

		// If the tgz file already exists in the temporary directory
		if (file_exists(sys_get_temp_dir() . "/" . $file_name . ".tgz"))
		{
			try
			{
				// Remove the file
				unlink(sys_get_temp_dir() . "/" . $file_name . ".tgz");
			}
			catch(Exception $e)
			{
				$message = "Unable to remove file located at " . sys_get_temp_dir() . "/" . $file_name . ".tgz";
				$data = array(
					'path' => sys_get_temp_dir(),
					'file' => $file_name . ".tgz",
				);
				json_response(403, $message, $data);
			}
		}

		// If the tar file already exists in the temporary directory
		if (file_exists(sys_get_temp_dir() . "/" . $file_name . ".tar"))
		{
	        try
	        {
                // Remove the file
                unlink(sys_get_temp_dir() . "/" . $file_name . ".tar");
	        }
	        catch(Exception $e)
	        {
                $message = "Unable to remove file located at " . sys_get_temp_dir() . "/" . $file_name . ".tar";
                $data = array(
                    'path' => sys_get_temp_dir(),
                    'file' => $file_name . ".tar",
                );
                json_response(403, $message, $data);
	        }
		}

		// If the config.php file already exists in the temporary directory
		if (file_exists(sys_get_temp_dir() . "/config.php"))
		{
	        	try
	        	{
                		// Remove the file
	            		unlink(sys_get_temp_dir() . "/config.php");
	        	}
	        	catch(Exception $e)
	        	{
                		$message = "Unable to remove file located at " . sys_get_temp_dir() . "/config.php";
                		$data = array(
                    			'path' => sys_get_temp_dir(),
                    			'file' => "config.php",
                		);
    	        		json_response(403, $message, $data);
        		}
		}

		// Configure the proxy server if one exists
		if (function_exists("set_proxy_stream_context"))
		{
			// Configuration for the download request
			$method = "GET";
			$header = "Content-Type: application/x-www-form-urlencoded";
			$context = set_proxy_stream_context($method, $header);
		}

		// If the bundles URL is defined
		if (defined('BUNDLES_URL')) {

		    // Get today's date
		    $today = date("Ymd");

		    // Get the full bundle URL
		    $bundle_url = BUNDLES_URL . "/simplerisk-" . $today . "-001.tgz";
		}
		// Download the new release file to the temporary directory
		else $bundle_url = "https://github.com/simplerisk/bundles/raw/master/" . $file_name . ".tgz";
			
		file_put_contents(sys_get_temp_dir() . "/" . $file_name . ".tgz", fopen($bundle_url, 'r', false, $context));

		// If the file was not downloaded successfully
		if (!file_exists(sys_get_temp_dir() . "/" . $file_name . ".tgz"))
		{
			$message = "Unable to download file from " . $bundle_url . " to " . sys_get_temp_dir() . "/" . $file_name . ".tgz";
			$data = array(
				'source' => $bundle_url,
				'destination' => sys_get_temp_dir() . "/" . $file_name . ".tgz",
			);
			json_response(403, $message, $data);
		}

		// Path to the simplerisk directory
		$simplerisk_dir = realpath(__DIR__ . "/../../../");

		// Backup the config file to the temporary directory
		copy ($simplerisk_dir . "/includes/config.php", sys_get_temp_dir() . "/config.php");

		// If the config.php file was not backed up successfully
		if (!file_exists(sys_get_temp_dir() . "/config.php"))
		{
			$message = "Unable make a backup of the config.php file from " . $simplerisk_dir . "/includes/config.php to " . sys_get_temp_dir() . "/config.php";
			$data = array(
				'source' => $simplerisk_dir . "/includes/config.php",
				'destination' => sys_get_temp_dir() . "/config.php",
			);
			json_response(403, $message, $data);
		}

		// If we have files that are not writeable in the SimpleRisk directory
		$realpath_simplerisk_dir = realpath($simplerisk_dir);
		if (!is_directory_writeable($realpath_simplerisk_dir))
		{
			$message = "ERROR: Found non-writeable files under the \"{$realpath_simplerisk_dir}\" directory.  Please check your directory permissions before proceeding with an upgrade.";
			$data = array(
				'directory' => $realpath_simplerisk_dir
			);
			json_response(403, $message, $data);
		}

		try
		{
			// Decompress the tgz file
			$p = new PharData(sys_get_temp_dir() . "/" . $file_name . ".tgz");
			$p->decompress();

			// Extract the tar to the existing simplerisk directory
			$phar = new PharData(sys_get_temp_dir() . "/" . $file_name . ".tar");
			$phar->extractTo(realpath($simplerisk_dir . "/../"), null, true);
		}
        catch (Exception $e)
        {
            $message = "There was an error extracting the file downloaded from " . $bundle_url . ".";
            $data = array(
            	'tgz' => sys_get_temp_dir() . "/" . $file_name . ".tgz",
            	'tar' => sys_get_temp_dir() . "/" . $file_name . ".tar",
            	'destination' => realpath($simplerisk_dir . "/../"),
            );
            json_response(403, $message, $data);
        }

		// If the simplerisk/includes/config.php file exists
		if (file_exists($simplerisk_dir . "/includes/config.php"))
        {       
            try     
            {       
                // Remove the file
               unlink($simplerisk_dir . "/includes/config.php");
            }
            catch(Exception $e)
            {       
                $message = "Unable to remove file located at " . $simplerisk_dir . "/includes/config.php";
                $data = array( 
                    'path' => $simplerisk_dir . "/includes",
                    'file' => "config.php",
                );
                json_response(403, $message, $data);
            }
        }

		// Copy the old config.php file back
		copy (sys_get_temp_dir() . "/config.php", $simplerisk_dir . "/includes/config.php");

		// Verify that we copied the file back successfully
		if (!file_exists($simplerisk_dir . "/includes/config.php"))
		{
			$message = "Unable to copy the config.php file back from " . sys_get_temp_dir() . "/config.php to " . $simplerisk_dir . "/includes/config.php";
			$data = array(
				'source' => sys_get_temp_dir() . "/config.php",
				'destination' => $simplerisk_dir . "/includes/config.php",
			);
			json_response(403, $message, $data);
		}

    	// Delete the tgz file from the temporary directory
    	if (file_exists(sys_get_temp_dir() . "/" . $file_name . ".tgz"))
    	{
	        try
	        {
                // Remove the file
                unlink(sys_get_temp_dir() . "/" . $file_name . ".tgz");
	        }
	        catch(Exception $e)
	        {
                $message = "Unable to remove file located at " . sys_get_temp_dir() . "/" . $file_name . ".tgz";
                $data = array(
                    'path' => sys_get_temp_dir(),
                    'file' => $file_name . ".tgz",
                );
                json_response(403, $message, $data);
	        }
    	}

        // Delete the tar file from the temporary directory
        if (file_exists(sys_get_temp_dir() . "/" . $file_name . ".tar"))
        {
            try
            {
                // Remove the file
                unlink(sys_get_temp_dir() . "/" . $file_name . ".tar");
            }
            catch(Exception $e)
            {
                $message = "Unable to remove file located at " . sys_get_temp_dir() . "/" . $file_name . ".tar";
                $data = array(
                    'path' => sys_get_temp_dir(),
                    'file' => $file_name . ".tar",
    	        );
                json_response(403, $message, $data);
            }
        }

        // Delete the config.php file from the temporary directory
        if (file_exists(sys_get_temp_dir() . "/config.php"))
        {
            try
            {
                // Remove the file
                unlink(sys_get_temp_dir() . "/config.php");
            }
            catch(Exception $e)
	        {
                $message = "Unable to remove file located at " . sys_get_temp_dir() . "/config.php";
                $data = array(
                    'path' => sys_get_temp_dir(),
                    'file' => "config.php",
                );
                json_response(403, $message, $data);
            }
        }

		// Get the current application version
		$current_version = current_version("app");

		// Get the next application version
		$next_version = next_version($current_version);

		// If we are now at the current release
		if ($next_version == "")
		{
			$message = "The SimpleRisk instance has been upgraded to the current application version.";
			$data = array(
				'latest_version' => $latest_version,
				'current_version' => $current_version,
				'next_version' => $next_version,
				'upgraded' => true,
				'current' => true,
			);
			json_response(200, $message, $data);
		}
		else
		{
			$message = "The SimpleRisk instance has been upgraded, but further updates are required.";
			$data = array(
				'latest_version' => $latest_version,
                'current_version' => $current_version,
                'next_version' => $next_version,
				'upgraded' => true,
				'current' => false,
            );
            json_response(200, $message, $data);
		}
	}
	// We are already at the current version
	else
	{
		$message = "The SimpleRisk instance is already at the current application version.";
        $data = array(
            'latest_version' => $latest_version,
            'current_version' => $current_version,
        	'next_version' => $next_version,
        	'upgraded' => false,
            'current' => true,
        );
        json_response(200, $message, $data);
	}
}

/***************************************
 * FUNCTION: API UPGRADE SIMPLERISK DB *
 ***************************************/
function api_upgrade_simplerisk_db() {

    // Doing a pre-upgrade check to prevent starting an upgrade that might fail
    do_pre_upgrade_check();

    // Connect to the database
	$db = db_open();

	// Get the list of grants for the database user
	$stmt = $db->prepare("SHOW GRANTS FOR CURRENT_USER;");
	$stmt->execute();
	$array = $stmt->fetchAll();

	// Disconnect from the database
	db_close($db);

	// Set the values to false
	$select = false;
	$insert = false;
	$update = false;
	$delete = false;
	$create = false;
	$drop = false;
	$references = false;
	$index = false;
	$alter = false;

	// For each of the grants
	foreach ($array as $value) {
		$string = $value[0];

        // Match SELECT statement
        $regex_pattern = "/SELECT/";
        if (preg_match($regex_pattern, $string)) {
        	$select = true;
		}

		// Match INSERT statement
		$regex_pattern = "/INSERT/";
		if (preg_match($regex_pattern, $string)) {
        		$insert = true;
		}

		// Match UPDATE statement
		$regex_pattern = "/UPDATE/";
		if (preg_match($regex_pattern, $string)) {       
        		$update = true;
		}

		// Match DELETE statement
		$regex_pattern = "/DELETE/";
		if (preg_match($regex_pattern, $string)) {
        		$delete = true;
		}

		// Match CREATE statement
		$regex_pattern = "/CREATE/";
		if (preg_match($regex_pattern, $string)) {
        		$create = true;
		}

		// Match DROP statement
		$regex_pattern = "/DROP/";
		if (preg_match($regex_pattern, $string)) {
	        	$drop = true;
		}

    	// Match REFERENCES statement
    	$regex_pattern = "/REFERENCES/";
    	if (preg_match($regex_pattern, $string)) {
    		$references = true;
    	}
    
    	// Match INDEX statement
    	$regex_pattern = "/INDEX/";
    	if (preg_match($regex_pattern, $string)) {
    		$index = true;
    	}

		// Match ALTER statement
		$regex_pattern = "/ALTER/";
		if (preg_match($regex_pattern, $string)) {
    		$alter = true;
		}

		// Match ALL statement
		$regex_pattern = "/ALL/";
		if (preg_match($regex_pattern, $string)) {
    		$select = true;
    		$insert = true;
    		$update = true;
    		$delete = true;
    		$create = true;
    		$drop = true;
    		$references = true;
    		$index = true;
    		$alter = true;
		}
	}

	// If all of the proper permissions are enabled
	if ($select && $insert && $update && $delete && $create && $drop && $references && $index && $alter)
	{
		// Get the current application and database versions
		$app_version = current_version("app");
		$db_version = current_version("db");

		// If the application version is not the same as the database version
		if ($app_version != $db_version)
		{
			// Get the upgrade function to call for this release version
			$release_function_name = get_database_upgrade_function_for_release($db_version);

			// If a release function name was provided
			if ($release_function_name != false) {

			    // If the release function exists
			    if (function_exists($release_function_name)) {

			        // Connect to the database
			        $db = db_open();

			        // Repeat calling the next version's upgrade3 function until the database is on the current release's version
			        ob_start(); // Start output buffering
			        do {

			            // Call the release function
			            call_user_func($release_function_name, $db);

			            // Get the updated release version
			            $updated_db_version = $db_version = current_version("db");

			            // If our app and db version are the same
			            if ($app_version == $updated_db_version) {
			                $current = true;
			            } else {
			                $current = false;
			                $release_function_name = get_database_upgrade_function_for_release($db_version);

			                // Stop if there's a missing function
			                if (!$release_function_name || !function_exists($release_function_name)) {
			                    $upgrade_messages = ob_get_clean(); // Stores buffer AND cleans it
			                    $message = $upgrade_messages . "The database upgrade function could not be found for version '$db_version'.";
			                    $data = array(
			                        'app_version' => $app_version,
			                        'db_version' => $db_version,
			                        'function_name' => $release_function_name,
			                    );
			                    // Disconnect from the database
			                    db_close($db);
			                    json_response(403, $message, $data);
			                }
			            }
			        } while(!$current);
			        // Disconnect from the database
			        db_close($db);

			        $upgrade_messages = ob_get_clean(); // Stores buffer AND cleans it
			        $message = $upgrade_messages . "<br/>The SimpleRisk database has been updated successfully.";
			        $data = array(
			            'app_version' => $app_version,
			            'db_version' => $updated_db_version,
			            'function_name' => $release_function_name,
			            'upgraded' => true,
			            'current' => ($current ? "true" : "false"),
			        );
			        json_response(200, $message, $data);
			    }
			    // The release function does not exist
			    else
			    {
			        $message = "The specified database upgrade function could not be found.";
			        $data = array(
			            'app_version' => $app_version,
			            'db_version' => $db_version,
			            'function_name' => $release_function_name,
			        );
			        json_response(403, $message, $data);
			    }
			}
			// This is not a known SimpleRisk release
			else
			{
				$message = "Unable to find an upgrade function for the current SimpleRisk database version.";
				$data = array(
					'app_version' => $app_version,
					'db_version' => $db_version,
				);
				json_response(403, $message, $data);
			}
		}
		// The application and database version are the same so no upgrade is needed
		else
		{
			$message = "You are currently running the version of the SimpleRisk database that goes along with your application version.";
			$data = array(
				'app_version' => $app_version,
				'db_version' => $db_version,
            	'upgraded' => false,
            	'current' => true,					
			);
			json_response(200, $message, $data);
		}
	}
	// The database grants are not correct
	else
	{
		$message = "A check of your database user privileges found that one or more of the necessary grants was missing.";
		$data = array(
			'select' => ($select ? "true" : "false"),
			'insert' => ($insert ? "true" : "false"),
			'update' => ($update ? "true" : "false"),
			'delete' => ($delete ? "true" : "false"),
			'create' => ($create ? "true" : "false"),
			'drop' => ($drop ? "true" : "false"),
			'references' => ($references ? "true" : "false"),
			'index' => ($index ? "true" : "false"),
			'alter' => ($alter ? "true" : "false"),
		);
		json_response(403, $message, $data);
	}
}

?>
