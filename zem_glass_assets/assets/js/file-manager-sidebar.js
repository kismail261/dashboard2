window.onload = function () {

    // File Manager Side Menu
    var fmSidebar = $(".fm-sidebar"),
        navHeader = $(".main-header.sticky"),
        body = $("body"),
        navHeight;

    ///Create a margin top to prevent content 'jumps':
    fmSidebar.before('<div class="prevent-top"></div>');
    function preventTop() {
        navHeight = navHeader.innerHeight();
        fmSidebar.css({ "top": + navHeight + "px" });
    };
    preventTop(); //Run.

    // Toggle Sidemenu
    openfmSidebar = () => {
        $(body).toggleClass("fm-sidebar-open");
    }

    // click outside of sidemenu to close
    $('.app-content').on('click touchstart', function (event) {
        // event.stopPropagation();

        // closing of sidebar menu when clicking outside of it
        if (!$(event.target).closest('#fm-sidebar-btn').length) {
            var sidebarTarg = $(event.target).closest('#fm-sidebar-btn').length;
            if (!sidebarTarg) {
                $('body').removeClass('fm-sidebar-open');
            }
        }
    });

    // ______________ PerfectScrollbar
    const fmSidebarScroll = new PerfectScrollbar('.fm-sidebar', {
        useBothWheelAxes: true,
        suppressScrollX: true,
    });
}

