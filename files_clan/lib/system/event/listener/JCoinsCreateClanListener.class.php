<?php
namespace clan\system\event\listener;
use wcf\system\event\listener\IParameterizedEventListener;
use wcf\system\user\jcoins\UserJCoinsStatementHandler;

/**
 * Add JCoins for Clans.
 *
 * @author		KleinCrafter
 * @copyright	2020 letsmine.eu
 * @license		LGPL-3.0 License
 * @package		de.wcflabs.clan.jcoins
 */
class JCoinsCreateClanListener implements IParameterizedEventListener {
	/**
	 * @inheritdoc
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
	    if (!MODULE_JCOINS) return;
	    
	    if ($eventObj->getActionName() != 'create') return;
	    
	    foreach ($eventObj->getObjects() as $object) {
	        UserJCoinsStatementHandler::getInstance()->create('de.wcflabs.jcoins.statement.clan', $object->getDecoratedObject());
	    }
	    
	}
}
