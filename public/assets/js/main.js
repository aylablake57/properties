(function () {
    "use strict";

    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
        el = el.trim()
        if (all) {
            return [...document.querySelectorAll(el)]
        } else {
            return document.querySelector(el)
        }
    }

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
        if (all) {
            select(el, all).forEach(e => e.addEventListener(type, listener))
        } else {
            select(el, all).addEventListener(type, listener)
        }
    }

    /**
     * Easy on scroll event listener
     */
    const onscroll = (el, listener) => {
        el.addEventListener('scroll', listener)
    }

    /**
     * Sidebar toggle
     */
    if (select('.toggle-sidebar-btn')) {
        on('click', '.toggle-sidebar-btn', function (e) {
            select('body').classList.toggle('toggle-sidebar')
        })
    }

    /**
     * Search bar toggle
     */
    if (select('.search-bar-toggle')) {
        on('click', '.search-bar-toggle', function (e) {
            select('.search-bar').classList.toggle('search-bar-show')
        })
    }

    /**
     * Navbar links active state on scroll
     */
    let navbarlinks = select('#navbar .scrollto', true)
    const navbarlinksActive = () => {
        let position = window.scrollY + 200
        navbarlinks.forEach(navbarlink => {
            if (!navbarlink.hash) return
            let section = select(navbarlink.hash)
            if (!section) return
            if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                navbarlink.classList.add('active')
            } else {
                navbarlink.classList.remove('active')
            }
        });
    }
    window.addEventListener('load', navbarlinksActive)
    onscroll(document, navbarlinksActive)

    /**
     * Toggle .header-scrolled class to #header when page is scrolled
     */
    let selectHeader = select('#header')
    if (selectHeader) {
        const headerScrolled = () => {
            if (window.scrollY > 100) {
                selectHeader.classList.add('header-scrolled')
            } else {
                selectHeader.classList.remove('header-scrolled')
            }
        }
        window.addEventListener('load', headerScrolled)
        onscroll(document, headerScrolled)
    }

    /**
     * Back to top button
     */
    /*  let backtotop = select('.back-to-top')
     if (backtotop) {
         const toggleBacktotop = () => {
         if (window.scrollY > 100) {
             backtotop.classList.add('active')
         } else {
             backtotop.classList.remove('active')
         }
         }
         window.addEventListener('load', toggleBacktotop)
         onscroll(document, toggleBacktotop)
     } */

    /**
     * Auto closing alerts
     */
    const autoCloseElements = document.querySelectorAll(".auto-close");

    function fadeAndSlide(element) {
        const fadeDuration = 500;
        const slideDuration = 500;

        // Step 1: Fade out the element
        let opacity = 1;
        const fadeInterval = setInterval(function () {
            if (opacity > 0) {
                opacity -= 0.1;
                element.style.opacity = opacity;
            } else {
                clearInterval(fadeInterval);
                // Step 2: Slide up the element
                let height = element.offsetHeight;
                const slideInterval = setInterval(function () {
                    if (height > 0) {
                        height -= 10;
                        element.style.height = height + "px";
                    } else {
                        clearInterval(slideInterval);
                        // Step 3: Remove the element from the DOM
                        element.parentNode.removeChild(element);
                    }
                }, slideDuration / 10);
            }
        }, fadeDuration / 10);
    }

    // Set a timeout to execute the animation after 5000 milliseconds (5 seconds)
    setTimeout(function () {
        autoCloseElements.forEach(function (element) {
            fadeAndSlide(element);
        });
    }, 10000);

    /**
     * Initiate tooltips
     */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    /**
     * Initiate quill editors
     */
    /* if (select('.quill-editor-default')) {
        new Quill('.quill-editor-default', {
        theme: 'snow'
        });
    }

    if (select('.quill-editor-bubble')) {
        new Quill('.quill-editor-bubble', {
        theme: 'bubble'
        });
    }

    if (select('.quill-editor-full')) {
        new Quill(".quill-editor-full", {
        modules: {
            toolbar: [
            [{
                font: []
            }, {
                size: []
            }],
            ["bold", "italic", "underline", "strike"],
            [{
                color: []
                },
                {
                background: []
                }
            ],
            [{
                script: "super"
                },
                {
                script: "sub"
                }
            ],
            [{
                list: "ordered"
                },
                {
                list: "bullet"
                },
                {
                indent: "-1"
                },
                {
                indent: "+1"
                }
            ],
            ["direction", {
                align: []
            }],
            ["link", "image", "video"],
            ["clean"]
            ]
        },
        theme: "snow"
        });
    } */

    /**
     * Initiate Bootstrap validation check
     */
    var needsValidation = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(needsValidation)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })

    /**
     * Initiate Datatables
     */
    const datatables = select('.jsdatatable', true)
    datatables.forEach(datatable => {
        //new simpleDatatables.DataTable(datatable);
        new DataTable(datatable, {
            filter: true,
            order: [[0, 'desc']]
        });
    })

    /**
     * Autoresize echart charts
     */
    const mainContainer = select('#main');
    if (mainContainer) {
        setTimeout(() => {
            new ResizeObserver(function () {
                select('.echart', true).forEach(getEchart => {
                    var ec = echarts.getInstanceByDom(getEchart);
                    if (ec) {
                        ec.resize();
                    }
                })
            }).observe(mainContainer);
        }, 200);
    }

})();

