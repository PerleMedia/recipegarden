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

}

/**
* Add a delete button to remove a recipe, and recalculate calories
*/
function Delete(button){
  var parent = button.parentNode;
  var grand_father = parent.parentNode;
  grand_father.removeChild(parent);

  // innerCalculator('#day1 .calorie-count', 'caloric-sum-1', '#day1 .fat-count', 'fat-sum-1', '#day1 .protein-count', 'protein-sum-1');
  // innerCalculator('#day2 .calorie-count', 'caloric-sum-2', '#day2 .fat-count', 'fat-sum-2', '#day2 .protein-count', 'protein-sum-2');
  // innerCalculator('#day3 .calorie-count', 'caloric-sum-3', '#day3 .fat-count', 'fat-sum-3', '#day3 .protein-count', 'protein-sum-3');
}

/* 
 * Get footer height in px
 */


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
    console.log('footer= ' + footerHeight);
    console.log('header= ' + headerHeight);
    contentSpace.css('margin-bottom', footerHeight);
  }
  window.addEventListener('resize', getHeightsOnResize);

  // Ajax post filters
  $('#search-titles').on('input', function() { 
    console.log($(this).val())
    $(this).val() // get the current value of the input field.
    
    // $.ajax({
    //   type: 'POST',
    //   url: '/wp-admin/admin-ajax.php',
    //   dataType: 'html',
    //   data: {
    //     action: 'filter_recipes',
    //     category: $(this).val(),
    //   },
    //   success: function(res) {
    //     $('.project-tiles').html(res);
    //   }
    // })

});
});

