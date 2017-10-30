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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
	include_file('desktop', '404', 'php');
	die();
}
?>
<head>
<style>
#images-box {
	/* La largeur totale du bloc conteneur, essentiellement pour le centrage */
	width: 100%;
	margin: 0px auto;
	/*position: relative;*/
	top: 70px;
}

.image-lightbox img {
	/* Chaque image hérite ses dimensions de son parent */
	width: inherit;
	height: inherit;
}

.holder {
	/* Dimension des images, vous pouvez les modifier */
	width: 128px;
	height: 128px;
	/* Flottement à gauche, donc l'ensemble est aligné à droite */
	float: left;
	margin: 0 20px 0 0;
}

.holderback {
	/* Dimension des images, vous pouvez les modifier */
	width: 258px;
	height: 128px;
	/* Flottement à gauche, donc l'ensemble est aligné à droite */
	float: left;
	margin: 0 20px 0 0;
}

.holderdigits {
	/* Dimension des images, vous pouvez les modifier */
	width: 51px;
	height: 128px;
	/* Flottement à gauche, donc l'ensemble est aligné à droite */
	float: left;
	margin: 0 20px 0 0;
}

.holder.little {
	width: 42px;
	height: 42px;
}

.image-lightbox {
	/* Les dimensions héritent de .holder */
	width: inherit;
	height: inherit;
	/*padding: 10px;*/
	/* Ombrage des blocs */
	box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
	background: rgba(0,0,0,0);
	border-radius: 5px;
	/* Position absolue pour permettre de zoomer ultérieurement */
	/*position: absolute;*/
	top: 0;
	font-family: Arial, sans-serif;
	/* Transitions pour rendre l'ensemble visuellement abouti */
	-webkit-transition: all ease-in 0.5s;
	-moz-transition: all ease-in 0.5s;
	-ms-transition: all ease-in 0.5s;
	-o-transition: all ease-in 0.5s;
}

.image-lightbox span {
	display: none;
}

.image-lightbox .expand {
	width: 100%;
	height: 100%;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 4000;
	background: rgba(0,0,0,0); /* Fixe un bogue d'IE */
}

.image-lightbox .close {
	position: absolute;
	width: 20px; height: 20px;
	right: 20px; top: 20px;
}

.image-lightbox .close a {
	height: auto; width: auto;
	padding: 5px 10px;
	color: #fff;
	text-decoration: none;
	background: #22272c;
	box-shadow: inset 0px 24px 20px -15px rgba(255, 255, 255, 0.1),
		inset 0px 0px 10px rgba(0,0,0,0.4),
		0px 0px 30px rgba(255,255,255,0.4);
	border-radius: 5px;
	font-weight: bold;
	float: right;
}

.close a:hover {
	box-shadow: inset 0px -24px 20px -15px rgba(255, 255, 255, 0.01),
		inset 0px 0px 10px rgba(0,0,0,0.4),
		0px 0px 20px rgba(255,255,255,0.4);
}

