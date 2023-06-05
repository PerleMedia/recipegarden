<?php
/**
 * The template for displaying the custom front page
 */

get_header();
?>

	<main id="content" class="site-main front-page">
		<div class="site-container">
			<form id="filter-form" class="filter-form" autocomplete="off" method='POST'>
				<div class="tool-wrapper">

					<div class="search row cols-2"> 
						<input type="text" id="search-titles" name="search-titles" placeholder="Search..." value="<?php if(isset($_POST['search-titles'])) { echo $_POST['search-titles']; } ?>"></input>
						<!-- <button id="search-recipes" type="submit" value="search" class="button">
							<svg id="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 343.05 342.94"><title>search-icon</title><path d="M140.1,280a139.26,139.26,0,0,0,86.36-29.91l92.84,92.85,23.75-23.74L250.2,226.35A140,140,0,1,0,140.1,280Zm0-246.4A106.4,106.4,0,1,1,64.87,64.76,106.41,106.41,0,0,1,140.1,33.6Z"/></svg>
						</button> -->
						<span class="button" id="filter-recipes" onclick="filterToggle()">
							<svg id="filter-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 444.52 378.56"><defs><style>.cls-1{fill:none;}.cls-2{clip-path:url(#clip-path);}</style><clipPath id="clip-path" transform="translate(12.3)"><rect class="cls-1" x="-0.55" width="419.35" height="378.56"/></clipPath></defs><title>filter-icon</title><g class="cls-2"><path d="M62.18,41.44v22.4H-1.09a11.23,11.23,0,0,1-11.2-11.2,11.23,11.23,0,0,1,11.2-11.2Z" transform="translate(12.3)"/><path d="M432.22,52.64A11.23,11.23,0,0,1,421,63.84H127V41.44H421a11.24,11.24,0,0,1,11.21,11.2Z" transform="translate(12.3)"/><path d="M41.46,0V104.72H146.18V0ZM126,84.56H62.18V20.16h64.4v64.4Z" transform="translate(12.3)"/><path d="M265.46,178.08v22.4H-1.1a11.23,11.23,0,0,1-11.2-11.2,11.23,11.23,0,0,1,11.2-11.2Z" transform="translate(12.3)"/><path d="M431.22,189.28a11.23,11.23,0,0,1-11.2,11.2H329.86v-22.4H420A11.23,11.23,0,0,1,431.22,189.28Z" transform="translate(12.3)"/><path d="M244.74,136.64V241.36H349.46V136.64Zm85.12,84.56h-64.4V156.8h64.4Z" transform="translate(12.3)"/><path d="M62.18,314.72v22.4H-1.09a11.23,11.23,0,0,1-11.2-11.2,11.23,11.23,0,0,1,11.2-11.2Z" transform="translate(12.3)"/><path d="M432.22,325.92a11.23,11.23,0,0,1-11.2,11.2H127v-22.4H421a11.24,11.24,0,0,1,11.21,11.2Z" transform="translate(12.3)"/><path d="M41.46,273.84V378.56H146.18V273.84ZM126,358.4H62.18V294h64.4v64.4Z" transform="translate(12.3)"/></g></svg>
						</span>
					</div> 

				</div><!-- .tool-wrapper -->

				<div id="filter-wrapper">
					<div class="header-container">
						<div class="filter-header row">
							<h2 class="caption">Filter</h2>
							<a class="button" href="/">Clear</a>
							<button id="filter-recipes" type="submit" class="button">Filter</button>
						</div>
					</div>

					<div class="filter">
						<div class="caption filter-label">By Ingredient <span class="accordion-expand">&#65291;</span></div>
						<div class="accordion-content">
							<select id="filter-form" class="label-button" name="filter-ingredient">
								<?php if(isset($_POST['filter-ingredient'])) { echo '<option value="'. $_POST['filter-ingredient'] . '">' . $_POST['filter-ingredient'] . '</option>'; } else { echo 'All';} ?>
								<option value="">All</option>
								<?php
									$allIngredients = get_terms(['taxonomy' => 'recipe-ingredients', 'hide_empty' => true]);
									foreach ($allIngredients as $ingredient) {
										echo '<option value="';
										echo $ingredient->name;
										echo '">';
										echo $ingredient->name;
										echo '</option>';
									}
									
								?>
							</select>
						</div>
					</div>

					<div class="filter">
						<div class="caption filter-label">By Calories <span class="accordion-expand">&#65291;</span></div>
						<div class="accordion-content calories"> 
							<input type="number" class="label-button" name="filter-cals-min" placeholder="Minimum" value="<?php if(isset($_POST['filter-cals-min'])) { echo $_POST['filter-cals-min']; } ?>"></input>
							<input type="number" class="label-button" name="filter-cals-max" placeholder="Maximum" value="<?php if(isset($_POST['filter-cals-max'])) { echo $_POST['filter-cals-max']; } ?>"></input>
						</div> 
					</div>

					
					<div class="filter">
						<div class="caption filter-label">By Cuisines <span class="accordion-expand">&#65291;</span></div>
						<div class="accordion-content">
							<?php
								$allCuisines = get_terms(['taxonomy' => 'recipe-cuisines', 'hide_empty' => true]);
								foreach ($allCuisines as $category){
									echo '<label class="label-button" id="';
									echo $category->term_id;
									echo '"><input type="checkbox" name="filter-cuisine[]" value="';
									echo $category->term_id;
									echo '">';
									echo $category->name;
									echo '</label>';
								}
							?>
						</div>
					</div>
					

					<div class="filter">
						<div class="caption filter-label">By Courses <span class="accordion-expand">&#65291;</span></div>
						<div class="accordion-content">
							<?php
								$allCourses = get_terms(['taxonomy' => 'recipe-courses', 'hide_empty' => true]);
								foreach ($allCourses as $category){
									echo '<label class="label-button" id="';
									echo $category->term_id;
									echo '"><input type="checkbox" name="filter-course[]" value="';
									echo $category->term_id;
									echo '">';
									echo $category->name;
									echo '</label>';
								}
							?>
						</div>
					</div>
					
					
					<div class="filter">
						<div class="caption filter-label">By Diets <span class="accordion-expand">&#65291;</span></div>
						<div class="accordion-content">
							<?php
								$allDiets = get_terms(['taxonomy' => 'recipe-diets', 'hide_empty' => true]);
								foreach ($allDiets as $category){
									echo '<label class="label-button" id="';
									echo $category->term_id;
									echo '"><input type="checkbox" name="filter-diet[]" value="';
									echo $category->term_id;
									echo '">';
									echo $category->name;
									echo '</label>';
								}
							?>
						</div>
					</div>

					<div class="filter">
						<div class="caption filter-label">By Tags <span class="accordion-expand">&#65291;</span></div>
						<div class="accordion-content">
							<?php
								$allTags = get_terms(['taxonomy' => 'recipe-tags', 'hide_empty' => true]);
								foreach ($allTags as $category){
									echo '<label class="label-button" id="';
									echo $category->term_id;
									echo '"><input type="checkbox" name="filter-tag[]" value="';
									echo $category->term_id;
									echo '">';
									echo $category->name;
									echo '</label>';
								}
							?>
						</div>
					</div>
					
				</div><!-- .filter-wrapper -->

			</form><!-- .filter -->

			<div class="wrapper row cols-3">

				<?php
				$posts = get_posts([
					'post_type' => 'recipes',
					'post_status' => 'publish',
					'numberposts' => -1,
					'order'    => 'DESC'
				]);

				// For sending to JS
				$search_titles = $_POST['search-titles'];
				$ingredient = $_POST['filter-ingredient'];
				$cals_min = $_POST['filter-cals-min'];
				$cals_max = $_POST['filter-cals-max'];
				$cuisines = $_POST['filter-cuisine'] ? $_POST['filter-cuisine'] : array();
				$courses = $_POST['filter-course'] ? $_POST['filter-course'] : array();
				$diets = $_POST['filter-diet'] ? $_POST['filter-diet'] : array();
				$tags = $_POST['filter-tag'] ? $_POST['filter-tag'] : array();


				// Filter titles
				function matchName($posts) {
					function filterByName($recipe){				
						$title = strtolower($recipe->post_title);
						$titleInput = strtolower($_POST['search-titles']);
						if ($titleInput){
							return strpos($title, $titleInput) !== false;
						}
						 return $recipe;				
					}
					return array_filter($posts, 'filterByName');
				}

				// Filter ingredients
				function matchIngredient($posts) {
					function filterByIngredient($recipe){				
						$ingredientObj = get_field('ingredients', $recipe->ID);
						$recipeIngAr = array();
						foreach ($ingredientObj as $ingredient){
							array_push($recipeIngAr, $ingredient['ingredient']->name);
						}
						
						if (isset($_POST['filter-ingredient'])){
							return in_array($_POST['filter-ingredient'], $recipeIngAr);
						}
						  return $recipe;
					}
					return array_filter($posts, 'filterByIngredient');
				}

				// Filter calories
				function matchCalories($posts){
					function filterByCalories($recipe){	
						$calories = $recipe->calories;
						$calories = (int)$calories;
						$caloriesInputMin = $_POST['filter-cals-min'] ? $_POST['filter-cals-min'] : 0;
						$caloriesInputMax = $_POST['filter-cals-max'] ? $_POST['filter-cals-max'] : 10000;
						return $calories >= $caloriesInputMin && $calories <= $caloriesInputMax;
					}

					return array_filter($posts, 'filterByCalories');
				}

				// Filter cuisines
				function matchCuisines($posts){
					function filterByCuisines($recipe){
						$cuisines = get_the_terms( $recipe->ID, 'recipe-cuisines');
						if ($_POST['filter-cuisine']){
							if ($cuisines){
								foreach ($cuisines as $category){
									if (in_array($category->term_id, $_POST['filter-cuisine'])){
										return $category;
									}
								}
							}
						} else return $recipe;
					}
					return array_filter($posts, 'filterByCuisines');
				}

				// Filter courses
				function matchCourses($posts){
					function filterByCourses($recipe){
						$courses = get_the_terms( $recipe->ID, 'recipe-courses');
						if ($_POST['filter-course']){
							if ($courses){
								foreach ($courses as $category){
									if (in_array($category->term_id, $_POST['filter-course'])){
										return $category;
									}
								}
							}
						} else return $recipe;
					}
					
					return array_filter($posts, 'filterByCourses');
				}

				// Filter diets
				function matchDiets($posts){
					function filterByDiets($recipe){
						$diets = get_the_terms( $recipe->ID, 'recipe-diets');
						if ($_POST['filter-diet']){
							if ($diets){
								foreach ($diets as $category){
									if (in_array($category->term_id, $_POST['filter-diet'])){
										return $category;
									}
								}
							}
						} else return $recipe;
					}
					return array_filter($posts, 'filterByDiets');
				}

				// Filter tags
				function matchTags($posts){
					function filterByTags($recipe){
						$tags = get_the_terms( $recipe->ID, 'recipe-tags');
						if ($_POST['filter-tag']){
							if ($tags){
								foreach ($tags as $category){
									if (in_array($category->term_id, $_POST['filter-tag'])){
										return $category;
									}
								}
							}
						} else return $recipe;
					}
					return array_filter($posts, 'filterByTags');
				}


				// TEMPLATE
				// function matchCourses($posts){
				// 	function filterByCourses($recipe){			
				// 		return $recipe;		
				// 	}

				// 	var_dump(array_filter($posts, 'filterByCourses'));
				// 	// return $posts;

				// }

				$filterOne = matchName($posts);
				$filterTwo = matchCalories($filterOne);
				$filterThree = matchCuisines($filterTwo);
				$filterFour = matchCourses($filterThree);
				$filterFive = matchDiets($filterFour);
				$filterSix = matchTags($filterFive);
				$filterSeven = matchIngredient($filterSix);

				$filteredPosts = $filterSeven;

				// var_dump($filteredPosts);
				
				if ($filteredPosts){
					foreach ($filteredPosts as $post){
						include('template-parts/includes/recipe-grid.php');
					}
				} else echo 'no posts!'

				?>
			</div>

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
					filter.classList.toggle('active');
				} 
			})
		})

	</script>
<?php
get_footer();
