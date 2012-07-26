/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

<?php
	if(isset($_GET['app'])) $app = '/'.trim($_GET['app']);
	else $app = null;
?>
var $j = jQuery.noConflict();

var windowFocus = true;
var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();

$j(document).ready(function(){
	originalTitle = document.title;
	startChatSession();

	$j([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
});

function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		chatboxtitle = chatBoxes[x];

		if ($j("#chatbox_"+chatboxtitle).css('display') != 'none') {
			if (align == 0) {
				$j("#chatbox_"+chatboxtitle).css('right', '20px');
			} else {
				width = (align)*(225+7)+20;
				$j("#chatbox_"+chatboxtitle).css('right', width+'px');
			}
			align++;
		}
	}
}

function chatWith(chatuser) {
	createChatBox(chatuser);
	$j("#chatbox_"+chatuser+" .chatboxtextarea").focus();
}

function createChatBox(chatboxtitle,minimizeChatBox) {
	if ($j("#chatbox_"+chatboxtitle).length > 0) {
		if ($j("#chatbox_"+chatboxtitle).css('display') == 'none') {
			$j("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		$j("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		return;
	}

	$j(" <div />" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
	.html('<div class="chatboxhead"><div class="chatboxtitle" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">'+extract(chatboxtitle,1)+' ('+extract(chatboxtitle,2)+')'+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">-</a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea></div>')
	.appendTo($j( "body" ));

	$j("#chatbox_"+chatboxtitle).css('bottom', '0px');

	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($j("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
		$j("#chatbox_"+chatboxtitle).css('right', '20px');
	} else {
		width = (chatBoxeslength)*(225+7)+20;
		$j("#chatbox_"+chatboxtitle).css('right', width+'px');
	}

	chatBoxes.push(chatboxtitle);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if ($j.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $j.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == chatboxtitle) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			$j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			$j('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
		}
	}

	chatboxFocus[chatboxtitle] = false;

	$j("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){
		chatboxFocus[chatboxtitle] = false;
		$j("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		$j('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		$j("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$j("#chatbox_"+chatboxtitle).click(function() {
		if ($j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
			$j("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	$j("#chatbox_"+chatboxtitle).show();
}


function chatHeartbeat(){

	var itemsfound = 0;

	if (windowFocus == false) {

		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					document.title = x+' says...';
					titleChanged = 1;
					break;
				}
			}
		}

		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
		} else {
			++blinkOrder;
		}

	} else {
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				//FIXME: add toggle all or none policy, otherwise it looks funny
				$j('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}

	$j.ajax({
	  url: "<?php echo $app; ?>/chat/heartbeat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {

		$j.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;

				if ($j("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle);
				}
				if ($j("#chatbox_"+chatboxtitle).css('display') == 'none') {
					$j("#chatbox_"+chatboxtitle).css('display','block');
					restructureChatBoxes();
				}

				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					newMessages[chatboxtitle] = true;
					newMessagesWin[chatboxtitle] = true;
					$j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+extract(item.f,1)+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}

				$j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
			}
		});

		chatHeartbeatCount++;

		if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}

		setTimeout('chatHeartbeat();',chatHeartbeatTime);
	}});
}

function closeChatBox(chatboxtitle) {
	$j('#chatbox_'+chatboxtitle).css('display','none');
	restructureChatBoxes();

	$j.post("<?php echo $app; ?>/chat/close", { chatbox: chatboxtitle} , function(data){
	});

}

function toggleChatBoxGrowth(chatboxtitle) {
	if ($j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') {

		var minimizedChatBoxes = new Array();

		if ($j.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $j.cookie('chatbox_minimized').split(/\|/);
		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) {
				newCookie += chatboxtitle+'|';
			}
		}

		newCookie = newCookie.slice(0, -1)


		$j.cookie('chatbox_minimized', newCookie);
		$j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		$j('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
		$j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
	} else {

		var newCookie = chatboxtitle;

		if ($j.cookie('chatbox_minimized')) {
			newCookie += '|'+$j.cookie('chatbox_minimized');
		}


		$j.cookie('chatbox_minimized',newCookie);
		$j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
		$j('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
	}

}

function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) {

	if(event.keyCode == 13 && event.shiftKey == 0)  {
		message = $j(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$j(chatboxtextarea).val('');
		$j(chatboxtextarea).focus();
		$j(chatboxtextarea).css('height','44px');
		if (message != '') {
			$j.post("<?php echo $app; ?>/chat/send", {to: chatboxtitle, message: message} , function(data){
				message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
				$j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+extract(username,1)+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></div>');
				$j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
			});
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$j(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$j(chatboxtextarea).css('overflow','auto');
	}

}

function startChatSession(){
	$j.ajax({
	  url: "<?php echo $app; ?>/chat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {

		username = data.username;

		$j.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;

				if ($j("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle,1);
				}

				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					$j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+extract(item.f,1)+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}
			}
		});

		for (i=0;i<chatBoxes.length;i++) {
			chatboxtitle = chatBoxes[i];
			$j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
			setTimeout('$j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}

	setTimeout('chatHeartbeat();',chatHeartbeatTime);

	}});
}

/*!
* jQuery Cookie Plugin
* https://github.com/carhartl/jquery-cookie
*
* Copyright 2011, Klaus Hartl
* Dual licensed under the MIT or GPL Version 2 licenses.
* http://www.opensource.org/licenses/mit-license.php
* http://www.opensource.org/licenses/GPL-2.0
*/
(function($) {
    $.cookie = function(key, value, options) {

        // key and at least value given, set cookie...
        if (arguments.length > 1 && (!/Object/.test(Object.prototype.toString.call(value)) || value === null || value === undefined)) {
            options = $.extend({}, options);

            if (value === null || value === undefined) {
                options.expires = -1;
            }

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setDate(t.getDate() + days);
            }

            value = String(value);

            return (document.cookie = [
                encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path ? '; path=' + options.path : '',
                options.domain ? '; domain=' + options.domain : '',
                options.secure ? '; secure' : ''
            ].join(''));
        }

        // key and possibly options given, get cookie...
        options = value || {};
        var decode = options.raw ? function(s) { return s; } : decodeURIComponent;

        var pairs = document.cookie.split('; ');
        for (var i = 0, pair; pair = pairs[i] && pairs[i].split('='); i++) {
            if (decode(pair[0]) === key) return decode(pair[1] || ''); // IE saves cookies with empty string as "c; ", e.g. without "=" as opposed to EOMB, thus pair[1] may be undefined
        }
        return null;
    };
})(jQuery);

function extract(str,elem){
	var arr = str.split('_');
	if(elem == 1) return arr[0];
	else return arr[1];
}