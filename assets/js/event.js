// $(document).ready(function () {
//     $("button").click(function () {
//         $("#p1").css("color", "red")
//             .slideUp(2000)
//             .slideDown(2000);
//     });
// });
//
// $(document).ready(function () {
//     $('.leftcol').click(function () {
//         $('.footer').css('background', $(this).css('background'));
//         console.log(' left col color');
//     });
// });
//

$(document).ready(function () {
    $("form").submit(function () {
        $.ajax({
            url: "sleep.php",
            beforeSend: function () {
                $('.container').addClass('loading');
                $('.loader').show();
            },
            success:function () {
                $('.container').removeClass('loading');
                $('.loader').hide();
            }
        });
    });
});

$(document).ready(function () {
    $('.footer ').dblclick(function () {
        console.log($('.leftcol').css('background', $(this).css('background')));
    });
});

$(document).ready(function () {
    $('.footer .box').click(function () {
        $this = $(this);
        console.log($('.leftcol').css('background', $this.data('color')));
    });
});

$(document).ready(function () {
    $('nav .icon').click(function () {
        console.log($('nav').toggleClass('new_nav'));
        console.log($('.section').toggleClass('new_section'));
    });
});

$(document).ready(function () {
    $('#more').click(function () {
        console.log($('.more').toggleClass('show'));
        if ($('#more').text() === 'بیشتر') {
            $('#more').text('کمتر');
        } else {
            $('#more').text('بیشتر');
        }
    });
});

$(document).ready(function () {
    $("form").submit(function (event) {
        event.preventDefault();
        $('span.alert').hide();
        if (isEmail($("input[name=email]").val())) {
            $("input[name=email]").next().text($("input[name=email]").data('err')).show();
        }
        if (isEmpty($("input[name=username]").val())) {
            $("input[name=username]").next().text($("input[name=username]").data('err')).show();
        }
        if (isEmpty($("input[name=password]").val())) {
            $("input[name=password]").next().text($("input[name=password]").data('err')).show();
        }
        if (($("input[name=password]").val() !== $("input[name=repass]").val())) {
            $("input[name=repass]").next().text($("input[name=repass]").data('err')).show();
        }

    });
});

// $ input .change function(){}
/**
 * @return {boolean}
 */
function isEmail(input) {
    let pattern = new RegExp(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/);
    return pattern.test(input);
}

function isEmpty(input) {
    if(input.trim()==='')
        return true
}

function isAlphanumeric(input) {
    pattern = new RegExp(/\w+/);
    return pattern.test(input);
}


function selectCountry(val) {
    $("#search-box").val(val);
    $("#suggesstion-box").hide();
}
