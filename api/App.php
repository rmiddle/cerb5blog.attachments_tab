<?php
 
class Cerb5BlogAttachementsTicketTab extends Extension_TicketTab {
	function __construct($manifest) {
		$this->DevblocksExtension($manifest,1);
	}
 
	function showTab() {
		@$ticket_id = DevblocksPlatform::importGPC($_REQUEST['ticket_id'],'integer',0);
		$tpl = DevblocksPlatform::getTemplateService();
		$tpl->cache_lifetime = "0";
		$tpl_path = dirname(dirname(__FILE__)) . '/templates/';
		
//		$tpl->assign('response_uri', 'config/attachments');

		$defaults = new C4_AbstractViewModel();
		$defaults->class_name = 'View_Attachment';
		$defaults->name = 'Attachements View';
		$defaults->id = 'ticket_view_attachements';
		$defaults->renderLimit = 15;

		$view = C4_AbstractViewLoader::getView($defaults->id, $defaults);
		$view->addParams(array(
			SearchFields_Attachment::TICKET_ID => new DevblocksSearchCriteria(SearchFields_Attachment::TICKET_ID,DevblocksSearchCriteria::OPER_EQ,$ticket_id)
		), true);
		$view->renderPage = 0;
		
		C4_AbstractViewLoader::setView($view->id,$view);
	
		$tpl->assign('view', $view);
		
		$tpl->display('file:' . $tpl_path . 'attachments/index.tpl');
	}

	function saveTab() {
	}
};