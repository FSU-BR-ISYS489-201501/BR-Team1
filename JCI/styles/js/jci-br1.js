//custom js here
$(".parent").click(function() {
	$(this).parent().toggleClass("active");
	return false;
});

$(".path a").click(function() {
	$(".overlay,.announcement.container").fadeIn('slow');
	return false;
});
$(".close").click(function() {
	$(".overlay,.announcement.container").fadeOut('slow');
	return false;
});