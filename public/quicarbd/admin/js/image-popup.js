$(".img-popup").on('click', function() {
    console.log('yesss', $(this).attr('src'));
    var src = $(this).attr('src');    
    console.log('yesss', src);
    $(".overlay-dark").css('display', 'block');
    $('.img-overlay').css('opacity', 1);
    $('.img-overlay').attr('src', src);
    $('.img-overlay').css('transform', 'translate(-50%, 0) scale(1, 1)');
});

$(".overlay-dark").on('click', function() {
    $(".overlay-dark").css('display', 'none');
    $('.img-overlay').css('opacity', 0);
    setTimeout(function() {
        $('.img-overlay').css('transform', 'translate(-50%, 0) scale(0, 0)');
    }, 600);
});