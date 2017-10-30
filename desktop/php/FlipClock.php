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
			<div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 180px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 140px;margin-left : 10px;" >
				<i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;margin-top : 15px;"></i>
				<br>
				<span style="font-size : 1.1em;position:relative; top : 10px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02">{{Ajouter}}</span>
			</div>
			<?php
			foreach ($eqLogics as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
				$typeClock = $eqLogic->getConfiguration('clocktype','1')+1;
				if ($typeClock<1 || $typeClock>4) {
					$typeClock = '1';
				}
				echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff ; height : 180px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
				echo "<center>";
				echo '<img src="plugins/FlipClock/core/template/dashboard/images/Type'.$typeClock.'.png" height="105" width="95" />';
				echo "</center>";
				echo '<span style="font-size : 1.1em;position:relative; top : 10px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
				echo '</div>';
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
											'{{HTC Bleutée}}'
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
											'{{Rouges}}'
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
											'{{Bleutés}}'
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
											'{{HTC White}}'
										);
										foreach($backarray as $backidx=>$backname) {
											echo '<option value="'.$backidx.'">'.$backidx.' - '.$backname.'</option>';
										}
									?>
								</select>
							</div>
							<i class="icon fa fa-question-circle" style="margin-top:12px;margin-left:10px" data-placement="right" data-toggle="popover" data-trigger="hover" data-animation=true data-delay=200 data-html=true 
							title="{{Fond}}" 
							data-content="{{Choisissez ici le type de fond}}.<br>
							{{La valeur par défaut est aucun}}."></i>
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
