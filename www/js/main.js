$(function(){
	$.nette.init();

	randomTriangleHover = function() {
		var triangles = $('svg path');
		var triangle = triangles[Math.floor(Math.random()*triangles.length)];

		$(triangle).addClass("active");

		setTimeout(function() {
			$(triangle).removeClass('active');
			setTimeout(randomTriangleHover, Math.floor(Math.random() * (1000 - 10)) + 10);
		}, Math.floor(Math.random() * (100 - 50)) + 50);
	};

	randomTriangleHover();
});
