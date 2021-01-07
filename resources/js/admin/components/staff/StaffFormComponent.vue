<template>

    <div class="admin-form staff-create">
        <form id="staff-form" method="post" :action="action" accept-charset="UTF-8" enctype="multipart/form-data">

        <input type="hidden" name="_token" :value="csrf">
        <input id="form-method" v-if="editMode" type="hidden" name="_method" value="PATCH">
        <input v-if="deleteTeachings" type="hidden" name="delete_teachings" value="1">

        <div class="admin-form__wrapper">
            <div class="admin-form__main">
                <div class="form-group">
                    <label for="name">Enter Name</label>
                    <div v-if="errors.name.length" class="invalid-feedback d-block">
                        {{ errors.name[0] }}
                    </div>
                    <input id="name" :class="[{'is-invalid': errors.name.length}, 'form-control']" type="text" name="name" v-model="name">
                </div>

                <div class="form-group">
                    <label for="position">Enter Position</label>
                    <div v-if="errors.position.length" class="invalid-feedback d-block">
                        {{ errors.position[0] }}
                    </div>
                    <input id="position" :class="[{'is-invalid': errors.position.length}, 'form-control']" type="text" name="position" v-model="position">

                    <div class="mb-2"><em>Is this staff member a pastor? if so click yes to display on front of website!</em></div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pastor" id="yes" value="1">
                        <label class="form-check-label" for="yes">
                            Yes
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pastor" id="no" value="0" checked>
                        <label class="form-check-label" for="no">
                            No
                        </label>
                    </div>
                </div>



                <div class="form-group">
                    <label for="bio">Enter Bio</label>
                    <div v-if="errors.bio.length" class="invalid-feedback">
                        {{ errors.bio[0] }}
                    </div>
                    <textarea id="bio" rows="25" :class="[{'is-invalid': errors.bio.length}, 'form-control wysiwyg']" type="text" name="bio" v-model="bio"></textarea>
                </div>
            </div>
            <!-- end of main  -->
            <div class="admin-form__sidebar">
                <p class="admin-form__time">Today's Date: <span id="today"></span></p>
                <div class="form-group admin-form__btns">
                    <button type="submit" class="btn btn-primary btns__icon"><span data-feather="user-plus"></span> {{editMode ? 'Update' : 'Create'}} Staff Member</button>
                </div>
                <div class="form-group admin-form__image">
                    <label for="image">Profile Pic</label>
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
                    <button @click.prevent="deleteStaffMember($event, false)" class="btn btn-danger d-block w-100">Delete Staff Member</button>
                </div>
                <div v-if="editMode" class="card bg-light mt-3 admin-form__timestamps">
                    <div class="card-body">
                        <p class="border-bottom"><span class="font-weight-bold">Date Created:</span> <br/>{{ createdDate }}</p>
                         <p class="border-bottom"><span class="font-weight-bold">Modified Last:</span> <br/>{{ modifiedDate }}</p>
                         <p class="mb-0"><span class="font-weight-bold">Associated Teachings:</span> <br> {{ name }} has {{ teachingsCount }} teachings created</p>
                    </div>
                </div>
            </div>
        </div>

        </form>



            <div id="delete-staff" class="modal fade staff-create__delete-staff" tabindex="-1">
                <div class="modal-dialog" style="max-width: 43.75rem">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center flex-column">
                            <h5 class="modal-title my-3"></h5>
                            <button v-if="!deleteConfirm" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        </div>


                        <div class="modal-body center-block text-center"></div>

                        <div v-if="!deleteConfirm" class="modal-footer justify-content-center">
                            <button @click="deleteStaffMember($event, 'delete_staff')" type="button" class="btn btn-info">Delete Staff Member Only</button>
                            <button @click="deleteStaffMember($event, 'delete_staff_teachings')" type="button" class="btn btn-danger">Delete Staff Member And Teachings</button>
                        </div>

                        <div v-else class="modal-footer justify-content-center">
                            <button @click="dismissModal" type="button" class="btn btn-info">Cancel</button>
                            <button @click="deleteSubmit" type="button" class="btn btn-danger">Yes, I am sure!</button>
                        </div>

                    </div>
                </div>
            </div>




    </div>

