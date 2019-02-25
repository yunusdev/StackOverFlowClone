<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h3>{{question.title}}</h3>
                                <div class="ml-auto">
                                    <a href="/" class="btn btn-outline-secondary">Go back to all Questions</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a title="Vote up" @click="upVoteQuestion(question.id)" class="vote-up" :class="upVoteStatus">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">{{question.votes_count}}</span>
                                <a title="Vote down" @click="downVoteQuestion(question.id)" class="vote-down" :class ="downVoteStatus">

                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>

                                <a title="Favorite Que!" v-if="question.is_favorited" @click="unFavoriteQuestion(question.id)"

                                   class="favorite mt-2 fav" :class="favoritedStatus">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">{{question.favorites_counts}}</span>
                                </a>
                                <a title="Favorite Que!" v-else  @click="favoriteQuestion(question.id)"

                                   class="fav favorite mt-2" :class="favoritedStatus">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">{{question.favorites_counts}}</span>
                                </a>

                            </div>
                            <div class="media-body">
                                <div v-html= question.body_html></div>
                                <div class="float-right">
                                    <span class="text-muted">Answered {{question.created_date}}</span>
                                    <div class="media mt-2">
                                        <a :href="question.user.url" class="pr-2">
                                            <img :src="question.user.avatar" alt="" >
                                        </a>
                                        <div class="media-body">
                                            <a :href="question.user.url">{{question.user.name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <vue-answers :isLogin = "is_login" :question_id = "question.id" :answers = "answers"></vue-answers>
    </div>
</template>

<script>
    import Axios from 'axios'

    export default {
        props: ['raw_answers', 'is_login', 'raw_question'],

        data(){

            return{

                question: JSON.parse(this.raw_question),
                answers: JSON.parse(this.raw_answers),
                isLogins: this.is_login,
                // favorite: this.fav_compute()
            }
        },

        computed: {

            upVoteStatus(){

                return !this.isLogins ? 'off' : (this.question.is_up_voted ? 'vote-accepted' : 'd')
            },

            downVoteStatus(){

                return !this.isLogins ? 'off' : (this.question.is_down_voted ? 'vote_down_voted' : 'd')
            },

            favoritedStatus(){

                return !this.isLogins ? 'off' : (this.question.is_favorited ? 'favorited' : 'dd')
            }
        },

        methods: {

            fav_compute(){

                if (this.question.is_favorited){

                    this.favorite = 'unFav'

                }else{

                    this.favorite = 'fav'

                }
            },

            upVoteQuestion(id){

                if(!this.isLogins){

                    window.location = '/login'

                }
                Axios.post(`/question/${id}/vote`)

                .then(res => {

                    // console.log(res.data);

                    this.question.is_up_voted = res.data.is_up_voted;

                    this.question.is_down_voted = res.data.is_down_voted;

                    this.question.votes_count = res.data.votes_count;

                    
                }).catch(err => {

                    console.log(err)

                });

            },

            downVoteQuestion(id){

                if(!this.isLogins){

                    window.location = '/login'

                }

                Axios.post(`/question/${id}/unvote`)

                    .then(res => {

                        this.question.is_up_voted = res.data.is_up_voted;
                        this.question.is_down_voted = res.data.is_down_voted;
                        this.question.votes_count = res.data.votes_count;

                        

                    }).catch(err => {

                    console.log(err)

                });

            },
            favoriteQuestion(id){

                if(!this.isLogins){

                    window.location = '/login'

                }

                Axios.post(`/user/${id}/favorite`, {

                    fav: 'fav'

                }).then(res => {

                    // console.log(res);
                    $('.fav').addClass('favorited');
                        this.question.favorites_counts++;
                        this.question.is_favorited = true;

                    }).catch(err => {

                    console.log(err)

                });

            },

            unFavoriteQuestion(id){

                Axios.post(`/user/${id}/favorite`, {

                    fav: 'unFav'

                }).then(res => {

                        $('.fav').removeClass('favorited');
                        this.question.favorites_counts--;

                        this.question.is_favorited = false;

                        // console.log(res.data)

                    }).catch(err => {

                    console.log(err)

                });

            }
        }
    }
</script>

<style scoped>
    a.vote-accepted{

        color: greenyellow;
        /*cursor: not-allowed;*/

    }

    a.vote_down_voted{

        color: orangered;

    }


</style>