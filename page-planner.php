<?php
/**
 * The template for displaying the Planner page
 */

get_header();
?>

	<main id="content" class="site-main page-planner">
		<div class="site-container">        

        
		<?php
		while ( have_posts() ) :
			the_post();
            

			get_template_part( 'template-parts/includes/content', 'page' ); ?>

            <div id="plan-container">
                <div id="day1" class="meal-card">
                    <div id="lunch" ondrop="drop(event)" ondragover="allowDrop(event)">
                    </div>
                    <div id="dinner" ondrop="drop(event)" ondragover="allowDrop(event)">
                    </div>
                    <div id="total-calories">
                        <section>Calories: <div id="caloric-sum-1"></div></section>
                        <section>Fat: <div id="fat-sum-1"></div></section>
                        <section>Protein: <div id="protein-sum-1"></div></section>
                    </div>
                </div>

                <div id="day2" class="meal-card"  >
                    <div id="lunch" ondrop="drop(event)" ondragover="allowDrop(event)">
                    </div>
                    <div id="dinner" ondrop="drop(event)" ondragover="allowDrop(event)">
                    </div>
                    <div id="total-calories">
                        <section>Calories: <div id="caloric-sum-2"></div></section>
                        <section>Fat: <div id="fat-sum-2"></div></section>
                        <section>Protein: <div id="protein-sum-2"></div></section>
                    </div>
                </div>

                <div id="day3" class="meal-card">
                    <div id="lunch" ondrop="drop(event)" ondragover="allowDrop(event)">
                    </div>
                    <div id="dinner" ondrop="drop(event)" ondragover="allowDrop(event)">
                    </div>
                    <div id="total-calories">
                        <section>Calories: <div id="caloric-sum-3"></div></section>
                        <section>Fat: <div id="fat-sum-3"></div></section>
                        <section>Protein: <div id="protein-sum-3"></div></section>
                    </div>
                </div>
                
            </div>            

            <button id="clear-storage">Clear Storage</button>
            <div id="card-wrapper"></div>

            <?php 
            
			$recipeListIds = $_COOKIE[ 'recipeList' ];
			$recipeListIds = str_replace(array('[',']'), '', $recipeListIds);
			$recipeListIds = explode(",", $recipeListIds);

			$recipeListObjs = [];
            $recipeImgArr = [];
			foreach ($recipeListIds as $recipe){
                if ($recipe != 0){
                    $recipeObj = get_post( $recipe );

                    $thumbnail = 'thumbnail';
                    add_post_meta( $recipeObj->ID, $thumbnail, get_the_post_thumbnail_url($recipe), TRUE );

                    array_push($recipeListObjs, $recipeObj);
                    array_push($recipeImgArr, $recipeObj->$thumbnail);
                    // var_dump(get_the_post_thumbnail($recipeObj->ID));
                }
				
			}

            // var_dump($recipeImgArr);
            // var_dump($recipeListObjs);

			
            $args = array(
                'post_type' => 'recipes',
                'posts_per_page' => -1,
                'order_by' => 'date',
                'order' => 'desc'
            );            

            $query = new WP_Query($args);
            if ($query->have_posts()): 
                echo '<div id="planner-cards" class="row cols-4">';
                while ($query->have_posts()): $query->the_post();
                $nutrition = get_field('nutritional_information');?>

                    
                    <div id="<?php echo get_the_ID() ?>" class="recipe-card" draggable="true" ondragstart="drag(event)">
                        <a href="<?php echo get_permalink() ?>">
                            <article class="img-wrap">
                                <?php echo get_the_post_thumbnail() ?>
                            </article>
                        </a>
                        <a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a>
                        <article class="calorie-count"><?php echo the_field('calories')?></article>
                        <article class="fat-count"><?php echo $nutrition['fat']?></article>
                        <article class="protein-count"><?php echo $nutrition['protein']?></article>
                        <article class="carb-count">Carbs: <?php echo $nutrition['carbs']?></article>
                        <button type="button" class="delete" onclick="Delete(this)">X</button>
                    </div>
            
                <?endwhile;
                echo '</div>';
                wp_reset_postdata();
            endif;

		endwhile; 
		?>

		</div><!-- .site-container -->
	</main><!-- #content -->
    

    <script>

        function delete_cookie(name) {
            document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }

        // Clear Storage
        document.getElementById('clear-storage').addEventListener('click', e =>{
            localStorage.removeItem('recipeList');
            location. reload();
            console.log(localStorage);
            delete_cookie('recipeList');
        })

        // Populate Recipe Cards
        const recipeListObjs = <?php echo json_encode($recipeListObjs); ?>;
        const recipeImgArr = <?php echo json_encode($recipeImgArr); ?>;

        let storedRecipes = JSON.parse(localStorage.getItem('recipeList'));
        const currentDiv = document.getElementById("card-wrapper");


        for (let i = 0; i < recipeListObjs.length; i++){
            let newDiv = document.createElement("div");
            newDiv.classList.add('recipe-preview');
            let codeBlock = '<h1>' + recipeListObjs[i].post_title + '</h1>' +
                            '<img src="' + recipeImgArr[i] + '"/>';
            newDiv.innerHTML = codeBlock;
            currentDiv.append(newDiv);
        }

    </script>
<?php
get_footer();
