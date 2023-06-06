<?php
/**
 * The template for displaying the custom front page
 */

get_header();
?>

	<main id="content" class="site-main front-page">
		<div class="site-container">
			hello1

		</div><!-- .site-container -->
	</main><!-- #content -->

	<script>
		const searchtitles = <?php echo json_encode($search_titles); ?>;
		const ingredient = <?php echo json_encode($ingredient); ?>;
		const filtercalsmin = <?php echo json_encode($cals_min); ?>;
		const cuisines = <?php echo json_encode($cuisines); ?>;
		const courses = <?php echo json_encode($courses); ?>;
		const diets = <?php echo json_encode($diets); ?>;
		const tags = <?php echo json_encode($tags); ?>;
		const filteredPosts = <?php echo json_encode($filteredPosts); ?>;

		let allLabels = [];
		let labelAr = [];
		allLabels.push(...cuisines, ...courses, ...diets, ...tags);
		allLabels.forEach(label => {
			document.getElementById(label).classList.add('active')
			labelAr.push(document.getElementById(label));
		});
		labelAr.forEach(label => {
			label.children[0].checked = true;
		});

		let filterLabels = document.querySelectorAll('.label-button');
		filterLabels.forEach(label => {
			label.addEventListener('click', function(e){
				e.preventDefault();
				label.classList.toggle('active');
				let input = label.children[0];
				if (input.checked){
					input.checked = false;
				} else input.checked = true;
			})
		})

		let filters = document.querySelectorAll('.filter');
		filters.forEach(filter => {
			filter.addEventListener('click', function(e){
				let conditions = e.target.classList.contains('accordion-content') || e.target.classList.contains('label-button');
				e.preventDefault();
				if (!conditions){
					for (let i = 0; i < filters.length; i++){
						// console.log(e.target == filters[i].querySelector('.filter-label'));
						// console.log();
						filters[i].classList.remove('active');
						filters[i].querySelector('.accordion-expand').innerHTML = '+';
					} 
					filter.classList.add('active');
					filter.querySelector('.accordion-expand').innerHTML = "-";
					
				} 
				countFilters();
			})
		})

	</script>
<?php
get_footer();
