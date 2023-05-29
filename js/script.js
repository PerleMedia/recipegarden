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