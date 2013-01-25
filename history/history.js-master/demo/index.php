<?
if ($_POST['one']=="true"){
echo "one<br><hr>";
exit;
}
if ($_POST['two']=="true"){
echo "two<br><hr>";
exit;
}
?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>
		History.js
	</title>
</head>
<body style="padding-bottom:40px">
	<!-- Scripts -->
	<script>if ( typeof window.JSON === 'undefined' ) { document.write('<script src="../scripts/uncompressed/json2.js"><\/script>'); }</script>
	<script src="../vendor/jquery.js"></script>
	<script src="../scripts/bundled/html4+html5/jquery.history.js"></script>

	<!-- HTML -->
	<div id="wrap">
		<!-- Intro -->
		<textarea id="log" style="width:100%;height:400px"></textarea>
		<input type="button" onclick="one()" value="one">
		<input type="button" onclick="two()" value="two">
		<ul id="buttons">
		</ul>

		<!-- Our Script -->
		<script>
			function one(){
				var poststr2="LevelName=LevelName&id=id&savelayout=true&one=true";
				$.ajax({type: "POST",async:true,url: "index.php",data: poststr2,success: function(html){$("#log").val($("#log").val()+html) ;}});
				History.pushState({state:1}, "State 1", "?state=1"); // logs {state:1,rand:"some random value"}, "State 1", "?state=1"'
			}
			function two(){
				var poststr2="LevelName=LevelName&id=id&savelayout=true&two=true";
				$.ajax({type: "POST",async:true,url: "index.php",data: poststr2,success: function(html){$("#log").val($("#log").val()+html) ;
				History.pushState({state:2}, "State 2", "?state=2"); // logs {state:1,rand:"some random value"}, "State 1", "?state=1"'

				}});
			}
			(function(window,undefined){

				var
					History = window.History, // Note: We are using a capital H instead of a lower h
					State = History.getState(),
					$log = $('#log');

				// Bind to State Change
				History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
					// Log the State
					var State = History.getState(); // Note: We are using History.getState() instead of event.state
					alert(State.url);
					History.log('statechange:', State.data, State.title, State.url);
				});

				// Prepare Buttons

			})(window);
		</script>
	</div>

</body>
</html>
