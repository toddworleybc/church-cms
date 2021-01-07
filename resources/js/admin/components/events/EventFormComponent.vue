<template>

    <div class="admin-form staff-create">
        <form id="event-form" method="post" :action="action" accept-charset="UTF-8" enctype="multipart/form-data">

        <input type="hidden" name="_token" :value="csrf">
        <input id="form-method" v-if="editMode" type="hidden" name="_method" value="PATCH">


        <div class="admin-form__wrapper">
            <div class="admin-form__main">
                <div class="form-group">
                    <label for="name">Event Name</label>
                    <div v-if="errors.name.length" class="invalid-feedback d-block">
                        {{ errors.name[0] }}
                    </div>
                    <input id="name" :class="[{'is-invalid': errors.name.length}, 'form-control']" type="text" name="name" v-model="name" required>
                </div>

                <div class="form-group">
                    <label for="name">Coordinator Name/Host</label>
                    <div v-if="errors.coordinator.length" class="invalid-feedback d-block">
                        {{ errors.coordinator[0] }}
                    </div>
                    <input id="coordinator" :class="[{'is-invalid': errors.coordinator.length}, 'form-control']" type="text" name="coordinator" v-model="coordinator">
                     <label for="phone">Coordinator Phone</label>
                    <div v-if="errors.phone.length" class="invalid-feedback d-block">
                        {{ errors.phone[0] }}
                    </div>
                    <input id="phone" :class="[{'is-invalid': errors.phone.length}, 'form-control']" type="phone" name="phone" v-model="phone">
                    <label for="email">Coordinator Email</label>
                    <div v-if="errors.email.length" class="invalid-feedback d-block">
                        {{ errors.email[0] }}
                    </div>
                    <input id="email" :class="[{'is-invalid': errors.email.length}, 'form-control']" type="email" name="email" v-model="email">
                </div>


                <div class="form-group">
                    <label for="address">Event Address</label>
                    <div v-if="errors.address.length" class="invalid-feedback d-block">
                        {{ errors.address[0] }}
                    </div>
                    <input id="address" :class="[{'is-invalid': errors.address.length}, 'form-control']" type="text" name="address" v-model="address">

                     <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="state">State</label>
                        <select id="state" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="zip">Zip</label>
                        <input type="text" class="form-control" id="zip">
                    </div>
                </div>

                </div>





                <div class="form-group">
                    <label for="details">Event Details</label>
                    <div v-if="errors.details.length" class="invalid-feedback">
                        {{ errors.details[0] }}
                    </div>
                    <textarea id="details" rows="25" :class="[{'is-invalid': errors.details.length}, 'form-control wysiwyg']" type="text" name="details" v-model="details"></textarea>
                </div>
            </div>
            <!-- end of main  -->
            <div class="admin-form__sidebar">
                <p class="admin-form__time">Today's Date: <span id="today"></span></p>
                <div class="form-group admin-form__btns">
                    <button type="submit" class="btn btn-primary btns__icon"><span data-feather="user-plus"></span> {{editMode ? 'Update' : 'Create'}} Event</button>
                </div>
                <div class="form-group">
                    <label for="event-date" class="d-block">Event Date</label>
                    <input class="form-control" name="date" type="date" id="event-date">
                </div>
                <div class="form-group">
                    <label for="event-time" class="d-block">Event time</label>
                    <input class="form-control" name="time" type="time" id="event-time">
                </div>
                <div class="form-group admin-form__image">
                    <label for="image">Event Flyer</label>
                    <div class="custom-file">
                        <input @change="imagePreview"  class="form-control-file admin-form__ft-img-input" name="image" type="file" id="image">
                    </div>

                    <div class="admin-form__image-preview">

                        <img v-if="!image" aria-describedby="image-feedback" :class="[{ 'noinput-invalid': errors.image.length }, 'img-fluid']" :src="imgPath" alt="select-image">



                        <img v-else :src="image" :class="[{ 'is-invalid': errors.image.length }, 'img-fluid d-block']">

                        <div v-if="errors.image.length" id="image-feedback" class="invalid-feedback d-block">{{ errors.image[0] }}</div>

                        <button v-if="image" @click.prevent="removeImg" id="remove-img" class="btn btn-light admin-form__sidebar-btn">&times; Remove Image</button>
                    </div>
                </div>
                <div v-if="editMode" class="admin-form__delete">
                    <button @click.prevent="deleteEvent" class="btn btn-danger d-block w-100">Delete Event</button>
                </div>
                <div v-if="editMode" class="card bg-light mt-3 admin-form__timestamps">
                    <div class="card-body">
                        <p class="border-bottom"><span class="font-weight-bold">Date Created:</span> <br/>{{ createdDate }}</p>
                         <p class="border-bottom"><span class="font-weight-bold">Modified Last:</span> <br/>{{ modifiedDate }}</p>
                    </div>
                </div>
            </div>
        </div>

        </form>



    </div>

