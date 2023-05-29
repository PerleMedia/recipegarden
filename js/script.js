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
});

