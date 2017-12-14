<?php

if (!isConnect('admin')) {
  throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'FlipClock');
$eqLogics = eqLogic::byType('FlipClock');

?>

<div class="row row-overflow">
	<div class="col-lg-2 col-md-3 col-sm-4">
		<div class="bs-sidebar">
			<ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
				<a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter une horloge}}</a>
				<li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
				<?php
					foreach ($eqLogics as $eqLogic) {
					echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
					}
				?>
			</ul>
		</div>
	</div>
	<div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
		<legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 130px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 140px;margin-left : 10px;">
				<center>
					<i class="fa fa-wrench" style="font-size : 5em;color:#94ca02;margin-top : 20px;"></i>
				</center>
				<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>{{Configuration}}</center></span>
			</div>
		</div>
		<legend><i class="fa fa-clock-o"></i>  {{Mes Horloges}}</legend>
		<div class="eqLogicThumbnailContainer">
			<link rel="stylesheet" type="text/css" href="plugins/FlipClock/core/template/dashboard/css/digiFlipClock.css" />
			<div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 180px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 140px;margin-left : 10px;" >
				<i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;margin-top : 15px;"></i>
				<br>
				<span style="font-size : 1.1em;position:relative; top : 10px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02">{{Ajouter}}</span>
			</div>
			<?php
			foreach ($eqLogics as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
				$clockImagesPath = 'plugins/FlipClock/core/template/dashboard/images/clock';
				$clockImagesNumPath = 'plugins/FlipClock/core/template/dashboard/images/num';
				$clockImagesBackPath = 'plugins/FlipClock/core/template/dashboard/images/back/';
				$clockImagesDotsPath = 'plugins/FlipClock/core/template/dashboard/images/dots/';
				$typeClock = $eqLogic->getConfiguration('clocktype','1')+1;
				$typeGlow = $eqLogic->getConfiguration('clockglow','1')+1;
				$typeBackGlow = $eqLogic->getConfiguration('clockbackglow','1')+1;
				$typeDigits = $eqLogic->getConfiguration('clocknum','1')+1;
				$typeClock = $eqLogic->getConfiguration('clocktype','1')+1;
				$typeDots = $eqLogic->getConfiguration('clockdots','1')+1;
				$typeBack = $eqLogic->getConfiguration('clockback','1')+1;
				$typeBackMode = $eqLogic->getConfiguration('clockbackmode','1');
				$typeSeconds = $eqLogic->getConfiguration('clockseconds','1');
				if ($typeSeconds == '1') {	
					echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff ; height : 180px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 330px;margin-left : 10px;' . $opacity . '" >';
						echo '<span id="digital_container" style="top:0px;left:0px;">';
							echo '<span id="clock" style="transform: scale(0.4);margin-left:-43%;margin-right:-43%;margin-top:-9%;margin-bottom: -13%;">';
								if ($typeBackMode == '1') {
									echo '<span id="back_bg"><img src="'.$clockImagesBackPath.$typeBackGlow.'backD'.$typeBack.'.png" /></span>';
								} else {
									echo '<span id="back_bg"><img src="'.$clockImagesBackPath.$typeBackGlow.'back'.$typeBack.'.png" /></span>';
								}
								echo '<span id="dots_bg"><img src="'.$clockImagesDotsPath.'dots'.$typeDots.'.png" /></span>';
								echo '<span id="hours">';
									echo '<span class="line'.$typeClock.'" ></span>';
									echo '<span id="hours_bg"><img src="'.$clockImagesPath.$typeClock."/".$typeGlow.'clockbg1.png" /></span>';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/2.png" id="fhd" class="first_digit" />';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/0.png" id="shd" class="second_digit" />';
								echo '</span>';
								echo '<span id="minutes">';
									echo '<span class="line'.$typeClock.'" ></span>';
									echo '<span id="minutes_bg"><img src="'.$clockImagesPath.$typeClock."/".$typeGlow.'clockbg1.png" /></span>';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/3.png" id="fmd" class="first_digit" />';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/7.png" id="smd" class="second_digit" />';
								echo '</span>';
								echo '<span id="seconds">';
									echo '<span class="line'.$typeClock.'" ></span>';
									echo '<span id="seconds_bg"><img src="'.$clockImagesPath.$typeClock."/".$typeGlow.'clockbg1.png" /></span>';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/4.png" id="fmd" class="first_digit" />';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/6.png" id="smd" class="second_digit" />';
								echo '</span>';
							echo '</span>';
						echo '</span>';
						echo '<span style="font-size : 1.1em;position:relative; top : 110px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>'.$eqLogic->getHumanName(true, true).'</center></span>';
					echo '</div>';	
				} else {
					echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff ; height : 180px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 240px;margin-left : 10px;' . $opacity . '" >';
						echo '<span id="digital_container" style="top:0px;left:0px;">';
							echo '<span id="clock" style="transform: scale(0.4);margin-left:-35%;margin-right:-35%;margin-top:-13%;margin-bottom: -13%;">';
								if ($typeBackMode == '1') {
									echo '<span id="back_bg"><img src="'.$clockImagesBackPath.$typeBackGlow.'backD'.$typeBack.'.png" /></span>';
								} else {
									echo '<span id="back_bg"><img src="'.$clockImagesBackPath.$typeBackGlow.'back'.$typeBack.'.png" /></span>';
								}
								echo '<span id="dots_bg"><img src="'.$clockImagesDotsPath.'dots'.$typeDots.'.png" /></span>';
								echo '<span id="hours">';
									echo '<span class="line'.$typeClock.'" ></span>';
									echo '<span id="hours_bg"><img src="'.$clockImagesPath.$typeClock."/".$typeGlow.'clockbg1.png" /></span>';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/2.png" id="fhd" class="first_digit" />';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/0.png" id="shd" class="second_digit" />';
								echo '</span>';
								echo '<span id="minutes">';
									echo '<span class="line'.$typeClock.'" ></span>';
									echo '<span id="minutes_bg"><img src="'.$clockImagesPath.$typeClock."/".$typeGlow.'clockbg1.png" /></span>';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/3.png" id="fmd" class="first_digit" />';
									echo '<img src="'.$clockImagesNumPath.$typeDigits.'/7.png" id="smd" class="second_digit" />';
								echo '</span>';
							echo '</span>';
						echo '</span>';
						echo '<span style="font-size : 1.1em;position:relative; top : 110px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>'.$eqLogic->getHumanName(true, true).'</center></span>';
					echo '</div>';
				}
			}
			?>
		</div>
	</div>
	<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
		<a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
		<a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
		<a class="btn btn-default eqLogicAction pull-right" data-action="copy"><i class="fa fa-files-o"></i> {{Dupliquer}}</a>
		<a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
		</ul>
		<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
				<br/>
				<form class="form-horizontal">
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">{{Nom de l'horloge}}</label>
							<div class="col-md-4">
								<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
								<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'horloge}}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" >{{Objet parent}}</label>
							<div class="col-md-4">
								<select class="form-control eqLogicAttr" data-l1key="object_id">
									<option value="">{{Aucun}}</option>
									<?php
										foreach (object::all() as $object) {
											echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-8">
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Catégorie}}</label>
							<div class="col-sm-8" style="margin-top:10px;">
								<?php
								foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
									echo '<label class="checkbox-inline">';
									echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
									echo '</label>';
								}
								?>
							</div>
						</div>
						<br>
						<br>
					</fieldset>
					<fieldset>
						<legend><i class="icon fa fa-cog"></i>   {{Paramètres Généraux}}
						<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Paramètres Généraux}}" 
							data-content="{{Cette section sert à choisir les paramètres de l'horloge}}."></i>
						</legend>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Largeur de l'horloge}}</label>
							<div class="col-sm-1">
								<div class="input-group">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="clocksize" placeholder="0" value="0"/>
								</div>
							</div>
							<span>{{pixels}}</span>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Largeur de l'horloge}}" 
							data-content="{{Saisissez ici la largeur en pixel de l'horloge}}.<br>
							{{La valeur par défaut (ou si omise) est à}} 414 {{pixels si affichage sans les secondes et}} 620 {{si avec les secondes}}."></i>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Animation des secondes}}</label>
							<div class="col-sm-2">
								<select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="clocksecondsanime">
									<?php
										$secarray = array(
											'{{Sans}}',
											'{{Flip}}',
											'{{Clignotement dots}}'
										);
										foreach($secarray as $secidx=>$secname) {
											echo '<option value="'.$secidx.'">'.$secidx.' - '.$secname.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Animation des secondes}}" 
							data-content="{{Choisissez ici le type d'animation des secondes}}.<br>
							{{La valeur par défaut est sans}}."></i>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Affichage des secondes}}</label>
							<div class="col-sm-2">
								<select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="clockseconds">
									<?php
										$fondarray = array(
											'{{Sans}}',
											'{{Avec}}'
										);
										foreach($fondarray as $fondidx=>$fondname) {
											echo '<option value="'.$fondidx.'">'.$fondidx.' - '.$fondname.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Affichage des secondes}}" 
							data-content="{{Choisissez ici l'affichage secondes. La taille de l'horloge sera adaptée}}.<br>
							{{La valeur par défaut est sans}}."></i>
						</div>
					</fieldset>
					<fieldset>
						<legend><i class="icon fa fa-eye"></i>   {{Options Graphiques}}
						<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Options Graphiques}}" 
							data-content="{{Cette section sert à choisir les options graphique de l'horloge}}."></i>
						</legend>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Type d'horloge}}</label>
							<div class="col-sm-2">
								<select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="clocktype">
									<?php
										$typearray = array(
											'{{HTC Blanche}}',
											'{{HTC Noire}}',
											'{{HTC Rouge}}',
											'{{HTC Bleutée}}',
											'{{HTC Rosée}}',
											'{{HTC Verdâtre}}',
											'{{HTC Jaunâtre}}',
											'{{HTC Violâtre}}',
											'{{HTC Orangée}}'
										);
										foreach($typearray as $typeidx=>$typename) {
											echo '<option value="'.$typeidx.'">'.$typeidx.' - '.$typename.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Type}}" 
							data-content="{{Choisissez ici le type de l'horloge}}.<br>
							{{La valeur par défaut est HTC Blanche}}."></i>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Type d'ombre de l'heure}}</label>
							<div class="col-sm-2">
								<select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="clockglow">
									<?php
										$glowarray = array(
											'{{Noire}}',
											'{{Blanche}}',
											'{{Sans ombre}}'
										);
										foreach($glowarray as $glowidx=>$glowname) {
											echo '<option value="'.$glowidx.'">'.$glowidx.' - '.$glowname.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Ombre d'heure}}" 
							data-content="{{Choisissez ici le type d'ombre de l'heure}}.<br>
							{{La valeur par défaut est avec ombre noire}}."></i>
						</div>	
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Type de digits}}</label>
							<div class="col-sm-2">
								<select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="clocknum">
									<?php
										$numarray = array(
											'{{Noirs}}',
											'{{Blancs}}',
											'{{Rouges}}',
											'{{Bleutés}}',
											'{{Rosés}}',
											'{{Verdâtres}}',
											'{{Jaunâtres}}',
											'{{Violâtres}}',
											'{{Orangés}}'
										);
										foreach($numarray as $numidx=>$numname) {
											echo '<option value="'.$numidx.'">'.$numidx.' - '.$numname.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Digits}}" 
							data-content="{{Choisissez ici le type de digits}}.<br>
							{{La valeur par défaut est Noirs}}."></i>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Type de dots}}</label>
							<div class="col-sm-2">
								<select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="clockdots">
									<?php
										$dotsarray = array(
											'{{Sans}}',
											'{{Blancs}}',
											'{{Noirs}}',
											'{{Rouges}}',
											'{{Bleutés}}',
											'{{Rosés}}',
											'{{Verdâtres}}',
											'{{Jaunâtres}}',
											'{{Violâtres}}',
											'{{Orangés}}'
										);
										foreach($dotsarray as $dotsidx=>$dotsname) {
											echo '<option value="'.$dotsidx.'">'.$dotsidx.' - '.$dotsname.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Dots}}" 
							data-content="{{Choisissez ici le type de dots (séparateur heures/minutes)}}.<br>
							{{La valeur par défaut est blancs}}."></i>
						</div>						
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Type de fond}}</label>
							<div class="col-sm-2">
								<select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="clockback">
									<?php
										$backarray = array(
											'{{Aucun}}',
											'{{HTC Original}}',
											'{{HTC Black}}',
											'{{HTC White}}',
											'{{HTC Rosé}}',
											'{{HTC Verdatre}}',
											'{{HTC Jaunatre}}',
											'{{HTC Bleuté}}',
											'{{HTC Violâtre}}',
											'{{HTC Orangé}}'
										);
										foreach($backarray as $backidx=>$backname) {
											echo '<option value="'.$backidx.'">'.$backidx.' - '.$backname.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Type de fond}}" 
							data-content="{{Choisissez ici le type de fond}}.<br>
							{{La valeur par défaut est aucun}}."></i>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Mode du fond}}</label>
							<div class="col-sm-2">
								<select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="clockbackmode">
									<?php
										$backmodearray = array(
											'{{Pleine hauteur}}',
											'{{Demi hauteur}}'
										);
										foreach($backmodearray as $backmodeidx=>$backmodename) {
											echo '<option value="'.$backmodeidx.'">'.$backmodeidx.' - '.$backmodename.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Mode du fond}}" 
							data-content="{{Choisissez ici le mode du fond}}.<br>
							{{La valeur par défaut est Plaine hauteur}}."></i>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Type d'ombre de fond}}</label>
							<div class="col-sm-2">
								<select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="clockbackglow">
									<?php
										$backglowarray = array(
											'{{Noire}}',
											'{{Blanche}}',
											'{{Sans ombre}}'
										);
										foreach($backglowarray as $backglowidx=>$backglowname) {
											echo '<option value="'.$backglowidx.'">'.$backglowidx.' - '.$backglowname.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Ombre de fond}}" 
							data-content="{{Choisissez ici le type d'ombre du fond}}.<br>
							{{La valeur par défaut est sans ombre}}."></i>
						</div>						
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<?php 
include_file('desktop', 'FlipClock', 'js', 'FlipClock'); 
include_file('desktop', 'FlipClock', 'css', 'FlipClock');
include_file('core', 'plugin.template', 'js'); 
?>