</template>

<script>

import { tinymceInit } from '../../mixins/tinymceEditor';

const moment = require('moment');


export default {

    mixins: ['tinymceInit'],

    data() {
        return {
            address: "",
            city: "",
            coordinator: "",
            createdDate: "",
            date: "",
            details: "",
            editMode: false,
            email: "",
            errors: "",
            event: "",
            image: '',
            modifiedDate: "",
            name: "",
            oldValues: "",
            phone: "",
            state: "",
            zip: ""
        }
    },



    props: {
        action: String,
        csrf: String,
        imgPath: String,
        EventData: String,
        submittedValues: String,
        formErrors: String,
    },


    methods: {


        // Events ===============

        dismissModal() {
            $('#delete-staff').modal('hide');
        },



        deleteEvent() {
            $('#form-method').val('DELETE');

            setTimeout(() => {
                $('#event-form').submit();
            }, 100);
        },


        // ======================== #Events

        dateDefaultVal(editModeDate = "") {

            const input = $("#event-date");

            let date = editModeDate ?

                    editModeDate :
                    moment().format("YYYY-MM-DD");


            $(input).attr('value', date);

        },



        editEventSettings() {


        // check if we are not on event create
            if(this.eventData) {


            // get the data
                this.event = JSON.parse(this.eventData);


                const imagePath = `${this.event.image}`;

            // switch template to edit mode
                this.editMode = true;


            // set values
                this.address = this.event.bio;
                this.city = this.event.city;
                this.details = this.event.details;
                this.name = this.event.name;
                this.state = this.event.state;
                this.zip = this.event.zip;


                this.dateDefaultVal(this.event.date);

            // set bio image if present for edit mode
                this.image = imagePath !== "null" ? `${location.origin}/${imagePath}` :  "";

                this.createdDate = moment(this.event.created_at).format("dddd, MMMM Do YYYY, h:mm:ss a");
                this.modifiedDate = moment(this.event.updated_at).format("dddd, MMMM Do YYYY, h:mm:ss a");

            }
        },


    // insert featured image onto screen before loading into the database
        imagePreview(e) {
            const file = e.target.files[0];
            this.readFile(file);
        },


        readFile(file) {

            const reader = new FileReader();

            $(reader).on('load', (e) => {
                this.image = e.target.result;
            });

             reader.readAsDataURL(file);
        },

         removeImg() {
            $('#image').val('');
            this.image = '';
        },


         setFormErrors() {
            this.errors = JSON.parse(this.formErrors);
        },


        setSubmittedValues() {
            this.oldValues = JSON.parse(this.submittedValues);

            this.address = this.event.bio;
            this.city = this.event.city;
            this.details = this.event.details;
            this.name = this.event.name;
            this.state = this.event.state;
            this.zip = this.event.zip;


        },

         todaysDate() {
            const today = moment().format('dddd MMM Do, YYYY');
             $('#today').text(today);
        },

    },

    created() {
        this.setFormErrors();
    },



    mounted() {
        tinymceInit();
        this.dateDefaultVal();
        this.editEventSettings();
        this.todaysDate();
        this.editMode ?? this.setSubmittedValues();
    }


} // end of export default

</script>
