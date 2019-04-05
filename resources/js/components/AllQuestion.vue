<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h2>All Questions</h2>
                <div class="ml-auto" v-show="is_login">
                    <button @click="createLesson()"  class="btn btn-outline-info">Ask Question</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="media" v-for = "question, key in questions">
                <div class="flex flex-column counters">
                    <div class="vote">
                        <strong>{{question.votes_count}}</strong> Votes
                    </div>
                    <div class=" status" :class="question.status">
                        <strong>{{question.answers_count}}</strong> Answers
                    </div>
                    <div class="view">
                        {{question.views}} Views
                    </div>

                </div>
                <div class="media-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mt-0"><a :href="question.url">{{question.title}}</a></h3>
                        <div class="ml-auto">
                            <button v-show="question.can_edit" @click="editLesson(question)" class="btn btn-sm btn-outline-info">Edit</button>
                            <button v-show="question.can_delete"  @click="deleteLesson(question.id, key)" class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </div>
                    </div>
                    <p class="lead">
                        Asked by <a >{{question.user.name}}</a>
                        <small class="text-muted">{{question.created_date}}</small>
                    </p>
                    <div>
                        {{question.excerpt}}
                    </div>

                    <hr>

                </div>

            </div>

            <!--&lt;!&ndash;<div class="alert alert-warning">-.-->
                <!--&lt;!&ndash;There are no questions. Go <a href="{{route('questions.create')}}">Here</a> to create a question...-.-->
            <!--&lt;!&ndash;</div>-.-->



        </div>
        <vue-create-que></vue-create-que>
        <!--{{questions.links()}}-->

    </div>

</template>

<script>
    import Axios from  'axios'
    import Swal from 'sweetalert'

    export default {

        props: ['raw_questions', 'is_login'],

        mounted(){


            this.$on('add_new_question', (new_que) => {

                this.questions.unshift(new_que);
                Swal('Question Added Successfully!');

            });

            this.$on('add_updated_question', (question) => {

                const index = this.questions.findIndex(item => item.id === question.id);

                this.questions.splice(index, 1, question);

                Swal('Question Updated Successfully!')

            });

        },

        data(){

            return{

                questions: JSON.parse(this.raw_questions)

            }

        },

        methods: {


            createLesson(){

                if(!this.is_login){

                    window.location = '/login'

                }else{

                    this.$emit('create_new_question');

                }

            },

            editLesson(question){

                this.$emit('edit_question', question);

            },
            deleteLesson(id, key){


                if(confirm('Are you sure you want to delete?')) {


                    Axios.delete(`/questions/${id}`)

                        .then(res => {

                            console.log(res);
                            this.questions.splice(key, 1);
                            Swal('Question Deleted Successfully')

                        }).catch(err => {

                        console.log(err)

                    });
                }
            }

        }
    }
</script>

<style scoped>

</style>