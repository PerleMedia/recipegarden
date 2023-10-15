<?php
/**
 * The template for displaying recipe posts
 */

get_header();
?>

	<main id="content" class="site-main single-recipe">
		
		<?php
		while ( have_posts() ) :
			the_post();

			// Post Meta
			$title = esc_html(get_the_title());
			$image = get_the_post_thumbnail();
			$image_url = get_the_post_thumbnail_url();

			// Recipe Filters
			$cuisineAr = [];
			$courseAr = [];
			$dietAr = [];
			$tagAr = [];

			$cuisines = get_the_terms( $post->ID, 'recipe-cuisines');
			if ($cuisines){
				foreach($cuisines as $cuisine) {
					$parent = get_term_by( 'term_id', $cuisine->parent, 'recipe-cuisines');
					array_push($cuisineAr, $cuisine->name); 
					if ($cuisine->parent != 0){
						array_push($cuisineAr, $parent->name); 
					}
				} 
			}
			

			$courses = get_the_terms( $post->ID, 'recipe-courses' );
			if ($courses){
				foreach($courses as $course) {
					array_push($courseAr, $course->name); 
				} 
			}
			

			$diets = get_the_terms( $post->ID, 'recipe-diets' );
			if ($diets){
				foreach($diets as $diet) {
					array_push($dietAr, $diet->name); 
				} 
			}
			

			$tags = get_the_terms( $post->ID, 'recipe-tags' );
			if ($tags){
				foreach($tags as $tag) {
					array_push($tagAr, $tag->name); 
				} 
			}
			

			// ACF Fields
			$serving_size = get_field('serving_size');
			$cooking_time = get_field('cooking_time');
			$calories = get_field('calories');
			$nutrition = get_field('nutritional_information');
			$fat = $nutrition['fat'];
			$saturates = $nutrition['saturates'];
			$sugar = $nutrition['sugar'];
			$protein = $nutrition['protein'];
			$carbs = $nutrition['carbs'];
			$fiber = $nutrition['fiber'];

			// Macro Targets & Calculations
			$macro_cals = get_field('macros_calories', 'options');
			$macro_carbs = get_field('macros_carbs', 'options');
			$macro_protein = get_field('macros_protein', 'options');
			$macro_fats = get_field('macros_fats', 'options');
			$macro_fiber = get_field('macros_fibre', 'options');
			$percent_cals = round((($calories / $macro_cals) * 100), 1);
			$percent_carbs = round((($carbs / $macro_carbs) * 100), 1);
			$percent_protein = round((($protein / $macro_protein) * 100), 1);
			$percent_fats = round((($fat / $macro_fats) * 100), 1);
			$percent_fiber = round((($fiber / $macro_fiber) * 100), 1);

			

			// Create Ingredients Objects
			$ingredientsObj = get_field('ingredients'); 
			$ingredientsAr = [];
			foreach ($ingredientsObj as $ingredient){
				$newQty = $ingredient['quantity'];
				$newMsr = $ingredient['measurement'];
				$newIng = $ingredient['ingredient']->name;
				$typeId = $ingredient['ingredient']->parent;
				$inType = get_term_by( 'term_id', $typeId, 'recipe-ingredients');
				$newNot = $ingredient['notes'];

				if ($newNot) {
					$newNot = '(' . $newNot . ')';
				}

				if ($inType->name == "Protein"){
					$inType = 1;
				} elseif ($inType->name == "Vegetable"){
					$inType = 2;
				} elseif ($inType->name == "Fruit"){
					$inType = 3;
				} elseif ($inType->name == "Dairy"){
					$inType = 4;
				} elseif ($inType->name == "Grains"){
					$inType = 5;
				} elseif ($inType->name == "Herbs"){
					$inType = 6;
				} elseif ($inType->name == "Seasoning"){
					$inType = 7;
				} elseif ($inType->name == "Fridge"){
					$inType = 8;
				} elseif ($inType->name == "Pantry"){
					$inType = 9;
				} 

				$newObj = (object) array(
					"parent" => $inType,
					"quantity" => $newQty,
					"measurement" => $newMsr,
					"ingredient" => $newIng,
					"note" => $newNot
				);
				array_push($ingredientsAr, $newObj);
			};

			// Sort Ingredients Array
			usort($ingredientsAr, function($a, $b){
				return $a->parent - $b->parent;
			});
			

			$instructionsObj = get_field('instructions');
			$instructionsAr = [];
			foreach ($instructionsObj as $step){
				array_push($instructionsAr, $step['step']);
			};
			
			// var_dump($ingredientsAr);
			// var_dump($ingredientsObj);
			?>


			<article>
				<div class="recipe-card">

					<div class="card-header">
						

						<div class="image-wrapper">
							<?php echo $image?>
						</div><!-- .image-wrapper -->
						
						<div class="title-wrapper">
							<h1><?php echo $title?></h1>
							<div class="card-meta row cols-2">
							
								<div class="calories">
									<span class="caption"><?php echo $calories?> calories</span>
								</div>
								<div class="time">
								<span class="caption"><?php echo $cooking_time?> minutes</span>
								</div>
								
						
							</div><!-- .card-meta -->
						</div><!-- .title-wrapper -->

						
						
					</div><!-- .card-header -->
					

					

					<div class="card-body">
						<div class="site-container">
							<div class="card-servings row">
								<span class="caption">Servings:</span> 
								<input id="serving-size" type="number" value="<?php echo $serving_size?>">
								<button id="add-recipe">Add to plan</button>
							</div><!-- .card-servings -->

							<span id="mealplan-success"><i>This has been added to your <a href="/planner">mealplan</a></i></span>

						</div><!-- .site-container -->

						<div id="card-tabs" class="row cols-3">
							<div class="tab-title tab-ingredients active" data-tab="card-ingredients">
								<h2 class="caption">Ingredients</h2>
							</div>
							<div class="tab-title tab-instructions" data-tab="card-instructions">
								<h2 class="caption">Instructions</h2>
							</div>
							<div class="tab-title tab-nutrition" data-tab="card-nutrition">
								<h2 class="caption">Nutrition</h2>
							</div>
						</div>

						<div class="card-ingredients card-content active">
							<div class="site-container">
								<table>
									<?php 
										$allIngredients = array();
										$finalIngredient;
										foreach ($ingredientsAr as $ingredient){
											echo '<tr class="ing">';
											echo '<td class="ingredient-qty"><span class="ingredient-quantity">' . $ingredient->quantity . '</span> <span class="ingredient-measurement">' . $ingredient->measurement . '</span></td>';
											echo '<td class="ingredient-name"><span class="ingredient-name">' . $ingredient->ingredient . '</span> </td>';
											echo '<td class="ingredient-notes"><span class="ingredient-notes">' . $ingredient->note . '</span> </td>';
											echo '</td>';
											echo '</tr>';
											$finalIngredient = $ingredient->quantity . ' ' . $ingredient->measurement . ' ' . $ingredient->ingredient;
											array_push($allIngredients, $finalIngredient);
										}
									?>
								</table>
							</div><!-- .site-container -->
						</div><!-- .card-ingredients -->

						<div class="card-instructions card-content">
							<div class="site-container">
								<?php if( have_rows('instructions') ): ?>
									<ol>
									<?php 
										$allInstructions = array();
										$finalInstruction = new stdClass();

										while( have_rows('instructions') ) : the_row();
											$step = get_sub_field('step');
											$finalInstruction->{'@type'} = 'HowToStep';
											$finalInstruction->name = $step;
											array_push($allInstructions, $finalInstruction);?>
										
											<li><?php echo $step?></li>

									<?php 
										endwhile; 
										?>	
									</ol>
								<?php endif; ?>
							</div><!-- .site-container -->
						</div><!-- .card-instructions -->

						<div class="card-nutrition card-content">
							<div class="site-container">
								<div class="card-meta row cols-1">
									<div class="col">
										<?php if (count($cuisineAr) > 0){
											?>
												<strong>Cuisines:</strong>
												<span>
													<?php 
														echo implode(", ", $cuisineAr)
													?>
												</span>
											<?php
										}?>
									</div>
									<div class="col">
										<?php if (count($courseAr) > 0){
											?>
												<strong>Courses:</strong>
												<span>
													<?php 
														echo implode(", ", $courseAr)
													?>
												</span>
											<?php
										}?>
									</div>
									<div class="col">
										<?php if (count($dietAr) > 0){
											?>
												<strong>Diets:</strong>
												<span>
													<?php 
														echo implode(", ", $dietAr)
													?>
												</span>
											<?php
										}?>
									</div>
									<div class="col">
										
										<?php if (count($tagAr) > 0){
											?>
												<strong>Tags:</strong>
												<span>
													<?php 
														echo implode(", ", $tagAr)
													?>
												</span>
											<?php
										}?>
									</div>
								
								</div><!-- .card-meta -->

								<div class="nutrition-table row cols-3">
									<div class="fat">
										Fat:
										<?php echo $fat?>g
									</div>
									<div class="saturates">
										Saturates:
										<?php echo $saturates?>g
									</div>
									<div class="sugar">
										Sugars:
										<?php echo $sugar?>g
									</div>
									<div class="protein">
										Protein:
										<?php echo $protein?>g
									</div>
									<div class="carbs">
										Carbs:
										<?php echo $carbs?>g
									</div>
									<div class="fiber">
										Fiber:
										<?php echo $fiber?>g
									</div>
								</div><!-- .nutrition-table -->

								
								<div class="nutrition-charts row cols-5">
									<div class="macros">
										<div class="chart-container">
											<div class="circle">
												<div class="circle-fill" style="height:<?php echo $percent_cals . '%' ?>">
													<span class="chart-label"><?php echo "$percent_cals%" ?></span>
												</div>
											</div>
										</div>
										<div class="chart-title">
											Calories
										</div>
									</div>

									<div class="macros">
										<div class="chart-container">
											<div class="circle">
												<div class="circle-fill" style="height:<?php echo $percent_carbs . '%' ?>">
													<span class="chart-label"><?php echo "$percent_carbs%" ?></span>
												</div>
											</div>
										</div>
										<div class="chart-title">
											Carbs
										</div>
									</div>

									<div class="macros">
										<div class="chart-container">
											<div class="circle">
												<div class="circle-fill" style="height:<?php echo $percent_protein . '%' ?>">
													<span class="chart-label"><?php echo "$percent_protein%" ?></span>
												</div>
											</div>
										</div>
										<div class="chart-title">
											Protein
										</div>
									</div>

									<div class="macros">
										<div class="chart-container">
											<div class="circle">
												<div class="circle-fill" style="height:<?php echo $percent_fats . '%' ?>">
													<span class="chart-label"><?php echo "$percent_fats%" ?></span>
												</div>
											</div>
										</div>
										<div class="chart-title">
											Fat
										</div>
									</div>

									<div class="macros">
										<div class="chart-container">
											<div class="circle">
												<div class="circle-fill" style="height:<?php echo $percent_fiber . '%' ?>">
													<span class="chart-label"><?php echo "$percent_fiber%" ?></span>
												</div>
											</div>
										</div>
										<div class="chart-title">
											Fiber
										</div>
									</div>
								</div><!-- .nutrition-charts -->
							</div><!-- .site-container -->
						</div><!-- .card-nutrition -->

						
					</div><!-- .card-body -->
			
	
				</div><!-- .recipe-card -->
			</article>



		<? endwhile; // End of the loop.
		?>
		
		
	</main><!-- #main -->

	<script>

		const passedIngredients = <?php echo json_encode($ingredientsAr); ?>;
		const passedServings = <?php echo json_encode($serving_size); ?>;

		let servingsMultiplier = 0;
		let quantityArray = document.querySelectorAll('.ingredient-quantity');

		document.getElementById('serving-size').addEventListener('change', function({target}){
			servingsMultiplier = target.value / passedServings;

			for (let i = 0; i < passedIngredients.length; i++){
				if (passedIngredients[i].quantity){
					quantityArray[i].innerHTML = passedIngredients[i].quantity * servingsMultiplier;
				}
			}
		})

	</script>

	<script>
		// Add recipe to mealplan logic
		let servings;
		let postId = <?php echo json_encode($post->ID); ?>;

		document.getElementById('add-recipe').addEventListener('click', e => {
			servings = Math.ceil(document.getElementById('serving-size').value);
			let plannerRecipes = localStorage.getItem('recipeList') ? JSON.parse(localStorage.getItem('recipeList')) : [];
			
			for (let i = 0; i < servings; i++){
				plannerRecipes.push(postId);
			}

			plannerRecipes = JSON.stringify(plannerRecipes);
			localStorage.setItem('recipeList', plannerRecipes);

			setCookie('recipeList', plannerRecipes, 14);

			document.getElementById('mealplan-success').style.display = "block";
		})

		// Click tab
		let tabs = document.querySelectorAll('.tab-title');
		let tabContent = document.querySelectorAll('.card-content');
		let activeTab;

		tabs.forEach(tab => {
			tab.addEventListener('click', function(e){
				e.preventDefault();
				let clickedElement;
				if (!e.target.classList.contains('.tab-title')){
					clickedElement = e.target.parentNode
				} else clickedElement = e.target
				if (!clickedElement.classList.contains('active')){
					for (let i = 0; i < tabs.length; i++){
						tabs[i].classList.remove('active');
					}
					clickedElement.classList.add('active');
				}

				activeTab = document.querySelector('.tab-title.active');
				activeClass = '.' + activeTab.getAttribute('data-tab');
				console.log(activeClass);
				console.log(document.querySelector(activeClass));

				for (let i = 0; i < tabContent.length; i++){
					tabContent[i].classList.remove('active');
				}
				document.querySelector(activeClass).classList.add('active');

			})
		})

		
		
	</script>

<script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Recipe",
      "name": <?php echo json_encode($title); ?>,
      "image": [
        <?php echo json_encode($image_url); ?>
      ],
      "totalTime": <?php echo json_encode($cooking_time); ?>,
      "recipeYield": <?php echo json_encode($serving_size); ?>,
      "recipeCategory": <?php echo json_encode($courseAr); ?>,
      "recipeCuisine":  <?php echo json_encode($cuisineAr); ?>,
      "nutrition": {
        "@type": "NutritionInformation",
        "calories": <?php echo json_encode($calories . " calories"); ?>
      },
      "recipeIngredient": <?php echo json_encode($allIngredients); ?>,
      "recipeInstructions": <?php echo json_encode($allInstructions); ?>
    }
    </script>

<?php
get_footer();


