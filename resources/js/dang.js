if(this.question.is_up_voted){

    $('.vote-up').removeClass('favorited');
    this.question.is_up_voted = false

}else if(this.question.is_down_voted && this.question.is_up_voted){

    $('.vote-down').removeClass('favorited');
    $('.vote-up').addClass('favorited');

    this.question.is_down_voted = false

}else{

    $('.vote-up').addClass('favorited');
    this.question.is_up_voted = true

}