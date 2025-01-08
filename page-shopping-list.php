<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

	<main id="content" class="site-main shopping-list">
		<div class="site-container">

		    <button id="clear-storage">Reset Meal Plan</button>
            <div id="card-wrapper">

            <?php
            while ( have_posts() ) :
                the_post();
            

                // var_dump($_COOKIE[ 'recipeList' ]);

                $recipeListIds = $_COOKIE[ 'recipeList' ];
                $recipeListIds = str_replace(array('[',']'), '', $recipeListIds);
                $recipeListIds = explode(",", $recipeListIds);

                $recipeListObjs = [];
                
                foreach ($recipeListIds as $recipe){
                    if ($recipe != 0){
                        $recipeObj = get_post( $recipe );
                        array_push($recipeListObjs, $recipeObj);
                    }
                    
                }

                // var_dump($recipeListObjs);

                class Ingredient {
                    // Properties
                    public $quantity;
                    public $measurement;
                    public $name;
                    public $id;
                    public $parentId;
                  
                    // Methods
                    function set_quantity($quantity) {
                      $this->quantity = $quantity;
                    }
                    function get_quantity() {
                      return $this->quantity;
                    }
                    function set_measurement($measurement) {
                        $this->measurement = $measurement;
                      }
                      function get_measurement() {
                        return $this->measurement;
                      }
                      function set_name($name) {
                        $this->name = $name;
                      }
                      function get_name() {
                        return $this->name;
                      }
                      function set_id($id) {
                        $this->id = $id;
                      }
                      function get_id() {
                        return $this->id;
                      }
                      function set_parent_id($parentId) {
                        $this->parentId = $parentId;
                      }
                      function get_parent_id() {
                        return $this->parentId;
                      }
                  }

                $recipeIngArr = [];
                foreach ($recipeListObjs as $recipeObj){
                    $ingredientData = get_field('ingredients', $recipeObj->ID);
                    $defaultServings = (int)get_field('serving_size', $recipeObj->ID);
                    $servingMultiplier = 1 / $defaultServings;


                    // var_dump($defaultServings);
                    // var_dump($servingMultiplier);
                    // var_dump($recipeObj->ID);

                    
                    for ($i = 0; $i < count($ingredientData); $i++){                        
                        
                        $newIng = new Ingredient();

                        $parent_category = $ingredientData[$i]['ingredient']->parent;
                        $inType = get_term_by( 'term_id', $parent_category, 'recipe-ingredients');
                        $parent_name = $inType->name;
                        $parentId;

                        if ($parent_name == "Fruit"){
                            $parentId = 1;
                        } elseif ($parent_name == "Vegetable"){
                            $parentId = 2;
                        } elseif ($parent_name == "Herbs"){
                            $parentId = 3;
                        } elseif ($parent_name == "Grains"){
                            $parentId = 4;
                        } elseif ($parent_name == "Protein"){
                            $parentId = 5;
                        } elseif ($parent_name == "Dairy"){
                            $parentId = 6;
                        } elseif ($parent_name == "Seasoning"){
                            $parentId = 7;
                        } elseif ($parent_name == "Fridge"){
                            $parentId = 8;
                        } elseif ($parent_name == "Pantry"){
                            $parentId = 9;
                        } 

                        $stQuant = (double)$ingredientData[$i]['quantity'];
                        $newIng->set_quantity($stQuant * $servingMultiplier);
                        $newIng->set_measurement($ingredientData[$i]['measurement']);
                        $newIng->set_name($ingredientData[$i]['ingredient']->name);
                        $newIng->set_id($ingredientData[$i]['ingredient']->term_id);
                        $newIng->set_parent_id($parentId);

                        // var_dump($newIng->id);

                        // if (count($recipeIngArr) == 0){
                        //     array_push($recipeIngArr, $newIng);
                        //     var_dump('yaaaas!!!');
                        //     var_dump($recipeIngArr);
                        // }

                        $existingIndex = -1;

                        for ($j = 0; $j < count($recipeIngArr); $j++){
                            if ($recipeIngArr[$j]->id == $newIng->id){
                                if ($recipeIngArr[$j]->measurement == $newIng->measurement){
                                    $existingIndex = $j;
                                    $recipeIngArr[$j]->quantity += $newIng->quantity;
                                    break;
                                }
                            }
                        }
                    
                        // var_dump($existingIndex);

                        if ($existingIndex < 0){
                            array_push($recipeIngArr, $newIng);
                        }

                        // var_dump($newIng->quantity);
                        // var_dump($newIng->name);
                        // var_dump(array_search(166, $recipeIngArr));
                        // var_dump('new array:');
                        // var_dump($recipeIngArr);
                        // var_dump($newIng->id);
                        
                        // var_dump($newIng);

                        
                        // for ($j = 0; $j < count($recipeIngArr) + 1; $j++){
                        //     var_dump($j);
                        //     var_dump($recipeIngArr[$j]);

                        //     var_dump($recipeIngArr);

                        //     if ($recipeIngArr[$j]->id == $newIng->id && $recipeIngArr[$j]->measurement == $newIng->measurement){
                        //         $existingIndex = $j;
                        //         $recipeIngArr[$j]->quantity += $newIng->quantity;
                        //         // var_dump($recipeIngArr[$j]);
                        //         break;
                        //     } 
                        // }

                        // if (!$existingIndex) {
                        //     array_push($recipeIngArr, $newIng);
                        // } 
                        
                        // var_dump($newIng);

                        // for ($j = 0; $j < count($recipeIngArr); $j++){
                        //     if ($recipeIngArr[$j]->id == $newIng->id){
                        //         var_dump($recipeIngArr);
                        //     } 
                        // }
                        
                        // var_dump($recipeIngArr);
                        // var_dump($newIng);
                    }

                    // var_dump($recipeIngArr);
                }

                // Sort Ingredients Array
                usort($recipeIngArr, function($a, $b){
                    return $a->parentId - $b->parentId;
                });

                foreach ($recipeIngArr as $printedRecipe){
                    
                    echo round($printedRecipe->quantity,1) . ' ' . $printedRecipe->measurement . ' ' . $printedRecipe->name;
                    // var_dump($printedRecipe);
                    echo '<br/>';
                }

                

            endwhile; 
            ?>
            </div>

            <button id="print_to_pdf" class="button">testing</button>

            
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


        ////
        const recipeIngArr = <?php echo json_encode($recipeIngArr); ?>;
        console.log(recipeIngArr)

        //
        
        document.getElementById('print_to_pdf').onclick = function () {
            let shoppingList = document.getElementById('card-wrapper');
            navigator.clipboard.writeText(shoppingList.innerHTML)
        }

    </script>
<?php
get_footer();
