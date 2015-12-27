$(document).ready(function(){
	var jingleAudio = document.getElementById('audio'),
	ctrl = document.getElementById('audio-controls');
	
	ctrl.onclick = function () {	
		var pause = ctrl.innerHTML === 'pause';
		ctrl.innerHTML = pause ? 'play' : 'pause';		
		ctrl.className = pause ? 'pause' : 'play';
	
		var method = pause ? 'pause' : 'play';
		jingleAudio[method]();
	
		return false;
	};	

});