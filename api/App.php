<?php
 
class Cerb5BlogAttachementsTicketTab extends Extension_TicketTab {
	function showTab() {
		@$ticket_id = DevblocksPlatform::importGPC($_REQUEST['ticket_id'],'integer',0);
        $tpl_path = dirname(dirname(__FILE__)) . '/templates/';
		
		$tpl = DevblocksPlatform::getTemplateService();
		//$visit = CerberusApplication::getVisit();
		
		//$visit->set(Extension_ConfigTab::POINT, 'attachments');
		$message_ids = array_keys(DAO_Message::getMessagesByTicket($ticket_id));
		$comment_ids = array_keys(DAO_Comment::getByContext(CerberusContexts::CONTEXT_TICKET, $ticket_id));
		$attachment_links = array_merge(
			DAO_AttachmentLink::getByContextIds(CerberusContexts::CONTEXT_MESSAGE, $message_ids),
			DAO_AttachmentLink::getByContextIds(CerberusContexts::CONTEXT_COMMENT, $comment_ids)
		);
        if(empty($attachment_links))
            return;
            
		$defaults = new C4_AbstractViewModel();
		$defaults->class_name = 'View_AttachmentLink';
        $defaults->id = '_tv_attachements';
		$defaults->name = 'Ticket Attachements';
        $defaults->renderLimit = 15;

		$view = C4_AbstractViewLoader::getView($defaults->id, $defaults);

		$view->addParamsRequired(array(
			SearchFields_AttachmentLink::GUID => new DevblocksSearchCriteria(SearchFields_AttachmentLink::GUID,'in',array_keys($attachment_links)),
		), true);
        $view->renderPage = 0;
echo "<pre>";        
print_r($view);
echo "</pre>";        
		
		C4_AbstractViewLoader::setView($view->id,$view);
		
		$tpl->assign('view', $view);
		
        $tpl->display('file:' . $tpl_path . 'attachments/index.tpl');
	}

	function saveTab() {
	}
};