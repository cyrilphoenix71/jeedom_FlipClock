/*
 * jdigiFlipClock plugin 2.0
 *
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */


(function($) {
    $.fn.extend({
        jdigiFlipClock: function(options) {
			var defaults = {
                clockImagesPath: 'plugins/FlipClock/core/template/dashboard/images/clock',
				clockImagesNumPath: 'plugins/FlipClock/core/template/dashboard/images/num',
				clockImagesBackPath: 'plugins/FlipClock/core/template/dashboard/images/back',
				clockImagesDotsPath: 'plugins/FlipClock/core/template/dashboard/images/dots',
                lang: 'fr',
				clockType: '1',
				clockGlow: '1',
				clockNum: '1',
				clockBack: '1',
				clockDots: '2',
				clockBackGlow: '1',
				clockSeconds: '0',
				clockSecondsAnime: '1',
            };

            var regional = [];
            regional['fr'] = {
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
            }


            var options = $.extend(defaults, options);

            return this.each(function() {
                
                var $this = $(this);
                var o = options;
                $this.clockImagesPath = o.clockImagesPath + o.clockType + '/';
				$this.clockImagesNumPath = o.clockImagesNumPath + o.clockNum + '/';
				$this.clockImagesBackPath = o.clockImagesBackPath + '/';
				$this.clockImagesDotsPath = o.clockImagesDotsPath + '/';
                $this.lang = regional[o.lang] == undefined ? regional['fr'] : regional[o.lang];
                $this.currDate = '';
				$this.clockGlow = o.clockGlow;
				$this.clockType = o.clockType;
				$this.clockNum = o.clockNum;
				$this.clockBack = o.clockBack;
				$this.clockDots = o.clockDots;
				$this.clockBackGlow = o.clockBackGlow;
				$this.clockSeconds = o.clockSeconds;
				$this.clockSecondsAnime = o.clockSecondsAnime;
                $this.timeUpdate = '';
                $this.displayClock($this);           

				var largeur = $this.parents('div').width();
				largeur = parseFloat(largeur)+30;
				
            });
        }
    });
   

    $.fn.displayClock = function(el) {
        $.fn.getTime(el);
        setTimeout(function() {$.fn.displayClock(el)}, $.fn.delay(el));
    }

    $.fn.delay = function(el) {
        var now = new Date();
		var delay;
		if (el.clockSeconds == '1') {
			delay = 1000;
		} else {
			delay = (60 - now.getSeconds()) * 1000;
		}
		return delay;
    }

    $.fn.getTime = function(el) {
		// Declarations
        var now = new Date();
        var old = new Date();
        var now_hours, now_minutes, now_seconds, old_hours, old_minutes, old_seconds, timeOld = '';
		
		// Creation old time
		if (el.clockSeconds == '1') {
          	if (el.clockSecondsAnime == '0') {
				old.setTime(now.getTime() - 1000);
            } else {
              	old.setTime(now.getTime());
              now.setTime(now.getTime() + 1000);
            }
		} else {
			old.setTime(now.getTime() - 60000);
		}
        
		// Creation variables
        now_hours =  now.getHours();
        now_minutes = now.getMinutes();
		now_seconds = now.getSeconds();
        old_hours =  old.getHours();
        old_minutes = old.getMinutes();
		old_seconds = old.getSeconds();

		// Ajout du zero si 1 seul chiffre
        now_hours   = ((now_hours <  10) ? "0" : "") + now_hours;
        now_minutes = ((now_minutes <  10) ? "0" : "") + now_minutes;
		now_seconds = ((now_seconds <  10) ? "0" : "") + now_seconds;
        old_hours   = ((old_hours <  10) ? "0" : "") + old_hours;
        old_minutes = ((old_minutes <  10) ? "0" : "") + old_minutes;
		old_seconds = ((old_seconds <  10) ? "0" : "") + old_seconds;
		
        // Creation et traduction date
		el.currDate = el.lang.dayNames[now.getDay()] + '&nbsp;' + now.getDate() + '&nbsp;' + el.lang.monthNames[now.getMonth()];
        // Creation time update
        el.timeUpdate = el.currDate + ',&nbsp;' + now_hours + ':' + now_minutes;
		
		// Creations des digits
        var firstHourDigit = old_hours.substr(0,1);
        var secondHourDigit = old_hours.substr(1,1);
        var firstMinuteDigit = old_minutes.substr(0,1);
        var secondMinuteDigit = old_minutes.substr(1,1);
		var firstSecondDigit = old_seconds.substr(0,1);
        var secondSecondDigit = old_seconds.substr(1,1);
		if (el.clockSecondsAnime == '0' && now.getSeconds() != 00) {
			old.setTime(now.getTime());
			old_seconds = old.getSeconds();
			old_seconds = ((old_seconds <  10) ? "0" : "") + old_seconds;
			firstSecondDigit = old_seconds.substr(0,1);
            secondSecondDigit = old_seconds.substr(1,1);
		}
				
		// Construction graphique
		timeOld = '';
		if (el.clockSeconds == '1') {
			timeOld += '<div id="backseconds_bg"><img src="' + el.clockImagesBackPath + el.clockBackGlow + 'back' + el.clockBack + '.png" /></div>';
			timeOld += '<div id="backseconds2_bg"><div id="backseconds2b_bg"><img src="' + el.clockImagesBackPath + el.clockBackGlow + 'back' + el.clockBack + '.png" /></div></div>';
		} else {
			timeOld += '<div id="back_bg"><img src="' + el.clockImagesBackPath + el.clockBackGlow + 'back' + el.clockBack + '.png" /></div>';
		}
		timeOld += '<div id="dots_bg"><img src="' + el.clockImagesDotsPath + 'dots' + el.clockDots + '.png" /></div>';
		if (el.clockSeconds == '1') {
			timeOld += '<div id="dots2_bg"><img src="' + el.clockImagesDotsPath + 'dots' + el.clockDots + '.png" /></div>';
		}
		timeOld += '<div id="hours"><div class="line' + el.clockType + '" ></div>';
        timeOld += '<div id="hours_bg"><img src="' + el.clockImagesPath + el.clockGlow + 'clockbg1.png" /></div>';
        timeOld += '<img src="' + el.clockImagesNumPath + firstHourDigit + '.png" id="fhd" class="first_digit" />';
        timeOld += '<img src="' + el.clockImagesNumPath + secondHourDigit + '.png" id="shd" class="second_digit" />';
        timeOld += '</div>';
        timeOld += '<div id="minutes"><div class="line' + el.clockType + '" ></div>';
        timeOld += '<div id="minutes_bg"><img src="' + el.clockImagesPath + el.clockGlow + 'clockbg1.png" /></div>';
        timeOld += '<img src="' + el.clockImagesNumPath + firstMinuteDigit + '.png" id="fmd" class="first_digit" />';
        timeOld += '<img src="' + el.clockImagesNumPath + secondMinuteDigit + '.png" id="smd" class="second_digit" />';
        timeOld += '</div>';
		if (el.clockSeconds == '1') {
			timeOld += '<div id="seconds"><div class="line' + el.clockType + '" ></div>';
			timeOld += '<div id="seconds_bg"><img src="' + el.clockImagesPath + el.clockGlow + 'clockbg1.png" /></div>';
			timeOld += '<img src="' + el.clockImagesNumPath + firstSecondDigit + '.png" id="fsd" class="first_digit" />';
			timeOld += '<img src="' + el.clockImagesNumPath + secondSecondDigit + '.png" id="ssd" class="second_digit" />';
			timeOld += '</div>';
		}
		
		// Construction date		
		//timeOld += '<center><p id="date"></p></center>';
		
		// Finalisation html
        el.find('#clock').html(timeOld);
		el.find('#date').html(el.currDate);

		// Animation des secondes
		if ((el.clockSeconds == '1' && el.clockSecondsAnime == '1') || now_seconds == '00') {
			if (secondSecondDigit != '9') {
				firstSecondDigit = firstSecondDigit + '1';
			}
			if (old_seconds == '59') {
				firstSecondDigit = '511';
			}
			//
			setTimeout(function() {
				$('#fsd').attr('src', el.clockImagesNumPath + firstSecondDigit + '-1.png');
				$('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg2.png');
			},200);
			setTimeout(function() { $('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg3.png')},250);
			setTimeout(function() {
				$('#fsd').attr('src', el.clockImagesNumPath + firstSecondDigit + '-2.png');
				$('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg4.png');
			},400);
			setTimeout(function() { $('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg5.png')},350);
			setTimeout(function() {
				$('#fsd').attr('src', el.clockImagesNumPath + firstSecondDigit + '-3.png');
				$('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg6.png');
			},600);
			//
			setTimeout(function() {
				$('#ssd').attr('src', el.clockImagesNumPath + secondSecondDigit + '-1.png');
				$('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg2.png');
			},200);
			setTimeout(function() { $('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg3.png')},250);
			setTimeout(function() {
				$('#ssd').attr('src', el.clockImagesNumPath + secondSecondDigit + '-2.png');
				$('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg4.png');
			},400);
			setTimeout(function() { $('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg5.png')},350);
			setTimeout(function() {
				$('#ssd').attr('src', el.clockImagesNumPath + secondSecondDigit + '-3.png');
				$('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg6.png');
			},600);
			//
			setTimeout(function() {$('#fsd').attr('src', el.clockImagesNumPath + now_seconds.substr(0,1) + '.png')},700);
			setTimeout(function() {$('#ssd').attr('src', el.clockImagesNumPath + now_seconds.substr(1,1) + '.png')},700);
			setTimeout(function() { $('#seconds_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg1.png')},750);
		}
		
        // Animation des minutes
		if (now_seconds == '00') {
			if (secondMinuteDigit != '9') {
				firstMinuteDigit = firstMinuteDigit + '1';
			}
			if (old_minutes == '59') {
				firstMinuteDigit = '511';
			}
			//
			setTimeout(function() {
				$('#fmd').attr('src', el.clockImagesNumPath + firstMinuteDigit + '-1.png');
				$('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg2.png');
			},200);
			setTimeout(function() { $('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg3.png')},250);
			setTimeout(function() {
				$('#fmd').attr('src', el.clockImagesNumPath + firstMinuteDigit + '-2.png');
				$('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg4.png');
			},400);
			setTimeout(function() { $('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg5.png')},450);
			setTimeout(function() {
				$('#fmd').attr('src', el.clockImagesNumPath + firstMinuteDigit + '-3.png');
				$('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg6.png');
			},600);
			//
			setTimeout(function() {
				$('#smd').attr('src', el.clockImagesNumPath + secondMinuteDigit + '-1.png');
				$('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg2.png');
			},200);
			setTimeout(function() { $('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg3.png')},250);
			setTimeout(function() {
				$('#smd').attr('src', el.clockImagesNumPath + secondMinuteDigit + '-2.png');
				$('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg4.png');
			},400);
			setTimeout(function() { $('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg5.png')},450);
			setTimeout(function() {
				$('#smd').attr('src', el.clockImagesNumPath + secondMinuteDigit + '-3.png');
				$('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg6.png');
			},600);
			//
			setTimeout(function() {$('#fmd').attr('src', el.clockImagesNumPath + now_minutes.substr(0,1) + '.png')},800);
			setTimeout(function() {$('#smd').attr('src', el.clockImagesNumPath + now_minutes.substr(1,1) + '.png')},800);
			setTimeout(function() { $('#minutes_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg1.png')},850);
		}
		
        // Animation des heures
        if (now_minutes == '00' && now_seconds == '00') {
           	if (now_hours != '10') {
				firstHourDigit = firstHourDigit + '1';
			}
			if (now_hours == '20') {
				firstHourDigit = '1';
			}
			if (now_hours == '00') {
				firstHourDigit = firstHourDigit + '1';
				secondHourDigit = secondHourDigit + '11';
			}
			//
            setTimeout(function() {
                $('#fhd').attr('src', el.clockImagesNumPath + firstHourDigit + '-1.png');
                $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg2.png');
            },200);
            setTimeout(function() { $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg3.png')},250);
            setTimeout(function() {
                $('#fhd').attr('src', el.clockImagesNumPath + firstHourDigit + '-2.png');
                $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg4.png');
            },400);
            setTimeout(function() { $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg5.png')},450);
            setTimeout(function() {
                $('#fhd').attr('src', el.clockImagesNumPath + firstHourDigit + '-3.png');
                $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg6.png');
            },600);
			//
            setTimeout(function() {
            $('#shd').attr('src', el.clockImagesNumPath + secondHourDigit + '-1.png');
            $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg2.png');
            },200);
            setTimeout(function() { $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg3.png')},250);
            setTimeout(function() {
                $('#shd').attr('src', el.clockImagesNumPath + secondHourDigit + '-2.png');
                $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg4.png');
            },400);
            setTimeout(function() { $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg5.png')},450);
            setTimeout(function() {
                $('#shd').attr('src', el.clockImagesNumPath + secondHourDigit + '-3.png');
                $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg6.png');
            },600);
			//
            setTimeout(function() {$('#fhd').attr('src', el.clockImagesNumPath + now_hours.substr(0,1) + '.png')},800);
            setTimeout(function() {$('#shd').attr('src', el.clockImagesNumPath + now_hours.substr(1,1) + '.png')},800);
            setTimeout(function() { $('#hours_bg img').attr('src', el.clockImagesPath + el.clockGlow + 'clockbg1.png')},850);
        }
    }

})(jQuery);