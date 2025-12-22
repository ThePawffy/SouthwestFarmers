(function ($) {
    "use strict";

    sideManu();

    function sideManu() {
        let manuStor = $(".side-bar").html();

        $(".side-bar").html("<div class='overlay'></div>" + manuStor);
        $(".sidebar-opner").on("click ", function () {
            $(".side-bar, .section-container").toggleClass("active");
        });
        $(".side-bar .close-btn, .side-bar .overlay").on("click ", function () {
            $(".side-bar, .section-container").toggleClass("active");
        });

        $("li>ul").toggleClass("dropdown-menu");

        let animationSpeed = 300;

        let subMenuSelector = ".dropdown-menu";

        $(".side-bar-manu > ul").on("click", ".dropdown a", function (e) {
            let $this = $(this);
            let checkElement = $this.next();

            if (
                checkElement.is(subMenuSelector) &&
                checkElement.is(":visible")
            ) {
                checkElement.slideUp(animationSpeed, function () {
                    checkElement.removeClass("menu-open");
                });
                checkElement.parent("li").removeClass("active");
            }

            //If the menu is not visible
            else if (
                checkElement.is(subMenuSelector) &&
                !checkElement.is(":visible")
            ) {
                //Get the parent menu
                let parent = $this.parents("ul").first();
                //Close all open menus within the parent
                let ul = parent.find("ul:visible").slideUp(animationSpeed);
                //Remove the menu-open class from the parent
                ul.removeClass("menu-open");
                //Get the parent li
                let parent_li = $this.parent("li");

                //Open the target menu and add the menu-open class
                checkElement.slideDown(animationSpeed, function () {
                    //Add the class active to the parent li
                    checkElement.addClass("menu-open");
                    parent.find("li.active").removeClass("active");
                    parent_li.addClass("active");
                });
            }
            //if this isn't a link, prevent the page from being redirected
            if (checkElement.is(subMenuSelector)) {
                e.preventDefault();
            }
        });

        // show sidebar in previous menu
        var sidebar = $('.side-bar');

        // Restore scroll position on page load
        var savedScroll = localStorage.getItem('sidebar-scroll');
        if (savedScroll !== null) {
            sidebar.scrollTop(savedScroll);
        }

        // Save scroll position before leaving the page
        $(window).on('beforeunload', function() {
            localStorage.setItem('sidebar-scroll', sidebar.scrollTop());
        });
    }

    // photo upload preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".image-preview").attr("src", e.target.result);
                $(".image-preview").hide();
                $(".image-preview").fadeIn(650);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#add-profile").on("change", function () {
        readURL(this);
        $(".image-preview-icon").addClass("d-none");
    });
})(jQuery);

document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector(".menu-opener");
    const sidebarPlan = document.querySelector(".lg-sub-plan");
    const smSidebarPlan = document.querySelector(".sm-sidebar-plan");
    const sideBar = document.querySelector(".side-bar");

    toggleBtn.addEventListener("click", function () {
        if (sidebarPlan.style.display === "none") {
            sidebarPlan.style.display = "block";
        } else {
            sidebarPlan.style.display = "none";
        }

        if (
            smSidebarPlan.style.display === "none" ||
            smSidebarPlan.style.display === ""
        ) {
            smSidebarPlan.style.display = "block";
        } else {
            smSidebarPlan.style.display = "none";
        }
    });
    sideBar.addEventListener("mouseenter", function () {
        smSidebarPlan.style.display = "none";
        sidebarPlan.style.display = "block";
    });
});
