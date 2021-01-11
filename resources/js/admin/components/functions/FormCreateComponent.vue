<template>
    <div id="form-create" class="form-create">

        <div id="create-form" class="modal fade form-create__modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">

                       <span v-if="step === 0">Form Details</span>
                       <span v-if="step === 1">Create Form</span>

                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- step one  -->
                    <div  v-if="step === 0" class="form-create__details">
                        <p>Lets start by entering the name of the form and the email you want the form submission to be sent to.</p>
                        <div class="form-group">
                            <label for="form-name">Form Name</label>
                            <input type="text" class="form-control" name="form_name" id="form-name">
                        </div>
                        <div class="form-group">
                            <label for="form-email">Form Email</label>
                            <input type="email" class="form-control" name="form_email" id="form-email">
                        </div>
                    </div>
                    <!-- step one  -->

                    <!-- step two -->

                        <div v-if="step === 1" class="form-create__creator">


                            <!-- <p>Great! Now lets add some form groups. You can add as many form groups as you want! Each group has a heading, and form elements contained in it!</p>


                            <button @click.prevent="form" class="btn btn-primary">Create Form Group</button> -->


                            <div class="form-creator__container d-flex justify-content-between">

                                <div class="form-creator__options">

                                    <button>Single Line</button>
                                    <button>Paragraph</button>
                                    <button>Select</button>
                                    <button>Checkbox</button>
                                    <button>Radio</button>
                                    <button>Number</button>
                                    <button>Email</button>
                                    <button>Phone</button>
                                    <button>Address</button>

                                </div>



                            </div>


                        </div>


                    <!-- step two  -->


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button @click.prevent="next" type="button" class="btn btn-primary">Next <span data-feather="arrow-right"></span></button>
                </div>
                </div>
            </div>
        </div>


        <button @click.prevent data-toggle="modal" data-target="#create-form" class="btn btn-primary">Create Form</button>


    </div><!-- ./form-create  -->



</template>

<script>




export default {

    data() {
        return {
            JsonForms: "",
            currentForm: "",
            step: 0
        }
    },




    methods: {

    // Events ============ /

        next() {







        },



    // Funcitons ============= /

        selectInputs() {









        }



    }


}


</script>

<style>

</style>
