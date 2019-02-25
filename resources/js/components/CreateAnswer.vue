<template>
    <div class="modal fade" id="createAnswer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="question-body">Explain you Answer</label>
                        <textarea name="body" id="question-body" v-model="body" rows="10" :class="{'form-control': true, 'is-invalid': errors.hasError('body')}" class="form-control"></textarea>
                        <div class="invalid-feedback" v-if="errors.hasError('body')" >{{ errors.first('body') }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="updateAnswer()"  v-if="editing" >Update Answer</button>
                    <button type="button" class="btn btn-primary" @click="storeAnswer()"  v-else>Create Answer</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios'
    import ErrorBag from './errror_bag'

    export default {

        data(){

            return{

                editing: false,
                body: '',
                question_id: '',
                answer_id: '',
                errors: new ErrorBag,
            }

        },

        mounted(){

            this.$parent.$on('create_new_answer', (question_id) => {

                this.editing = false;
                $('#createAnswer').modal();
                this.question_id = question_id;

                console.log(question_id);

            });

            this.$parent.$on('edit_answer', (answer) => {

                this.editing = true;
                this.question_id = answer.question.id;
                this.answer_id = answer.id;
                this.body = answer.body;

                $('#createAnswer').modal();

                // console.log(answer);

            })

        },

        methods: {

            storeAnswer(){

                Axios.post(`/questions/${this.question_id}/answers`, {

                    body: this.body

                }).then(res => {

                    this.$parent.$emit('stored_answer', res.data);

                    $('#createAnswer').modal('hide');
                    // console.log(res)

                }).catch(err => {

                    console.log(err)
                    if (err.response && err.response.status == 422) {
                        const errors = err.response.data.errors;
                        this.errors.setErrors(errors);
                    }

                })

            },

            updateAnswer(){

                Axios.put(`/questions/${this.question_id}/answers/${this.answer_id}`, {

                    body: this.body

                }).then(res => {

                    this.$parent.$emit('updated_answer', res.data);
                    $('#createAnswer').modal('hide');

                    console.log(res)

                }).catch(err => {

                    console.log(err)
                    if (err.response && err.response.status == 422) {
                        const errors = err.response.data.errors;
                        this.errors.setErrors(errors);
                    }

                })
            }

        },

        computed: {

            name(){

                if (this.editing == true){

                    return 'Edit Answer'
                }

                return 'Create Answer'

            }
        }
    }
</script>

<style scoped>

</style>