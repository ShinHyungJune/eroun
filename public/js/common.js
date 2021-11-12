$(document).ready(function(){
	var agent = navigator.userAgent.toLowerCase();

	if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
		$("body").addClass("ie");
	}

	if(navigator.vendor.indexOf("Apple") != -1){
		$("body").addClass("safari");
	}

	$(function(){
		AOS.init();
	});

    $(window).scroll(function(){
        $(this).scrollTop() > 50
            ? $(".header").addClass("active")
            : $(".header").removeClass("active");
    });

    $(".header .black").click(function(){
        $(".header .btn-menu").removeClass("active");
        $(this).removeClass("active");
        $(".header .right").removeClass("active");
        $(".header .black").removeClass("active");
    });

    $(".header .btn-menu").click(function(){
        $(this).hasClass("active") ? closeSidebar() : openSidebar();
    });

    $(".m-tabs-tab").click(function(){
        $(".m-tabs-tab").removeClass("active");
        $(this).addClass("active");

        $(".m-tabs-content").removeClass("active");
        $(".m-tabs-content").eq($(this).index()).addClass("active");
    })

    function openSidebar(){
        $(".header .btn-menu").addClass("active")
        $(".header .right").addClass("active");
        $(".header .black").addClass("active");
    }

    function closeSidebar(){
        $(".header .btn-menu").removeClass("active")
        $(".header .right").removeClass("active");
        $(".header .black").removeClass("active");
    }

    $(".header .right > .navs > .nav > .navs > .nav").click(function(){
       if($(window).width() < 1200){
           closeSidebar();
       }
    });

    $(".header .util").click(function(){
       $(this).addClass("active");
    });
});
