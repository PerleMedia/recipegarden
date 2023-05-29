<?php
/**
 * The template for displaying the custom front page
 */

get_header();
?>

	<main id="content" class="site-main front-page">
		<div class="site-container">

		<div class="filter">
			<div class="tool-wrapper">

				<form action="/" autocomplete="off" method='POST' class="row cols-2"> 
					<input type="text" id="search-titles" name="search-titles" placeholder="Search..." value="<?php if(isset($_POST['search-titles'])) { echo $_POST['search-titles']; } ?>"></input>
					<button id="search-recipes" type="submit" value="search">
						<svg id="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 343.05 342.94"><title>search-icon</title><path d="M140.1,280a139.26,139.26,0,0,0,86.36-29.91l92.84,92.85,23.75-23.74L250.2,226.35A140,140,0,1,0,140.1,280Zm0-246.4A106.4,106.4,0,1,1,64.87,64.76,106.41,106.41,0,0,1,140.1,33.6Z"/></svg>
					</button>
					
				</form> 

				<button id="filter-recipes" onclick="filterToggle()">
					<svg id="filter-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 444.52 378.56"><defs><style>.cls-1{fill:none;}.cls-2{clip-path:url(#clip-path);}</style><clipPath id="clip-path" transform="translate(12.3)"><rect class="cls-1" x="-0.55" width="419.35" height="378.56"/></clipPath></defs><title>filter-icon</title><g class="cls-2"><path d="M62.18,41.44v22.4H-1.09a11.23,11.23,0,0,1-11.2-11.2,11.23,11.23,0,0,1,11.2-11.2Z" transform="translate(12.3)"/><path d="M432.22,52.64A11.23,11.23,0,0,1,421,63.84H127V41.44H421a11.24,11.24,0,0,1,11.21,11.2Z" transform="translate(12.3)"/><path d="M41.46,0V104.72H146.18V0ZM126,84.56H62.18V20.16h64.4v64.4Z" transform="translate(12.3)"/><path d="M265.46,178.08v22.4H-1.1a11.23,11.23,0,0,1-11.2-11.2,11.23,11.23,0,0,1,11.2-11.2Z" transform="translate(12.3)"/><path d="M431.22,189.28a11.23,11.23,0,0,1-11.2,11.2H329.86v-22.4H420A11.23,11.23,0,0,1,431.22,189.28Z" transform="translate(12.3)"/><path d="M244.74,136.64V241.36H349.46V136.64Zm85.12,84.56h-64.4V156.8h64.4Z" transform="translate(12.3)"/><path d="M62.18,314.72v22.4H-1.09a11.23,11.23,0,0,1-11.2-11.2,11.23,11.23,0,0,1,11.2-11.2Z" transform="translate(12.3)"/><path d="M432.22,325.92a11.23,11.23,0,0,1-11.2,11.2H127v-22.4H421a11.24,11.24,0,0,1,11.21,11.2Z" transform="translate(12.3)"/><path d="M41.46,273.84V378.56H146.18V273.84ZM126,358.4H62.18V294h64.4v64.4Z" transform="translate(12.3)"/></g></svg>
				</button>

				
				
			</div><!-- .tool-wrapper -->

			<div id="filter-wrapper">
				<div class="filter calories">
					<label class="caption">By Calories</label>
					<label class="caption">By Cuisines</label>
					<label class="caption">By Courses</label>
					<label class="caption">By Diets</label>
					<label class="caption">By Tags</label>
				</div>
			</div><!-- .filter-wrapper -->

		</div><!-- .filter -->

		<div class="wrapper row cols-3">

			<?php
			$posts = get_posts([
				'post_type' => 'recipes',
				'post_status' => 'publish',
				'numberposts' => -1,
				'order'    => 'DESC'
			]);


			// var_dump($posts);

			foreach ($posts as $post){
				if ($_POST['search-titles']){
					if (strpos(strtolower($post->post_title), strtolower($_POST['search-titles']))){
						include('template-parts/includes/recipe-grid.php');
					}
				} else {
					include('template-parts/includes/recipe-grid.php');
				}
				
			}?>
		</div>

		</div><!-- .site-container -->
	</main><!-- #content -->

	<script>
		function filterToggle() {
			let wrapper = document.getElementById('filter-wrapper');
			wrapper.classList.toggle('active');
		}
	</script>
<?php
get_footer();
