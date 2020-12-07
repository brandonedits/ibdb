$(document).ready(function(){

    $('.add-review').click(function(){
        $('.review').toggleClass('d-none');
        $(this).toggleClass('btn-primary btn-outline-primary');

        $(this).text(function(i, text){
            return text === "Maybe Later" ? "Add Review" : "Maybe Later";
        });
       
    });


    // Add Book - additional inputs +/-
    $('.add-more').click(function(){
        let containerDiv = $('<div></div>').addClass('input-group control-group').css('margin-top', '15px');
        $('.authors').append(containerDiv);

        let firstDiv = $('<div></div>').addClass('col-sm-6 input-group');
        containerDiv.append(firstDiv);

        let firstInput = $('<input>')
            .addClass('form-control form-control-lg')
            .attr('name', 'author_fName[]')
            .attr('placeholder', 'first');
        firstDiv.append(firstInput);

        let lastDiv = $('<div></div>').addClass('col-sm-6 input-group');
        containerDiv.append(lastDiv);

        let lastInput = $('<input>')
            .addClass('form-control form-control-lg')
            .attr('name', 'author_lName[]')
            .attr('placeholder', 'last');
        lastDiv.append(lastInput);

        let divBtn = $('<div></div>').addClass('input-group-btn');
        lastDiv.append(divBtn);

        let btn = $('<button></button>')
            .addClass('btn btn-danger btn-lg remove')
            .prop('type', 'button');
        divBtn.append(btn);

        let icon = $('<i></i>').addClass('fas fa-minus');
        btn.append(icon);

    });

    $('body').on('click','.remove',function(){ 
        $(this).parents('.control-group').remove();
    });



    // 5 star rating
    resetStarColors();

        $('.fa-star').on('click', function(){
            ratedIndex = parseInt($(this).data('index'));
        });

        $('.fa-star').mouseover(function(){
            resetStarColors();

            var currentIndex = parseInt($(this).data('index'));

            for(var i = 0; i < currentIndex; i++){
                $('.fa-star:eq('+i+')').addClass('text-primary');
            }
        });

        $('.fa-star').mouseleave(function(){
            resetStarColors();

            if(ratedIndex != -1){
                for(var i = 0; i <= ratedIndex; i++){
                    $('.fa-star:eq('+i+')').addClass('text-primary');
                }
            }
        });

        function resetStarColors(){
            $('.fa-star').removeClass('text-primary');
        }
});