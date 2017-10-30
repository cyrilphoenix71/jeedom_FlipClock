<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class FlipClock extends eqLogic {

  public static $_widgetPossibility = array('custom' => true);

  public static function cron30($_eqLogic_id = null) {
    log::add('FlipClock', 'debug', 'Start de la Fonction cron30()');
    if ($_eqLogic_id == null) {
      $eqLogics = self::byType('FlipClock', true);
    } else {
      $eqLogics = array(self::byId($_eqLogic_id));
    }
    foreach ($eqLogics as $FlipClock) {

      if (null !== ($FlipClock->getConfiguration('coordonees', '')) and null !== ($FlipClock->getConfiguration('apikey', ''))) {
        log::add('FlipClock', 'debug', 'Appel de getInformations() depuis cron30');
		$FlipClock->getInformations();
      } else {
        log::add('FlipClock', 'error', 'Pas Appel de getInformations() depuis cron30 > Coordonées ou ApiKey non saisie');
      }
    }
    log::add('FlipClock', 'debug', 'Fin de la Fonction cron30()');
  }
  public function preUpdate() {
    log::add('FlipClock', 'debug', 'Start de la Fonction preUpdate()');
		
    log::add('FlipClock', 'debug', 'Fin de la Fonction preUpdate()');
  }

  public function postUpdate() {
	log::add('FlipClock', 'debug', 'Start de la Fonction postUpdate()');

	log::add('FlipClock', 'debug', 'Fin de la Fonction postUpdate()');
  }

  public function getInformations() {
	log::add('FlipClock', 'debug','Start de la Fonction getInformations()');

    
	$this->refreshWidget();
	log::add('FlipClock', 'debug', 'Fin de la fonction getInformations()');
  }
 
  public function toHtml($_version = 'dashboard') {
  	log::add('FlipClock', 'debug', 'Start de la fonction toHtml()');
	
    $replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}
    $version = jeedom::versionAlias($_version);
		if ($this->getDisplay('hideOn' . $version) == 1) {
			return '';
		}
	//Recuperation type horloge
	$replace['#ClockType#'] = $this->getConfiguration('clocktype',1)+1;
	if ($replace['#ClockType#']<1 || $replace['#ClockType#']>4) {
		$replace['#ClockType#'] = '1';
	}
	//Recuperation type numero
	$replace['#ClockNum#'] = $this->getConfiguration('clocknum',1)+1;
	if ($replace['#ClockNum#']<1 || $replace['#ClockNum#']>3) {
		$replace['#ClockNum#'] = '1';
	}
	//Recuperation type ombre
	$replace['#ClockGlow#'] = $this->getConfiguration('clockglow',1)+1;
	if ($replace['#ClockGlow#']<1 || $replace['#ClockGlow#']>3) {
		$replace['#ClockGlow#'] = '1';
	}
	//Recuperation type fond
	$replace['#ClockBack#'] = $this->getConfiguration('clockback',1)+1;
	if ($replace['#ClockBack#']<1 || $replace['#ClockBack#']>4) {
		$replace['#ClockBack#'] = '1';
	}
	//Recuperation type dots
	$replace['#ClockDots#'] = $this->getConfiguration('clockdots',1)+1;
	if ($replace['#ClockDots#']<1 || $replace['#ClockDots#']>5) {
		$replace['#ClockDots#'] = '1';
	}
	//Recuperation type ombre pour fond
	$replace['#ClockBackGlow#'] = $this->getConfiguration('clockbackglow',1)+1;
	if ($replace['#ClockBackGlow#']<1 || $replace['#ClockBackGlow#']>3) {
		$replace['#ClockBackGlow#'] = '1';
	}
		
    $refresh = $this->getCmd(null, 'refresh');
    $replace['#refresh_id#'] = is_object($refresh) ? $refresh->getId() : '';

    $parameters = $this->getDisplay('parameters');
	if (is_array($parameters)) {
		foreach ($parameters as $key => $value) {
			$replace['#' . $key . '#'] = $value;
		}
	}
		log::add('FlipClock', 'debug', 'Horloge');
			$html = template_replace($replace, getTemplate('core', $version, 'current', 'FlipClock'));
		cache::set('FlipClockWidget' . $_version . $this->getId(), $html, 0);
		return $html;
		log::add('FlipClock', 'debug', 'Fin de la fonction toHtml()');
	}
}

class FlipClockCmd extends cmd {

  public function execute($_options = null) {
    if ($this->getLogicalId() == 'refresh') {
      $eqLogic = $this->getEqLogic();
      $eqLogic->getInformations();
    } else {
      return $this->getConfiguration('value');
    }
  }
}

?>
