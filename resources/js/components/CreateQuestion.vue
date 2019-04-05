<template>
    <div class="modal fade" id="createQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="question-title">Question Title</label>
                        <input tyape="text" name="title" v-model="question.title"  :class="{'form-control': true, 'is-invalid': errors.hasError('title')}" id="question-title" class="form-control">
                        <div class="invalid-feedback" v-if="errors.hasError('title')" >{{ errors.first('title') }}</div>
                    </div>
                    <div class="form-group">
                        <label for="question-body">Explain you question</label>
                        <textarea name="body" id="question-body" v-model="question.body" :class="{'form-control': true, 'is-invalid': errors.hasError('body')}" rows="10" class="form-control"></textarea>
                        <div class="invalid-feedback" v-if="errors.hasError('body')" >{{ errors.first('body') }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="updateQuestion(question.id)" v-if="editing" >Update question</button>
                    <button type="button" class="btn btn-primary" @click = "storeQuestion()" v-else>Create question</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    import Axios from 'axios'
    import ErrorBag from './errror_bag'
    // import Swal from 'sweetalert'

    class Question{

        constructor(question){

            this.title = question.title || '';
            this.body = question.body || '';

        }

    }

    export default {

        mounted(){

            this.$parent.$on('create_new_question', () => {

                this.editing = false;
                this.question = new Question({});
                $('#createQuestion').modal();

            })

            this.$parent.$on('edit_question', (question) => {

                this.editing = true;
                this.question = new Question(question);
                this.question_id = question.id;
                $('#createQuestion').modal();

            });

        },
        data(){

            return{

                question: new Question({}),
                editing: false,
                errors: new ErrorBag,
                question_id: ''

            }
        },

        methods: {

            storeQuestion(){

                Axios.post('/questions', this.question)

                .then(res => {

                    console.log(res.data);
                    this.$parent.$emit('add_new_question', res.data);

                    $('#createQuestion').modal('hide');

                }).catch(err => {

                    if (err.response && err.response.status == 422) {
                        const errors = err.response.data.errors;
                        this.errors.setErrors(errors);
                    }
                })

            },

            updateQuestion(){

                Axios.put(`/questions/${this.question_id}`, this.question)

                    .then(res => {

                        // console.log(res);
                        this.$parent.$emit('add_updated_question', res.data);

                        $('#createQuestion').modal('hide');


                    }).catch(err => {

                    if (err.response && err.response.status == 422) {
                        const errors = err.response.data.errors;
                        this.errors.setErrors(errors);
                    }else if( err.response.status == 403){
                        window.location = '/403'
                    }
                })

            }

        },

        computed: {

            name(){

                if (this.editing == true){

                    return 'Edit Question'
                }

                return 'Create Question'

            }

        }
    }
</script>

<style scoped>

</style>