/**
 * Printing error messages on modals
 */
function printErrorMsg(mdl, msg) {
    mdl.find("ul").html('');
    mdl.find("ul").parent().removeClass('hide').addClass('show');
    $.each(msg, function (key, value) {
        mdl.find("ul").append('<li>' + value + '</li>');
    });
}

function displayAlert(type, message) {
    $('section').find('.row').find('.col-lg-12').prepend('<div class="alert alert-' + type + ' alert-dismissible fade show auto-close" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
}

function previewImage(fileInput, imageElement) {
    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            imageElement.src = e.target.result;
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}

$(".update-cart").change(function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var ele = $(this);

    $.ajax({
        url: 'update-cart',
        method: "patch",
        data: {
            id: ele.attr("data-id"),
            quantity: ele.val()
        },
        success: function (response) {
            // console.log(response);
            window.location.reload();
        }
    });
});

$(".remove-from-cart").click(function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var ele = $(this).attr('data-id');

    if (confirm("Are you sure want to remove?")) {
        $.ajax({
            url: 'remove-from-cart',
            method: "DELETE",
            data: {
                id: ele
            },
            success: function (response) {
                window.location.reload();
            }
        });
    }
});

//Installments Enable/Disable
function toggleInputs(isChecked) {
    //hide or unhide
    if (isChecked)
        $('#installment-block').show();
    else
        $('#installment-block').hide();

    //enable or disable
    $('input[name="advance_amount"]').prop('disabled', !isChecked);
    $('input[name="monthly_installment"]').prop('disabled', !isChecked);
    $('input[name="no_of_installments"]').prop('disabled', !isChecked);

    // Clear values if unchecked
    // if (!isChecked) {
    //     $('input[name="advance_amount"]').val('');
    //     $('input[name="monthly_installment"]').val('');
    //     $('input[name="no_of_installments"]').val('');
    // }
}

// Initial state on page load
toggleInputs($('#installments_available').prop('checked'));

// Event listener for checkbox change
$('#installments_available').change(function () {
    toggleInputs($(this).prop('checked'));
});

/* $('#phone').mask("+929999999999", {placeholder: "+92__________"});
$('#phone').attr('placeholder', 'Phone: +920000000'); */



$(document).ready(function () {
    if ($('#property_type').val()) {
        $('#property_type').trigger('change');
    }
  
});

$(document).on('change', '#property_type', function () {

    var property_type_id = this.value;
    console.log("testing-----",property_type_id)
    var addProperty = $('#sub_type').data('add-property');

    if (addProperty == 'true') {
        getSubTypes(property_type_id, 0);
    } else {
        getSubTypes(property_type_id, 0, addProperty);
    }
});

function getSubTypes(property_type_id, subType, addProperty = false) {

    console.log(property_type_id)
    if (!subType) {
        subType = 'all';
    }
    $("#sub_type").html('');

    $.ajax({
        url: window.routes.subtypes,
        type: "GET",
        data: {
            property_type_id: property_type_id,
        },
        dataType: 'json',
        success: function (result) {
            if (addProperty == true) {
                $("#sub_type").html('<option value="" selected disabled>Please Select</option>');
            } else {
                $("#sub_type").html('<option value="all" >All</option>');
            }
            $.each(result, function (key, value) {
                $("#sub_type").append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            if (subType !== 'all' && result.length > 0) {
                $('#sub_type').val(subType);
            }

            // New code to check for previously selected subtype
            const selectedSubtype = $('#sub_type').data('old');
            if (selectedSubtype) {
                $('#sub_type').val(selectedSubtype).trigger('change'); // Set the selected subtype
            }

            // Trigger change event to notify any listeners
            $('#sub_type').trigger('change');
        }
    });
}