</template>

<script>

import { tinymceInit } from '../../mixins/tinymceEditor';

const moment = require('moment');


export default {

    mixins: ['tinymceInit'],

    data() {
        return {
            bio: "",
            createdDate: "",
            deleteConfirm: false,
            deleteTeachings: false,
            editMode: false,
            errors: "",
            image: '',
            modalBody: '',
            modalTitle: '',
            modifiedDate: "",
            name: "",
            position: "",
            staffMember: "",
            oldValues: ""
        }
    },



    props: {
        action: String,
        csrf: String,
        imgPath: String,
        staffData: String,
        submittedValues: String,
        formErrors: String,
        teachingsCount: String
    },


    methods: {


        // Events ===============

        dismissModal() {
            $('#delete-staff').modal('hide');
        },



        cancelModalEvent() {
            $('#delete-staff').on('hidden.bs.modal', () => {
                this.deleteTeachings = false;
                this.deleteConfirm = false;
            });
        },

        deleteSubmit() {
            $('#form-method').val('DELETE');

            setTimeout(() => {
                $('#staff-form').submit();
            }, 100);
        },


        // ======================== #Events





         deleteStaffMember(e, deleteTeachings) {


              if(deleteTeachings) {

                    this.deleteConfirm = true;

                    if(deleteTeachings === 'delete_staff_teachings') this.deleteTeachings = true;


                    let htmlTitle = `<span class="alert alert-danger">Confirm Permanent Delete!</span>`,

                        htmlBody = `Are you sure you want to permanently delete staff member ${this.name}`;


                    if(this.deleteTeachings) {
                        htmlBody += ` and ${this.teachingsCount} teachings associated with staff member?`;
                    } else {
                        htmlBody += `?`;
                    }



                        $(this.modalTitle).html(htmlTitle);
                        $(this.modalBody).html(htmlBody);




                }


                if(!deleteTeachings) {

                    const htmlTitle = "Are you sure you want to delete this staff member?";


                    let htmlBody = `
                        <div class="w-50">
                        <table class="table table-borderless border text-center mb-0">

                            <tr>
                                <td>Name:</td>
                                <td>${this.name}</td>
                            </tr>


                            <tr>
                                <td>Position:</td>
                                <td>${this.position}</td>
                            </tr>


                            <tr>
                                <td>Teachings:</td>
                                <td>${this.teachingsCount}</td>
                            </tr>

                        </table>
                        </div>
                    `;


                    $(this.modalTitle).html(htmlTitle);
                    $(this.modalBody).html(htmlBody);


                    $('#delete-staff').modal('show');

                }

        },



        editStaffMemberSettings() {


        // check if we are not on teaching create
            if(this.staffData) {


            // get the data
                this.staffMember = JSON.parse(this.staffData);


                const imagePath = `${this.staffMember.image}`;

            // switch template to edit mode
                this.editMode = true;


            // set values
                this.bio = this.staffMember.bio;
                this.name = this.staffMember.name;
                this.position = this.staffMember.position;

            // set staff member is pastor
                if(this.staffMember.pastor)
                    $("#yes").prop('checked', true);




            // set bio image if present for edit mode
                this.image = imagePath !== "null" ? `${location.origin}/${imagePath}` :  "";

                this.createdDate = moment(this.staffMember.created_at).format("dddd, MMMM Do YYYY, h:mm:ss a");
                this.modifiedDate = moment(this.staffMember.updated_at).format("dddd, MMMM Do YYYY, h:mm:ss a");

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

        setModalElValues() {
            this.modalBody = $('.modal-body');
            this.modalTitle = $('.modal-title');
        },

        setSubmittedValues() {
            this.oldValues = JSON.parse(this.submittedValues);

            this.name = this.oldValues.name;
            this.position = this.oldValues.position;
            this.bio = this.oldValues.bio;

            this.oldValues.pastor === '1' ?
                $('#yes').prop('checked', true) :
                $('#no').prop('checked', true);
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
        this.setModalElValues();
        this.cancelModalEvent();
        this.editStaffMemberSettings();
        this.todaysDate();
        this.editMode ?? this.setSubmittedValues();
    }


} // end of export default

</script>
