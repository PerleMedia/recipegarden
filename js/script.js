/* 
 * Mobile Menu Toggle Behavior
 */
function menuToggle(){
    const element = document.getElementById('menu-toggle');
    const body = document.getElementById('page');
    const menuContainer = document.querySelector('#menu-toggle ~ .menu-main-navigation-container');
    element.classList.toggle('active');
    body.classList.toggle('overlay-active');

    if (element.classList.contains('active')){
      menuContainer.style.display = 'block';
    } else {
      setTimeout(function (){
        menuContainer.style.display = 'none';
      }, 500)
    }
}

/**
 * Create a new Cookie
 */
function setCookie(name,value,days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

/**
 * Drag and Drop -- Drop Initialization
 */
function allowDrop(ev) {
  ev.preventDefault();
}

/**
 * Drag and Drop -- Drag Initialization
 */
function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}

/**
 * Drag and Drop -- Behavior Configuration
 */
function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  var node = document.getElementById(data);
  var clone = node.cloneNode(true);
  
  if (ev.target.closest('.clone') !== null){
      ev.target.appendChild(clone);
  } else {
      ev.target.appendChild(node);
  }

  const mealCards = document.querySelectorAll('.meal-card');
  const calorieContainers = document.querySelectorAll('.caloric-sum');
  
  let recipeData = [];
  let calorieData = [];
  
  for (let i = 0; i < mealCards.length; i++){
    recipeData[i] = mealCards[i].querySelectorAll('.recipe-card');
    
    let calArr = [0];
    let totalCals;
    recipeData[i].forEach(recipe => {
     calArr.push(parseInt(recipe.dataset['calories']))
    })
  
    totalCals = calArr.reduce((a, b) => {
        return a + b;
    })
  
    calorieData.push(totalCals);
    calorieContainers[i].innerHTML = calorieData[i];
  }

  // console.log(mealCards);
  // console.log(calorieData);
  
}

/* 
 * Functions for recipe filtering logic
 */
function filterToggle() {
  wrapper.classList.toggle('active');
  if (wrapper.classList.contains('active')){
    for (let i = 0; i < filters.length; i++){
      filters[i].classList.remove('active');
      filters[i].querySelector('.accordion-expand').innerHTML = '+';
    } 
  }
}
let ingredientsSelected;
let caloriesSelected;
let cuisinesSelected;
let coursesSelected;
let dietsSelected;
let tagsSelected;

let wrapper = document.getElementById('filter-wrapper');

function countFilters() {
  ingredientsSelected = document.querySelector(`select[id="filter-form"]`).value;
  if (ingredientsSelected){
    document.getElementById('ingredients-count').innerHTML = ' (1)';
  } else document.getElementById('ingredients-count').innerHTML = ''

  let calorieInputs = document.querySelectorAll(`input[type="number"]`);
  caloriesSelected = [];
  calorieInputs.forEach(input => {
    if (input.value){
      caloriesSelected.push(input);
    }
  })
  if (caloriesSelected.length > 0){
    document.getElementById('calories-count').innerHTML = ' (' + caloriesSelected.length + ')';
  } else document.getElementById('calories-count').innerHTML = ''

  cuisinesSelected = document.querySelectorAll(`[data-category="cuisines"].active`).length;
  if (cuisinesSelected > 0){
    document.getElementById('cuisines-count').innerHTML = ' (' + cuisinesSelected + ')';
  } else document.getElementById('cuisines-count').innerHTML = ''
  
  coursesSelected = document.querySelectorAll(`[data-category="courses"].active`).length;
  if (coursesSelected > 0){
    document.getElementById('courses-count').innerHTML = ' (' + coursesSelected + ')';
  } else document.getElementById('courses-count').innerHTML = ''

  dietsSelected = document.querySelectorAll(`[data-category="diets"].active`).length;
  if (dietsSelected > 0){
    document.getElementById('diets-count').innerHTML = ' (' + dietsSelected + ')';
  } else document.getElementById('diets-count').innerHTML = ''
  
  tagsSelected = document.querySelectorAll(`[data-category="tags"].active`).length;
  if (tagsSelected > 0){
    document.getElementById('tags-count').innerHTML = ' (' + tagsSelected + ')';
  } else document.getElementById('tags-count').innerHTML = ''
}


/* 
 * jQuery
 */
jQuery(document).ready(function($) {
  // Get height values
  let footerHeight = $('#footer').height();
  let headerHeight = $('#header').height();
  
  // Footer reveal effect
  let mainContent = $('main#content');
  mainContent.css('margin-bottom', footerHeight);

  function getHeightsOnResize(){
    footerHeight = $('#footer').height();
    headerHeight = $('#header').height();
    // console.log('footer= ' + footerHeight);
    // console.log('header= ' + headerHeight);
    // contentSpace.css('margin-bottom', footerHeight);
  }
  window.addEventListener('resize', getHeightsOnResize);

  // Ajax post filters
  $('#search-titles').on('input', function() { 
    console.log($(this).val())
    $(this).val() // get the current value of the input field.
  });

  $('#filter-cals-min').on('input', function() { 
    console.log($(this).val())
    $(this).val() // get the current value of the input field.
  });
});

