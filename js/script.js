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

/* 
 * Functions for recipe filtering logic
 */
function filterToggle() {
  let wrapper = document.getElementById('filter-wrapper');
  wrapper.classList.toggle('active');
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

