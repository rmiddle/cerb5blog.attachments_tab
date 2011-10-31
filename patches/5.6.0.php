<?php
$db = DevblocksPlatform::getDatabaseService();
$logger = DevblocksPlatform::getConsoleLog();
$tables = $db->metaTables();

// ===========================================================================
// Workspace cleanup cleanup

$db->Execute("DELETE FROM worker_view_model WHERE `title` = 'Ticket Attachements'");


return TRUE;