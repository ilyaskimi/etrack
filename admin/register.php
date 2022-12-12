<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin Login</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div class="login-container">
            <h1>Register Now!</h1>
            <form>
                <p>Username</p>
                <input type="text" name="" placeholder="Enter Username" maxlength="10">
                <div style="float:right;">
                <p>House ID</p>
                <input type="text" name="" placeholder="Enter House ID" maxlength="10">
                </div>
                <div style="float:left;">
                <p>Password</p>
                <input type="password" name="" placeholder="Enter Password" maxlength="10">
                </div>
                <div style="float:right;">
                <p>No. of Room</p>
                <input type="text" name="" placeholder="Enter Number of Room" maxlength="2">
                </div>
                <div style="float:left;">
                <p>Confirm Password</p>
                <input type="password" name="" placeholder="Enter Password" maxlength="10">
                </div>
                <div style="display:inline-block; width:45%;text-align:center;">
                <p>Landlord:</p>
                <input type="checkbox" id="landlord" name="landlord" value="yes">
                </div>
                <div style="float:left;">
                <p>Phone No.</p>
                <input type="text" name="" placeholder="Enter Phone Number" maxlength="10">
                </div>
                <input type="submit" name="" value="Register">
                <a href="#">Already Have an Account?</a>
            </form>
        </div>
    <!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>