/*div[id^=image]:target {
	width: 450px;
	height: 300px;
	z-index: 5000;
	top: 50px;
	left: 200px;
}
div[id^=image]:target .close {
	display: block;
}

div[id^=image]:target .expand {
	display: none;
}*/
</style>
</head>
<form class="form-horizontal">
<div class="panel panel-info" style="height: 100%;">
	<div class="panel-heading" role="tab">
		<h4 class="panel-title">
			Plugin FlipClock
		</h4>
	</div>
	<div class="form-group">
		<br>
		<label class="col-sm-2 control-label">{{Configuration}} :</label>
		<div class="col-lg-4">
			<a class="btn btn-info" href=/index.php?v=d&m=FlipClock&p=FlipClock> {{Accès à la configuration}}</a>
		</div>
		<br>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">{{Présentation}} :</label>
		<div class="col-lg-8" style="margin-top:9px">
			{{Plugin pour créer une horloge de type Flip}}.<br><br>
			{{On peut choisir parmis une liste de type visualisable dans la galerie ci-dessous}}.<br><br>
			{{Une animation est visualisable au changement de minutes ou d'heure.}}<br><br>
		</div>
	</div>
</div>
<div class="panel panel-info" style="height: 100%;">
	<div class="panel-heading" role="tab">
		<h4 class="panel-title">
			{{Galerie des types d'horloges}}
		</h4>
	</div>
	<div class="form-group">
		<br>
		<label class="col-sm-1 control-label"></label>
		<div class="col-lg-10">
		<div id="images-box">
			<?php
				$dir = 'plugins/FlipClock/core/template/dashboard/images/';
				$file_display = array('jpg', 'jpeg', 'png', 'gif');
				if (file_exists($dir) == false)
				{
					echo 'Directory "', $dir, '" not found!';
				}
				else
				{
					$dir_contents = scandir($dir);
					foreach ($dir_contents as $file)
					{
						$file_type = strtolower(end(explode('.', $file)));
						if(in_array($file_type,$file_display))
						{
							$name = basename($file);
							if (strpos($name, 'Type') !== false){
								echo "<div class='holder'>";
								echo "    <div id='image-$name' class='image-lightbox'>";
								echo "        <img src='$dir$file' alt='$name' title='$name'>";
								echo "    </div>";
								echo "</div>";
							}
						}
					}
				}
			?>
		</div>
		</div>
	</div>
</div>
<div class="panel panel-info" style="height: 100%;">
	<div class="panel-heading" role="tab">
		<h4 class="panel-title">
			{{Galerie des types de fond}}
		</h4>
	</div>
	<div class="form-group">
		<br>
		<label class="col-sm-1 control-label"></label>
		<div class="col-lg-10">
		<div id="images-box">
			<?php
				$dir = 'plugins/FlipClock/core/template/dashboard/images/back/';
				$file_display = array('jpg', 'jpeg', 'png', 'gif');
				if (file_exists($dir) == false)
				{
					echo 'Directory "', $dir, '" not found!';
				}
				else
				{
					$dir_contents = scandir($dir);
					foreach ($dir_contents as $file)
					{
						$file_type = strtolower(end(explode('.', $file)));
						if(in_array($file_type,$file_display))
						{
							$name = basename($file);
							if (strpos($name, '1back') !== false){
								echo "<div class='holderback'>";
								echo "    <div id='image-$name' class='image-lightbox'>";
								echo "        <img src='$dir$file' alt='$name' title='$name'>";
								echo "    </div>";
								echo "</div>";
							}
						}
					}
				}
			?>
		</div>
		</div>
	</div>
</div>
<div class="panel panel-info" style="height: 100%;">
	<div class="panel-heading" role="tab">
		<h4 class="panel-title">
			{{Galerie des types de dots}}
		</h4>
	</div>
	<div class="form-group">
		<br>
		<label class="col-sm-1 control-label"></label>
		<div class="col-lg-10">
		<div id="images-box">
			<?php
				$dir = 'plugins/FlipClock/core/template/dashboard/images/dots/';
				$file_display = array('jpg', 'jpeg', 'png', 'gif');
				if (file_exists($dir) == false)
				{
					echo 'Directory "', $dir, '" not found!';
				}
				else
				{
					$dir_contents = scandir($dir);
					foreach ($dir_contents as $file)
					{
						$file_type = strtolower(end(explode('.', $file)));
						if(in_array($file_type,$file_display))
						{
							$name = basename($file);
							if (strpos($name, 'dots') !== false){
								echo "<div class='holderback'>";
								echo "    <div id='image-$name' class='image-lightbox'>";
								echo "        <img src='$dir$file' alt='$name' title='$name'>";
								echo "    </div>";
								echo "</div>";
							}
						}
					}
				}
			?>
		</div>
		</div>
	</div>
</div>
<div class="panel panel-info" style="height: 100%;">
	<div class="panel-heading" role="tab">
		<h4 class="panel-title">
			{{Galerie des types de digits}}
		</h4>
	</div>
	<div class="form-group">
		<br>
		<label class="col-sm-1 control-label"></label>
		<div class="col-lg-10">
		<div id="images-box">
			<?php
				for ($i = 1; $i <= 10; $i++) { 
					$dir = 'plugins/FlipClock/core/template/dashboard/images/num'.$i.'/';
					$file_display = array('jpg', 'jpeg', 'png', 'gif');
					if (file_exists($dir) == true)
					{
						$dir_contents = scandir($dir);
						foreach ($dir_contents as $file)
						{
							$file_type = strtolower(end(explode('.', $file)));
							if(in_array($file_type,$file_display))
							{
								$name = basename($file);
								if (strpos($name, '8') !== false){
									echo "<div class='holderdigits'>";
									echo "    <div id='image-$name' class='image-lightbox'>";
									echo "        <img src='$dir$file' alt='$name' title='$name'>";
									echo "    </div>";
									echo "</div>";
								}
							}
						}
					}
				}
			?>
		</div>
		</div>
	</div>
</div>
</form>
