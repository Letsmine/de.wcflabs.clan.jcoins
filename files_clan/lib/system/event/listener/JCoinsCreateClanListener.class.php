<?php
namespace clan\system\event\listener;

use wcf\system\event\listener\IParameterizedEventListener;
use wcf\system\user\jcoins\UserJCoinsStatementHandler;
use wcf\system\WCF;

/**
 * Add JCoins for Clans.
 *
 * @author KleinCrafter
 * @copyright 2020 letsmine.eu
 * @license LGPL-3.0 License
 * @package de.wcflabs.clan.jcoins
 */
class JCoinsCreateClanListener implements IParameterizedEventListener
{

    /**
     *
     * @inheritdoc
     */
    public function execute($eventObj, $className, $eventName, array &$parameters)
    {
        if (! MODULE_JCOINS)
            return;

        switch ($eventObj->getActionName()) {
            case 'create':
                UserJCoinsStatementHandler::getInstance()->create('de.wcflabs.jcoins.statement.clan', null, [
                    'userID' => WCF::getUser()->userID
                ]);

                break;

            case 'delete':
                // delete finally, not trash bin
                foreach ($eventObj->getObjects() as $object) {
                    UserJCoinsStatementHandler::getInstance()->revoke('de.wcflabs.jcoins.statement.clan', $object->getDecoratedObject());
                }
                break;
        }
    }
}
