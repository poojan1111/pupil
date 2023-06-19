<?php
//get_template_part('templates/chat/chat');
?>
<script>
	jQuery(function($) {
		jQuery(".advance-search").on("click", function() {
		    jQuery(".advance-filds").css('display', 'flex').hide().fadeIn("slow");;

		});
		jQuery(".advance-less").on("click", function() {
			var advanceFields = $(".advance-filds");

		advanceFields.fadeOut("slow", function() {
				advanceFields.css("display", "none");
			});
		});
	});

// 	$(document).ready(function() {
//   $('.vehica-search-classic-v2-mask-bottom').click(function() {
//     $(this).toggleClass('active');
//     // Additional code to toggle the menu or perform other actions
//   });
// });
</script>
<?php wp_footer(); ?>
</body>
</html>