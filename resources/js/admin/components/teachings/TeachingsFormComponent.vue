<template>
<div class="admin-form teachings-create">

    <form id="teaching-form" method="POST" :action="action" accept-charset="UTF-8" enctype="multipart/form-data">
        <input name="_token" type="hidden" :value="csrf">
        <input id="form-method" v-if="editMode" name="_method" type="hidden" value="PATCH">
        <div class="admin-form__wrapper">
            <div class="admin-form__main">
                <div class="form-group">
                    <div :class="{'noinput-invalid': errors.title.length}">

                        <label>Teaching Title</label>
                        <div v-if="errors.title.length" class="invalid-feedback d-block">
                            {{ errors.title[0] }}
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="teaching" v-on:change="topical = 0" value="teaching" name="type" class="custom-control-input" checked>
                            <label class="custom-control-label" for="teaching">Use bible scripture specified below for
                                title</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="topical" v-on:change="topical = 1" value="topical" name="type" class="custom-control-input">
                            <label class="custom-control-label" for="topical">Enter a title for topical teaching</label>
                        </div>
                        <input v-if="topical" name="title" v-model="topicalTitle" type="text" placeholder="Enter Topical Title" class="form-control mb-0 mt-2">
                        <input v-if="teachingTitle && !topical" name="title" type="text" placeholder="Enter Title" v-model="teachingTitle" class="form-control mb-0 mt-2">

                    </div>

                </div>

                <div class="form-group">
                    <label for="speaker">Speaker</label>
                    <div v-if="errors.speaker.length" class="invalid-feedback d-block">
                            {{ errors.speaker[0] }}
                        </div>
                    <div class="custom-control custom-checkbox mb-2">

                        <input type="checkbox" class="custom-control-input" id="enterSpeaker" @change="speakerCheckbox" value="1" name="checkbox_speaker">

                        <label class="custom-control-label" for="enterSpeaker">Enter speaker manually</label>
                    </div>
                    <div class="teachings-create__speaker-container">

                        <input type="text" name="speaker" v-if="enterSpeaker" class="form-control mb-0" v-model="speaker" placeholder="Enter Speaker">

                        <select id="staff-select" :class="[{'is-invalid' : errors.speaker.length},'custom-select']" v-if="!enterSpeaker" name="staff_id">
                            <option selected disabled hidden>-- choose from staff members --</option>
                        </select>

                    </div>

                </div>
                <div class="form-group">
                    <label v-if="!videoValue" for="video">Enter Video</label>
                    <div v-if="vidSrc" class="embed-responsive embed-responsive-16by9 teachings-create__media">
                        <iframe class="embed-responsive-item" :src="vidSrc"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                     <div v-if="errors.video.length" class="invalid-feedback d-block">
                            {{ errors.video[0] }}
                        </div>
                    <input :class="[{'is-invalid' : errors.video.length},'form-control']" :value="videoValue" placeholder="Enter Video Url" name="video" type="text" id="video">
                    <div class="teachings-create__media-btns">
                        <button @click="getYoutubeVideos" data-toggle="modal" data-target="#loadMediaModal" type="button" class="btn btn-light btns__icon"><span data-feather="youtube"></span>Get From Youtube</button>
                    </div>
                </div>
                <div class="form-group">
                    <label v-if="!audioUrl" for="audio">Enter Audio</label>
                    <iframe v-if="audioUrl" id="audio_iframe" :src="audioUrl" width="100%" height="100" frameborder="0" scrolling="no">
                    </iframe>
                    <div v-if="errors.audio.length" class="invalid-feedback d-block">
                            {{ errors.audio[0] }}
                        </div>
                    <input :class="[{'is-invalid' : errors.audio.length },'form-control']" :value="audioUrl" name="audio" type="text" id="audio" placeholder="Enter Audio Url">
                    <div class="teachings-create__media-btns">
                        <button @click="getPodbeanAudio" type="button" class="btn btn-light btns__icon" data-toggle="modal" data-target="#loadMediaModal"><span data-feather="volume-2"></span>Get From Podbean</button>
                    </div>

                </div>
                <div class="form-group">
                    <label for="textSelector">Add Text To Teaching</label>
                    <p class="text-secondary">
                        <em>Choose to add text before or after scripture. If you only want text then select "Before Scripture OR Text Only" option and simply don't generate any scripture!</em>
                    </p>
                    <select @change="selectBeforeAfterText" class="custom-select" id="textSelector">
                        <option value="none" selected>No Text</option>
                        <option value="before">Before Scripture OR Only Text</option>
                        <option value="after">After Scripture</option>
                        <option value="both">Before and After Scripture</option>
                    </select>
                </div>

         <!-- select before and after text container  -->
                <div id="select-text-container" class="admin-form__select-text-container"></div>

                <scripture-component :scriptureHtml="scriptureHtml" @description="setDescription($event)" @teachingTitle="setTeachingTitle($event)"></scripture-component>
            </div>

            <aside class="admin-form__sidebar">
                <p class="admin-form__time">Today's Date: <span id="today"></span></p>
                <p :class="setStatusCssStyling" v-if="status && teaching">Teaching Status: <span>{{ status }}</span></p>
                <div class="form-group admin-form__btns">
                    <input id="status" type="hidden" name="status" :value="status">
                    <button @click.prevent="teachingSubmitForm" data-status="Draft" type="submit" class="btn btn-info btns__icon admin-form__publish-btn"><span
                            data-feather="save"></span>Save Draft</button>
                    <button @click.prevent="teachingSubmitForm" data-status="Published" type="submit" class="ml-1 btn btn-primary btns__icon admin-form__publish-btn"><span
                            data-feather="send"></span>{{ editMode && statusPublished() ? 'Update' : 'Publish' }} Teaching</button>
                </div>

                <div class="form-group">
                    <label for="publish-date" class="d-block">Publish Date</label>
                    <input class="form-control" name="publish_date" type="date" id="publish-date">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <div v-if="errors.description.length" class="invalid-feedback d-block">
                            {{ errors.description[0] }}
                        </div>
                    <textarea v-model="description" :class="[{'is-invalid' : errors.description.length},'form-control']" rows="4" name="description" cols="50" id="description"></textarea>
                    <button v-if="description" @click.prevent="clearDescription" id="clear-description" class="btn btn-light admin-form__sidebar-btn">&times; Clear Description</button>
                </div>

                <div class="form-group admin-form__image">
                    <label for="image">Featured Image</label>
                    <input @change="imagePreview" class="form-control-file admin-form__ft-img-input" name="ft_image" type="file" id="ft_image">
                    <div class="admin-form__image-preview">
                        <div v-if="!ftImg" :class="[{'noinput-invalid': errors.ft_image.length}]">
                            <img class="img-fluid" :src="imgPath" alt="select-image">
                        </div>

                        <img v-else :src="ftImg" :class="[{'noinput-invalid':errors.ft_image.length},'img-fluid', 'd-block']">
                        <div v-if="errors.ft_image.length" class="invalid-feedback d-block">
                                {{ errors.ft_image[0] }}
                        </div>
                        <button v-if="ftImg" @click.prevent="removeImg" id="remove-img" class="btn btn-light admin-form__sidebar-btn">&times; Remove Image</button>
                    </div>
                </div>
                <div v-if="editMode" class="admin-form__delete">
                    <button @click.prevent="deleteTeaching" class="btn btn-danger d-block w-100">Delete Teaching</button>
                </div>
                <div v-if="editMode" class="card bg-light mt-3 admin-form__timestamps">
                    <div class="card-body">
                         <p class="border-bottom"><span class="font-weight-bold">Publish Date:</span> <br/>{{ publishDate }}</p>
                        <p class="border-bottom"><span class="font-weight-bold">Date Created:</span> <br/>{{ createdDate }}</p>
                         <p><span class="font-weight-bold">Modified Last:</span> <br/>{{ modifiedDate }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </form>


    <!-- Scrollable modal -->
    <div class="modal fade media-modal" id="loadMediaModal" tabindex="-1"  aria-hidden="true">

        <div class="modal-dialog media-modal__dialog">
            <div class="modal-content">

                <div class="media-modal__container">
                    <div id="media-container" v-bind:class="[loader ? 'media-modal__wrapper-loader' : '', 'media-modal__wrapper']">
                    </div>
                    <div class="media-modal__more-container">
                        <button @click="modalLoadMoreBtn" class="btn btn-secondary media-modal__load-more-btn" :disabled="!loadmore">Load More <span v-if="loadMoreBtn" class="spinner-border spinner-border-sm"></span></button>
                    </div>
                </div>

                <div class="modal-footer media-modal__footer">
                    <button @click="deselectAllMedia" type="button" class="btn btn-light mr-auto" :disabled="!mediaSelected">Clear Selection</button>
                    <button type="button" class="btn btn-danger media-modal__cancel" data-dismiss="modal">Cancel</button>
                    <button @click="insertMedia" data-dismiss='modal' type="button" class="btn btn-primary" :disabled="!mediaSelected">Insert Media</button>
                </div>
            </div>
        </div>
    </div>

</div>

</template>

<script>


const moment = require('moment');

import { tinymceInit } from '../../mixins/tinymceEditor';

const ScriptureComponent = Vue.component('scripture-component', require('./ScriptureComponent.vue').default);



export default {

    mixins: ['tinymceInit'],

    data() {
        return {
            afterText: "",
            audioId: '',
            audioUrl: '',
            baseUrl: location.origin + "/api/",
            beforeText: "",
            createdDate: "",
            description: '',
            editMode: false,
            enterSpeaker: false,
            errors: "",
            formSubmitting: false,
            ftImg: "",
            loader: false,
            loadmore: true,
            loadMoreBtn: false,
            oldValues: "",
            mediaSelected: false,
            mediaType: '',
            modifiedDate: "",
            publishDate: "",
            scriptureHtml: '',
            status: '',
            speaker: '',
            teaching: '',
            teachingTitle: "",
            topical: false,
            topicalTitle: '',
            type: '',
            vidId: '',
            vidSrc: '',
            videoValue: ''
        }
    },

    components: {
        ScriptureComponent
    },

    props: {
        action: String,
        csrf: String,
        teachingData: String,
        imgPath: String,
        staffMembers: String,
        formErrors: String,
        submittedValues: String
    },


    computed: {

        setStatusCssStyling() {

            const statusClass = "admin-form__time d-inline-block alert alert-";

            return this.status === "Draft" ?
                        statusClass + "danger" :
                        statusClass + "success"
        }



    },



    methods: {

    // Event methods =========/
        // ========================

    // add event for audio input change

        audioValueChange() {
            const audioInput = $('[name="audio"]');

            $(audioInput).on('change', e => {
                this.insertAudio(e);
            });

        },


        clearDescription() {
            $("#description").val("");
        },

    // insert featured image onto screen before loading into the database
        imagePreview(e) {

            this.errors.ft_image = [];

            const file = e.target.files[0];
            this.readFile(file);
        },


    // emptyModal when backdrop is clicked
        modalBackdropClickCancel() {
            $("#loadMediaModal").on('hide.bs.modal', this.emptyModal);
        },

        speakerCheckbox() {

            this.enterSpeaker ?
                this.enterSpeaker = false :
                this.enterSpeaker = true;

            setTimeout(() => {
                this.setStaffOptions();
            }, 50);


        },


    // add event for select media
        selectedMediaEvent() {
            // add event handler

            const allMedia = $('.media-modal__media');

            $(allMedia).each( (i, media) => {
                $(media).on('click', e => {
                    this.selectMedia(e);
                });
            } );

        },

    // and event for select before after text
        selectBeforeAfterText(e = null, value="") {

            const selectValue = e ? $(e.target).val() : value,
                  beforeText = $("#before-text"),
                  afterText = $("#after-text"),
                  htmlContainer = $("#select-text-container");

            let beforeHtml = `<div id="before-text" class="form-group">

                    <label for="before">Before Scripture Text</label>
                    <textarea class="form-control wysiwyg" name="before_text" id="before" cols="30" rows="15"></textarea>

                </div>`;

            let afterHtml = `<div id="after-text" class="form-group">

                    <label for="after">After Scripture Text</label>
                    <textarea class="form-control wysiwyg" name="after_text" id="after" cols="30" rows="15"></textarea>

                </div>`;



            switch (selectValue) {
                case 'before':

                    $('#after-text').remove();

                    if(!$(beforeText).length)
                        $(htmlContainer).prepend(beforeHtml);

                    if(this.beforeText) {

                        $('#before').html(this.beforeText);
                        this.beforeText = "";

                        $("[value=before]").prop('selected', true);

                    }
                    break;

                case 'after':

                    $('#before-text').remove();

                    if(!$(afterText).length)
                        $(htmlContainer).append(afterHtml);

                    if(this.afterText) {

                            $('#after').html(this.afterText);

                            this.afterText = "";

                            $("[value=after]").prop('selected', true);

                        }

                    break;


                case 'both':

                        if($(beforeText).length) {
                            $(htmlContainer).append(afterHtml);
                            break;
                        }

                        if($(afterText).length) {
                            $(htmlContainer).prepend(beforeHtml);
                            break;
                        }


                        $(htmlContainer).prepend(beforeHtml);
                        $(htmlContainer).append(afterHtml);



                         $('#before').html(this.beforeText);
                        this.beforeText = "";

                         $('#after').html(this.afterText);
                        this.afterText = "";


                        $("[value=both]").prop('selected', true);


                    break;

                default:

                    $(htmlContainer).html('');

                    $("[value=none]").prop('selected', true);

                    break;
            }


        // Remove previous instances for re-rendering on toggle
            tinymce.remove();


            setTimeout(() => {
                tinymceInit();
            }, 100);
        },


        teachingSubmitForm(e) {

            if(!this.formSubmitting) {

               this.formSubmitting = true;

               this.status = $(e.target).attr("data-status");

                setTimeout(() => {
                    $('#teaching-form').submit();
                }, 500);

            }

        },


    // add event for video input change
        vidValueChange() {

            const videoInput = $('[name="video"]');

            $(videoInput).on('change', e => {
                this.insertVideo(e);
            });

        },





     // Main methods ==========/
        //=================/

    // function to disable load more btn if no more media is available to load
        checkLoadMore() {

            if(this.mediaType === 'audio') {

            // disable load more btn
                this.loadmore = parseInt($(".media-modal__body").last().attr('data-np'));

            }


            if(this.mediaType === 'video') {

                const more = $(".media-modal__body").last().attr('data-np');

                // if no more disable load more btn
                if(more === '0') this.loadmore = parseInt(more);

            }
        },


        dateDefaultVal(editModeDate = "") {

            const input = $("#publish-date");

            let date = editModeDate ?

                    editModeDate :
                    moment().format("YYYY-MM-DD");


            $(input).attr('value', date);

        },



        deleteTeaching() {

            const confirmed = confirm(`Are you sure you want to delete teaching ${this.teachingTitle}`);

            if(confirmed) {
                $('#form-method').val('DELETE');
                $('#teaching-form').submit();
            }
        },



    // deselect the media
        deselectAllMedia() {
            const allMedia = $('.media-modal__media');

            $(allMedia).each( ( i, media ) => {

                if( $(media).hasClass('media-modal__selected-media') ) {

                    $(media).removeClass('media-modal__selected-media');

                    $(media).find('.custom-control-input').prop('checked', false);
                }

            } );

            this.mediaSelected = false;

        },


    // Empty the modal media
         emptyModal() {
            const mediaContainer = $('#media-container');
            $(mediaContainer).html('');
            this.mediaType = '';
        },

    // insert video values on edit page
        insertEditVideoValues(videoUrl) {
            const ytEmbed = 'https://www.youtube.com/embed/',
                  regX = /(?<=https:\/\/youtu\.be\/).+$/;

                  if(videoUrl) {
                    const vidId = videoUrl.match(regX)[0];
                        this.vidId = vidId;
                        this.vidSrc = ytEmbed + vidId;
                        this.videoValue = videoUrl;
                  }
        },

    // WOKING HERE====================


        editTeachingSettings() {

        // check if we are not on teaching create
            if(this.teachingData) {



            // switch template to edit mode
                this.editMode = true;

                 // get the data
                this.teaching = JSON.parse(this.teachingData);




                const imagePath = `${this.teaching.ft_image}`;




            // set values
                this.setEditTeachingTitle(this.teaching);



                this.description = this.teaching.description;
                this.scriptureHtml = this.teaching.scripture;

                this.insertEditVideoValues(this.teaching.video);

                this.audioUrl = this.teaching.audio;
                this.status = this.teaching.status;
                this.setEditStaffSpeakerValues(this.teaching);


            // set the before and after scripture text
                this.setSelectTextValues(this.teaching);



                this.dateDefaultVal(this.teaching.publish_date);

            // set featured image if present for edit mode
                this.ftImg = imagePath !== "null" ? `${location.origin}/${imagePath}` :  "";


            // set date meta at end of sidebar
                this.createdDate = moment(this.teaching.created_at).format("dddd, MMMM Do YYYY, h:mm:ss a");

                this.publishDate = moment(this.teaching.publish_date).format("dddd, MMMM Do YYYY");

                this.modifiedDate = moment(this.teaching.updated_at).format("dddd, MMMM Do YYYY, h:mm:ss a");
            }
        },


        setSubmittedValues() {

            if(this.submittedValues) {

                this.oldValues = JSON.parse(this.submittedValues);


                if(this.oldValues.title)
                        this.setEditTeachingTitle(this.oldValues);


                if(this.oldValues.staff_id || this.oldValues.speaker)
                        this.setEditStaffSpeakerValues(this.oldValues);


                if(this.oldValues.video)
                        this.insertEditVideoValues(this.oldValues.video);


                if(this.oldValues.audio)
                        this.audioUrl = this.oldValues.audio;


                if( this.oldValues.before_text || this.oldValues.after_text )
                    this.setSelectTextValues(this.oldValues);


                if(this.oldValues.scripture)
                    this.scriptureHtml = this.oldValues.scripture;

                if(this.oldValues.description)
                    this.description = this.oldValues.description;


                if(this.oldValues.publish_date)
                    this.dateDefaultVal(this.oldValues.publish_date);

            }



        },


        setSelectTextValues(teaching) {

            // select text options
                this.beforeText = teaching.before_text;
                this.afterText =  teaching.after_text;

            if(this.beforeText && this.afterText) {
                this.selectBeforeAfterText(null, 'both');
                return;
            }

            if(this.beforeText) {
                this.selectBeforeAfterText(null, 'before');
                return;
            }


            if(this.afterText) {
                this.selectBeforeAfterText(null, 'after');
                return;
            }

        },

        setEditStaffSpeakerValues(teaching) {

            if(!teaching.staff_id) {
                this.speaker = teaching.speaker;
                this.enterSpeaker = true;
                $("#enterSpeaker").prop('checked', true);
            } else {
                const staffId = teaching.staff_id;
                $(`[value=${staffId}]`).prop('selected', true);
                this.enterSpeaker = false;
                $("#enterSpeaker").prop('checked', false);
            }


        },


        setEditTeachingTitle(teaching) {

           if(teaching.type === 'topical') {
               $("#topical").prop('checked', true);
               this.topical = true;
               this.topicalTitle = teaching.title;
           }

           if (teaching.type === 'teaching') {

               $("#teaching").prop('checked', true);
               this.topical = false;
               this.teachingTitle = teaching.title;

           }

        },



        getPodbeanAudio(e, nextPage = '') {
            this.mediaType = 'audio';

            const audioContainer = $('#media-container');
            let pbUrl = this.baseUrl + "podbean";

        // create url if next page token is true
            pbUrl = this.nextPageUrl(nextPage, pbUrl);


            axios.get( pbUrl )
                .then(res => {
                    !nextPage ?
                       $(audioContainer).html(res.data) :
                       $(audioContainer).append(res.data);
                })
                .catch(error => {
                const html = `<div class="alert alert-danger">${error}</div>`;
                    $(audioContainer).html(html);
                })
                .then( () => {

                // add select media event to each media
                    this.selectedMediaEvent();

                // add backdrop close event
                    this.modalBackdropClickCancel();


                // this.loadMoreBtn = false;
                    this.modalPageControl(nextPage);

                    this.checkLoadMore();

                } );

        },



        getYoutubeVideos(e, nextPage = '') {

        //set media type for modal
        this.mediaType = 'video';

        // Where media is inserted after API call
            const videosContainer = $('#media-container');

        // base url ofr youtube videos
            let   ytUrl = this.baseUrl + "youtube";


        // create url if next page token is true
            ytUrl = this.nextPageUrl(nextPage, ytUrl);

        // Make request
            axios.get(ytUrl)
                .then( res => {

                    const videoHtml = res.data;

                    !nextPage ?
                        $(videosContainer).html(videoHtml) :
                        $(videosContainer).append(videoHtml);

                } )
                .catch( error => {
                    const html = `<div class="alert alert-danger">${error}</div>`;
                    $(videosContainer).html(html);
                } )
                .then( () => {

                    this.modalPageControl(nextPage);

                // add select media event to each media
                    this.selectedMediaEvent();

                 // add backdrop close event
                    this.modalBackdropClickCancel();

                    this.checkLoadMore();

                } );
        },



        insertAudio(e) {

            if(e.type === 'change') {

                const regEx = /\w{5}-\w{6}/;

                let audioValue = $(e.target).val();

                    if(audioValue.includes('www.podbean.com')) {

                        const audioId = audioValue.match(regEx)[0],
                              audioUrl = `https://www.podbean.com/media/player/${audioId}`;


                             this.audioUrl = audioUrl;
                    } else {
                        this.errors.audio.push('URL must come from Podbean!');
                        this.audioUrl = "";
                        $(e.target).val("");
                    }

            }

        },

        insertMedia(e) {

           if(this.mediaType === 'video') {
               this.insertVideo(e)
           }


           if(this.mediaType === 'audio') {
               this.insertAudio(e);
           }

        },

        insertVideo(e) {

            const ytUrl = 'https://youtu.be/',
                  ytEmbed = 'https://www.youtube.com/embed/'


            if(e.type === 'change') {

            const vidVal = $('[name="video"]').val(),
                  regX = /(?<=https:\/\/youtu\.be\/).+$/;

                  if(!vidVal) {

                      this.videoValue = '';
                      this.vidSrc = '';

                      return;

                  } else {
                      if(vidVal.match(regX)) {
                          this.vidId = vidVal.match(regX)[0];
                      } else {
                          $(e.target).val("");
                          this.videoValue = "";
                          this.vidId = "";
                          this.vidSrc = "";
                          this.errors.video.push('URL must be a share Youtube URL');
                          return;
                      }

                  }

            }

            this.videoValue = ytUrl + this.vidId;
            this.vidSrc = ytEmbed + this.vidId;

        },


         modalLoaderHTML() {

            let media = '';

            if(this.mediaType === 'video') media = 'Videos';

            if(this.mediaType === 'audio') media = 'Audio';


            const html =
                    `<div class="media-modal__loader">
                       <div class="media-modal__loading">
                           <h4>Loading ${media}...</h4> <div class="spinner-border" role="status"></div>
                       </div>
                    </div>`;

            return html;
        },



        modalLoadMoreBtn() {

             // get the next page token
                const nextPage = $('.media-modal__body').last().attr('data-np');

            if(this.mediaType === 'video') {
                // send request with nextPage token
                this.getYoutubeVideos(null, nextPage);
            }

            if(this.mediaType === 'audio') {
                this.getPodbeanAudio(null, nextPage);
            }

        },

        modalPageControl(nextPage) {

            // used to turn loader off and reset modal page to new incoming data scroll top

            if(!nextPage) {

                    this.loader = false

                } else {

                // this is used to get the modal back up to the top of the new request
                    const vidId = $('.media-modal__body').last().attr('id');

                    window.location = `${location.origin}/admin/teachings/create#${vidId}`;

                    this.loadMoreBtn = false;
                }
        },

        nextPageUrl(nextPage, url) {

            if(nextPage) {
                url += `/?nextPage=${nextPage}`;
                this.loadMoreBtn = true;
            } else {
                $('#media-container').html(this.modalLoaderHTML);
                this.loader = true;
            }

            return url;

        },


        readFile(file) {

            const reader = new FileReader();

            $(reader).on('load', (e) => {
                this.ftImg = e.target.result;
            });

             reader.readAsDataURL(file);
        },


        removeImg() {
            $('#ft_image').val('');
            this.ftImg = '';
        },


        selectMedia(e) {

            let media = $(e.target).closest(".media-modal__media");



            // remove all media-modal__selected-media classes
            this.deselectAllMedia();

            // target right element
            if(!$(media).hasClass('media-modal__media'))
                media = $(media).parents('.media-modal__media');

            $(media).addClass('media-modal__selected-media');

            $(media).find('.custom-control-input').prop('checked', true);


            this.mediaSelected = true;


            if(this.mediaType === 'video') {
                // Set the vidId ========/
    // ALL "media" vars below in video and audio were e.target

                this.vidId = $(media).attr('data-media-id');
            }

            if(this.mediaType === 'audio') {
                // Set the audio Id =======/
                this.audioId = $(media).attr('data-media-id');
                this.audioUrl = $(media).attr('data-audio-url');
            }

        },

        setDescription(description) {
            this.description = description;
        },




         setFormErrors() {
            this.errors = JSON.parse(this.formErrors);
        },




        setStaffOptions() {

            const staffSelect = $('#staff-select'),
                  staffData = JSON.parse(this.staffMembers);
            let   html = "";


                  $(staffData).each( ( i, staffMember ) => {

                      html += `<option value="${staffMember.id}">${staffMember.position} - ${staffMember.name}</option>`;

                  } );

                $(staffSelect).append(html);

        },


        setTeachingTitle(title) {
            this.teachingTitle = title;
        },

        statusPublished() {
            return this.status !== "Published" ?
                false : true;
        },


        todaysDate() {
            const today = moment().format('dddd MMM Do, YYYY');

             $('#today').text(today);
        }


    }, // end of methods =========/

    created() {
         this.setFormErrors();
    },

    mounted() {
        tinymceInit();
        this.audioValueChange();
        this.dateDefaultVal();
        this.modalBackdropClickCancel();
        this.setStaffOptions();
        this.todaysDate();
        this.vidValueChange();
        this.setSubmittedValues();

        // Run to set all values last
        this.editTeachingSettings();
    }

}
</script>

<style>

</style>
