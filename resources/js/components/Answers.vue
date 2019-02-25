<template>
    <div>

        <div class="d-flex offset-4 mb-1">
            <button @click="createAnswer(questionId)" style="margin-top: 0px"  class="col-4 btn btn-outline-info">Add Answer</button>
        </div>

        <div class="row mt-3" v-if="answers.length > 0">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>{{answers.length}} Answers</h2>
                        </div>
                        <hr>
                        <div class="media" v-for="answer, key in answers">
                            <div class="d-flex flex-column vote-controls">
                                <a @click="upVoteAnswer(answer)" title="Up Vote" class="vote-up" :class="!isLogin ? 'off' : (answer.is_up_voted ? 'vote-accepted' : 'd')"
                                   >
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">{{answer.votes_count}}</span>
                                <a @click="downVoteAnswer(answer)" title="Down Vote" class="vote-down" :class="!isLogin ? 'off' : (answer.is_down_voted ? 'vote_down_voted' : 'd')"
                                  >
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>

                                <a @click = "acceptBestAnswer(answer)" title="Accept answer" v-if="answer.can_accept" :class="answer.status_best" class="mt-2 "
                                   >
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <a v-else  v-show="answer.is_best" title="Best Answer!" :class="answer.status_best" class="mt-2 alt_best">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <div v-html = answer.body_html></div>
                                <!-- {{ answer.body_html }} -->

                                <div class="row">
                                    <div class="col-4">
                                        <div class="ml-auto">
                                            <button v-show ="answer.can_edit" @click="editAnswer(answer)" class="btn btn-sm btn-outline-info">Edit</button>
                                            <button v-show="answer.can_delete" @click="deleteAnswer(answer, key)" class="btn btn-outline-danger btn-sm">Delete</button>
                                        </div>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <span class="text-muted">Answered {{answer.created_date}}</span>
                                        <div class="media mt-2">
                                            <a :href="answer.user.url" class="pr-2">
                                                <img :src="answer.user.avatar" alt="" >
                                            </a>
                                            <div class="media-body">
                                                <a :href="answer.user.url">{{answer.user.name}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<div class="d-flex offset-4">-->
            <!--<button @click="createAnswer(answers[0].question.id)" style="margin-top: 0px"  class="col-4 btn btn-outline-info">Add Answer</button>-->
        <!--</div>-->
        <vue-create-answer></vue-create-answer>
    </div>
</template>

<script>
    import  Axios from  'axios'
    import Swal from 'sweetalert'
    export default {

        props: ['isLogin', 'answers', 'question_id'],

        mounted(){

            this.$on('stored_answer', (answer) => {


                this.answers.unshift(answer);

                Swal('Answer Added Successfully');

            });

            this.$on('updated_answer', (answer) => {

                const index = this.answers.findIndex(item => item.id === answer.id);

                this.answers.splice(index, 1, answer);

                Swal('Answer Updated Successfully');

            });

        },

        data(){

            return{

                questionId: this.question_id

            }

        },

        methods: {

            createAnswer(question_id){

                this.$emit('create_new_answer', question_id)
            },

            editAnswer(answer){

                this.$emit('edit_answer', answer)
            },

            deleteAnswer(answer, key){

                Axios.delete(`/questions/${answer.question.id}/answers/${answer.id}`)
                .then(res => {

                    this.answers.splice(key, 1);

                    Swal('Answer Deleted Successfully')

                    // console.log(res)
                }).catch(err => {
                    console.log(err)

                })

            },


            upVoteAnswer(answer){

                if(!this.isLogin){

                    window.location = '/login'

                }

                Axios.post(`/answer/${answer.id}/vote`)

                    .then(res => {

                        answer.votes_count = res.data.votes_count;

                        answer.is_up_voted = res.data.is_up_voted;

                        answer.is_down_voted = res.data.is_down_voted;

                        const index = this.answers.findIndex(item => item.id === answer.id);

                        this.answers.splice(index, 1, answer);


                    }).catch(err => {

                    console.log(err);

                });
            },

            downVoteAnswer(answer){

                if(!this.isLogin){

                    window.location = '/login'

                }

                Axios.post(`/answer/${answer.id}/unvote`)

                    .then(res => {

                        answer.votes_count = res.data.votes_count;

                        answer.is_up_voted = res.data.is_up_voted;

                        answer.is_down_voted = res.data.is_down_voted;

                        const index = this.answers.findIndex(item => item.id === answer.id);

                        this.answers.splice(index, 1, answer);


                    }).catch(err => {

                    console.log(err);

                });
            },

            acceptBestAnswer(answer){

                Axios.post(`/answer/${answer.id}/accept`)

                .then(res => {

                    console.log(res.data);

                    const indexAns = this.answers.findIndex(item => item.is_best === true);

                    this.answers[indexAns].is_best = false;
                    this.answers[indexAns].status_best = '';

                    // console.log(this.answers[indexAns].is_best);
                    // console.log(this.answers[indexAns].status_best);

                    answer.status_best = res.data.status_best;

                    answer.is_best = res.data.is_best;

                    const index = this.answers.findIndex(item => item.id === answer.id);

                    this.answers.splice(index, 1, answer);


                }).catch(err => {

                    console.log(err);
                })

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

    a.alt_best, a.alt_best:hover{

        color: greenyellow;
        cursor: not-allowed;
    }
</style>