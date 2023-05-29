<?php
/**
 * The template for displaying the Planner page
 */

get_header();
?>

	<main id="content" class="site-main page-planner">
        
		<div class="site-container">        
            

            <div class="plan-wrapper row">

                <div id="planner-cards" ondrop="drop(event)" ondragover="allowDrop(event)">
                </div><!-- .planner-cards -->
                

                <?php
                while ( have_posts() ) :
                    the_post();?>

                    <div id="plan-container">
                        
                        <div id="day1" class="meal-card">
                            <div id="total-calories">
                                <span class="day">Sunday</span>
                                <section>Calories: <div id="caloric-sum-1"></div></section>
                                <!-- <section>Fat: <div id="fat-sum-1"></div></section>
                                <section>Protein: <div id="protein-sum-1"></div></section> -->
                            </div>
                            <div id="lunch" ondrop="drop(event)" ondragover="allowDrop(event)">
                            </div>
                            <div id="dinner" ondrop="drop(event)" ondragover="allowDrop(event)">
                            </div>
                            
                        </div>

                        <div id="day2" class="meal-card">
                            <div id="total-calories">
                                <span class="day">Monday</span>
                                <section>Calories: <div id="caloric-sum-2"></div></section>
                                <!-- <section>Fat: <div id="fat-sum-2"></div></section>
                                <section>Protein: <div id="protein-sum-2"></div></section> -->
                            </div>
                            <div id="lunch" ondrop="drop(event)" ondragover="allowDrop(event)">
                            </div>
                            <div id="dinner" ondrop="drop(event)" ondragover="allowDrop(event)">
                            </div>
                            
                        </div>

                        <div id="day3" class="meal-card">
                            <div id="total-calories">
                                <span class="day">Tuesday</span>
                                <section>Calories: <div id="caloric-sum-3"></div></section>
                                <!-- <section>Fat: <div id="fat-sum-3"></div></section>
                                <section>Protein: <div id="protein-sum-3"></div></section> -->
                            </div>
                            <div id="lunch" ondrop="drop(event)" ondragover="allowDrop(event)">
                            </div>
                            <div id="dinner" ondrop="drop(event)" ondragover="allowDrop(event)">
                            </div>
                            
                        </div>
                        
                    </div>            

                    
                    

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


                endwhile; 
                ?>
            </div><!-- .plan-wrapper -->
            
            <button id="clear-storage">Clear Storage</button>
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
        const currentDiv = document.getElementById("planner-cards");



        for (let i = 0; i < recipeListObjs.length; i++){
            let newDiv = document.createElement("div");
            newDiv.classList.add('recipe-card');
            newDiv.setAttribute('id', recipeListObjs[i].ID);
            newDiv.setAttribute('draggable', 'true');
            newDiv.setAttribute('ondragstart', 'drag(event)');
            let codeBlock = '<h4>' + recipeListObjs[i].post_title + '</h4>' +
                            '<div class="img-wrap"><img src="' + recipeImgArr[i] + '"/></div>';
            newDiv.innerHTML = codeBlock;
            currentDiv.append(newDiv);
        }

    </script>
<?php
get_footer();
