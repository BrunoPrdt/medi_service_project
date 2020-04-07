
//Collapse Sidepanel - Responsive Navbar !!!!!!

function openNav() {
    document.getElementById("mySidepanel").style.width = "250px";
}
function closeNav() {
    document.getElementById("mySidepanel").style.width = "0";
}

(function ($) {

    //**************************************************//
    //******************** general *********************//
    //**************************************************//


//animation at screen visible !! ************
    const ratio = 0.5;
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: ratio
    };

    const handleIntersect = function(entries, observer) {
        entries.forEach(function (entry) {
            if (entry.intersectionRatio > ratio) {
                entry.target.classList.add('reveal-visible');
                observer.unobserve(entry.target)
            }
            else{

            }
        })
    };

    const observer = new IntersectionObserver(handleIntersect, options);
    document.querySelectorAll('.reveal, [class*="reveal-up-"], [class*="reveal-right-"], [class*="reveal-left-"]').forEach(function (r) {
        observer.observe(r);
    });

    //****************** homepage **********************//
    const btn_container = document.querySelector('.btn_container');
    btn_container.addEventListener('animationend', () => {
        btn_container.classList.remove('active');
        /* waiting btn animation & redirect to login's page */
        $(location).attr('href', 'http://demo-mediservice.brunopredot.com/login');
    });

    //**************************************************//
    //***************** contact page *******************//
    //**************************************************//

    $(document).ready(function(){

        //first container
        function readyFn( jQuery ) {
            // Code to run when the document is ready.
            var div = $(".animation-words");
            div.animate({up: '150px'}, "slow");
            div.animate({fontSize: '2em'}, "slow");
        }
        $( document ).ready( readyFn );
        //$( window ).on( "load", readyFn );

        function readyForm2( jQuery ) {
            // Code to run when the document is ready.
            $(".form2").animate({
                left: '65%',
                height: '150px',
                width: '150px'
            });
        }

        setTimeout(function(){
            $( window ).on( "load", readyForm2() );
        }, 2400);

        function readyForm3( jQuery ) {
            // Code to run when the document is ready.
            $(".form3").animate({
                right: '65%',
                height: '150px',
                width: '150px'
            });
        }

        setTimeout(function(){
            $( window ).on( "load", readyForm3() );
        }, 2400);



        //**************************************************//
        //******************* form page ********************//
        //**************************************************//

        // count of form's characters

        $(".form-control").keyup(function() {
            if ($(this).val().length >1) {
                $("#nombreLettre").html($(this).val().length + " caractères (characters)");
            }else {
                $("#nombreLettre").html($(this).val().length + " caractères (characters)");
            }
        });
    });

})(jQuery);

