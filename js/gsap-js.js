jQuery(document).ready(function($) {

    gsap.registerPlugin(ScrollTrigger);
    gsap.registerPlugin(SplitText);

    /*
     * Split Text Animation
     */
    const splitPhrases = document.querySelectorAll(".split-text");
    function setupSplits() {
    splitPhrases.forEach(splitPhrase => {
        // Reset if needed
        if(splitPhrase.anim) {
        splitPhrase.anim.progress(1).kill();
        splitPhrase.split.revert();
        }

        splitPhrase.split = new SplitText(splitPhrase, { 
        type: "lines,words,chars",
        linesClass: "split-line"
        });

        // Set up the anim
        splitPhrase.anim = gsap.from(splitPhrase.split.chars, {
        scrollTrigger: {
            trigger: splitPhrase,
            toggleActions: "restart pause resume reverse",
            start: "top 50%",
        },
        duration: 0.7, 
        ease: "circ.out", 
        y: 150, 
        stagger: 0.02,
        });
    });
    }
    ScrollTrigger.addEventListener("refresh", setupSplits);
    setupSplits();

    
    /**
     * Fade In Up
     * @type {jQuery|HTMLElement|*}
     */
     const fadeInUp = $('.gsap-fade-in-up');
     if(fadeInUp.length){
         gsap.utils.toArray(".gsap-fade-in-up").forEach(box => {
             var tl = gsap.timeline({
                 scrollTrigger: {
                     trigger: box,
                     toggleActions: "restart none none reset",
                 }
             });
             tl.from(box, {
                 duration:1.25,
                 autoAlpha:0,
                 y:25,
                 ease:'circ'
             });
         });
     }
 
     /**
      * Fade In Left
      * @type {jQuery|HTMLElement|*}
      */
     const fadeInLeft = $('.gsap-fade-in-left');
     if(fadeInLeft.length){
         gsap.utils.toArray(".gsap-fade-in-left").forEach(box => {
             var tl = gsap.timeline({
                 scrollTrigger: {
                     trigger: box,
                     toggleActions: "restart none none reset",
                 }
             });
             tl.from(box, {
                 duration:1.5,
                 autoAlpha:0,
                 x:-200,
                 ease:'circ',
             });
         });
     }
 
     /**
      * Fade In Right
      * @type {jQuery|HTMLElement|*}
      */
     const fadeInRight = $('.gsap-fade-in-right');
     if(fadeInRight.length){
         gsap.utils.toArray(".gsap-fade-in-right").forEach(box => {
             var tl = gsap.timeline({
                 scrollTrigger: {
                     trigger: box,
                     toggleActions: "restart none none reset",
                 }
             });
             tl.from(box, {
                 duration:1.5,
                 autoAlpha:0,
                 x:200,
                 ease:'circ'
             });
         });
     }

    /*
     * Mobile Menu Animation
     */
    const toggleMenu = document.querySelector('#menu-toggle');
    const tl = gsap.timeline({ reversed: true });
        tl
    .from('header nav', {
        duration: 0.4,
        ease: 'power3.inOut',
        top: '0',    
    })
    .from('#site-navigation li', {
        duration: 0.3,
        opacity: 0,
        x: -30,
        ease: 'power3.inOut',
        stagger: 0.05,    
    });
    
    function animateIt() {    
        tl.reversed() ? tl.play() : tl.reverse()
    };
    

    var mediaQueryList = window.matchMedia('(min-width: 992px)'); // Mobile menu breakpoint
    if(mediaQueryList.matches) {
        tl.pause(1)
    } else {
        toggleMenu.addEventListener('click', animateIt);
        tl.pause(0)
    }

    // Handle screen resizing
    function toggleStateOnResize(e) {
    if (e.matches) {
        // Desktop
        toggleMenu.removeEventListener('click', animateIt);
        tl.pause(1);
        $('.menu-main-navigation-container').css('display', 'block');

    } else {
        // Mobile
        toggleMenu.addEventListener('click', animateIt);
        tl.pause(0).reversed(true)
    }
    }

    mediaQueryList.addListener(toggleStateOnResize);

    /*
     * Weighted parallax elements
     */

    gsap.set(".gsap-float-down", { yPercent: -30}); // Optional offset
    gsap.set(".gsap-float-up", { yPercent: 30}); // Optional offset

    gsap.to(".gsap-float-down", {
    yPercent: 30,
    ease: "none",
    scrollTrigger: {
        trigger: ".clusterGreat",
        scrub: 1
    }, 
    });

    gsap.to(".gsap-float-up", {
    yPercent: -30,
    ease: "none",
    scrollTrigger: {
        trigger: ".clusterGreat",
        scrub: 1
    }, 
    });

});