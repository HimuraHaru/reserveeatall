var feedbackID = 0;

$('.like').on('click', function(event){

    event.preventDefault();
    feedbackID = event.target.parentNode.parentNode.dataset['feedbackid'];
    var isLike = event.target.previousElementSibling == null;

    $.ajax({
        method : 'POST',
        url : urlLike,
        data : {isLike: isLike, feedbackID: feedbackID, _token: token }
    })
        .done(function() {
           event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'You like this feedback' : 'Like' :
           event.target.innerText == 'Dislike' ? 'You dislike this feedback' : 'Dislike';
           if(isLike) {
               event.target.nextElementSibling.innerText = 'Dislike';
           }
           else {
               event.target.nextElementSibling.innerText = 'Like';
           }
        });


});