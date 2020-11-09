<template>
<div class="admin-form teachings-create">

    <form method="POST" :action="action" accept-charset="UTF-8">
        <input name="_token" type="hidden" :value="csrf">
        <div class="admin-form__wrapper">
            <div class="admin-form__main">
                <div class="form-group">
                    <label>Teaching Title</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="bible" v-on:change="topical = 0" name="title" class="custom-control-input" checked>
                        <label class="custom-control-label" for="bible">Use bible scripture specified below for
                            title</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="topical" v-on:change="topical = 1" name="title" class="custom-control-input">
                        <label class="custom-control-label" for="topical">Enter a title for topical teaching</label>
                    </div>
                    <input v-if="topical" name="title" type="text" placeholder="Enter Title" class="form-control mb-0 mt-2">
                    <input v-if="teachingTitle && !topical" name="title" type="text" placeholder="Enter Title" :value="teachingTitle" class="form-control mb-0 mt-2">
                </div>

                <div class="form-group">
                    <label for="speaker">Speaker</label>
                    <div class="custom-control custom-checkbox mb-2">



                        <input type="checkbox" class="custom-control-input" id="enterSpeaker" v-on:change="enterSpeaker = !enterSpeaker">


                        <label class="custom-control-label" for="enterSpeaker">Enter speaker manually</label>
                    </div>
                    <div class="teachings-create__speaker-container">

                        <input type="text" name="speaker" v-show="enterSpeaker" class="form-control mb-0" placeholder="Enter Speaker">

                        <select class="custom-select" v-show="!enterSpeaker" name="speaker">
                            <option data-staff="Pastor James Wafer" value="1" selected="selected">Pastor James Wafer</option>
                            <option data-staff="Pastor Dale Richmond" value="2">Pastor Dale Richmond</option>
                            <option data-staff="Reciptionist Kelly Munsion" value="3">Reciptionist Kelly Munsion</option>
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
                    <input class="form-control" :value="videoValue" placeholder="Enter Video Url" name="yt_video" type="text" id="video">
                    <div class="teachings-create__media-btns">
                        <button @click="getYoutubeVideos" data-toggle="modal" data-target="#loadMediaModal" type="button" class="btn btn-light btns__icon"><span data-feather="youtube"></span>Get From Youtube</button>
                    </div>
                </div>
                <div class="form-group">
                    <label v-if="!audioUrl" for="audio">Enter Audio</label>
                    <iframe v-if="audioUrl" id="audio_iframe" :src="audioUrl" width="100%" height="100" frameborder="0" scrolling="no">
                    </iframe>
                    <input class="form-control" :value="audioUrl" name="pb_audio" type="text" id="audio" placeholder="Enter Audio Url">
                    <div class="teachings-create__media-btns">
                        <button @click="getPodbeanAudio" type="button" class="btn btn-light btns__icon" data-toggle="modal" data-target="#loadMediaModal"><span data-feather="volume-2"></span>Get From Podbean</button>
                    </div>

                </div>
                <scripture-component @description="setDescription($event)" @teachingTitle="setTeachingTitle($event)"></scripture-component>
            </div>

            <aside class="admin-form__sidebar">
                <p class="admin-form__time">Today's Date: <span id="today"></span></p>
                <div class="form-group admin-form__btns">
                    <button type="submit" class="btn btn-info btns__icon admin-form__publish-btn"><span
                            data-feather="save"></span>Save Teaching</button>
                    <button type="submit" class="btn btn-primary btns__icon admin-form__publish-btn"><span
                            data-feather="send"></span>Publish Teaching</button>
                </div>

                <div class="form-group">
                    <label for="publish-date" class="d-block">Publish Date</label>
                    <input class="form-control" name="publish-date" type="date" id="publish-date">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea v-model="description" class="form-control" rows="4" name="description" cols="50" id="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Featured Image</label>
                    <input @change="imagePreview" class="form-control-file admin-form__ft-img-input" name="image" type="file" id="ft_image">
                    <div class="admin-form__image-preview">
                        <svg v-if="!ftImg" viewBox="0 0 507.99999 285.75001">
                            <defs id="defs2">
                                <filter id="filter4639" style="color-interpolation-filters:sRGB;">
                                    <feConvolveMatrix id="feConvolveMatrix4635" order="3 3"
                                        kernelMatrix="1 1 1 1 -8 1 1 1 1" in="SourceGraphic" divisor="1" targetX="1"
                                        targetY="1" preserveAlpha="true" result="result0" bias="0" />
                                    <feColorMatrix id="feColorMatrix4637" result="result3"
                                        values="-0.15 -0.3 -0.05 0 1 -0.15 -0.3 -0.05 0 1 -0.15 -0.3 -0.05 0 1 0 0 0 1 0" />
                                </filter>
                            </defs>
                            <metadata id="metadata5">
                                <rdf:RDF>
                                    <cc:Work rdf:about="">
                                        <dc:format>image/svg+xml</dc:format>
                                        <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
                                        <dc:title></dc:title>
                                    </cc:Work>
                                </rdf:RDF>
                            </metadata>
                            <g transform="translate(0,-11.249983)" id="layer1">
                                <g transform="translate(-1.4157104,1.2974741)" id="g4646">
                                    <rect
                                        style="opacity:1;fill:#cccccc;fill-opacity:1;stroke:none;stroke-width:0.93530208;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                        id="rect4518" width="508.88116" height="287.58203" x="0.53454089" y="9.9525089" />
                                    <text xml:space="preserve"
                                        style="font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:70.20953369px;line-height:1.25;font-family:sans-serif;-inkscape-font-specification:'sans-serif, Normal';font-variant-ligatures:normal;font-variant-caps:normal;font-variant-numeric:normal;font-feature-settings:normal;text-align:center;letter-spacing:0px;word-spacing:0px;writing-mode:lr-tb;text-anchor:middle;fill:#ffffff;fill-opacity:1;stroke:#000000;stroke-width:1.75523829;stroke-opacity:0.21531101;"
                                        x="217.01743" y="109.48398" id="text4545" transform="scale(1.156635,0.86457698)">
                                        <tspan id="tspan4543" x="229.35895" y="109.48398"
                                            style="font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:70.20953369px;font-family:sans-serif;-inkscape-font-specification:'sans-serif, Normal';font-variant-ligatures:normal;font-variant-caps:normal;font-variant-numeric:normal;font-feature-settings:normal;text-align:center;writing-mode:lr-tb;text-anchor:middle;stroke-width:1.75523829;stroke:#000000;stroke-opacity:0.21531101;fill:#ffffff;fill-opacity:1;">
                                            Select </tspan>
                                        <tspan x="229.35895" y="197.2459"
                                            style="font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:70.20953369px;font-family:sans-serif;-inkscape-font-specification:'sans-serif, Normal';font-variant-ligatures:normal;font-variant-caps:normal;font-variant-numeric:normal;font-feature-settings:normal;text-align:center;writing-mode:lr-tb;text-anchor:middle;stroke-width:1.75523829;stroke:#000000;stroke-opacity:0.21531101;fill:#ffffff;fill-opacity:1;"
                                            id="tspan4547">Feature </tspan>
                                        <tspan x="217.01743" y="285.00781"
                                            style="font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:70.20953369px;font-family:sans-serif;-inkscape-font-specification:'sans-serif, Normal';font-variant-ligatures:normal;font-variant-caps:normal;font-variant-numeric:normal;font-feature-settings:normal;text-align:center;writing-mode:lr-tb;text-anchor:middle;stroke-width:1.75523829;stroke:#000000;stroke-opacity:0.21531101;fill:#ffffff;fill-opacity:1;"
                                            id="tspan4549">Image</tspan>
                                    </text>
                                </g>
                            </g>
                        </svg>
                        <img v-else :src="ftImg" class="img-fluid d-block">
                        <button v-if="ftImg" @click.prevent="removeImg" id="remove-img" class="btn btn-light admin-form__remove-img-btn">&times; Remove Image</button>
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

const ScriptureComponent = Vue.component('scripture-component', require('./ScriptureComponent.vue').default);

export default {


    data() {
        return {
            audioId: '',
            audioUrl: '',
            baseUrl: location.origin + "/api/",
            description: '',
            enterSpeaker: false,
            ftImg: '',
            loader: false,
            loadMoreBtn: false,
            mediaSelected: false,
            mediaType: '',
            loadmore: true,
            topical: false,
            teachingTitle: "",
            vidId: '',
            vidSrc: '',
            videoValue: ''
        }
    },

    components: {
        ScriptureComponent
    },

    props: [ 'action', 'csrf' ],

    methods: {

    // Event methods =========/
        // ========================

    // add event for audio input change

        audioValueChange() {
            const audioInput = $('[name="pb_audio"]');

            $(audioInput).on('change', e => {
                this.insertAudio(e);
            });

        },


    // insert featured image onto screen before loading into the database
        imagePreview(e) {
            const file = e.target.files[0];
            this.readFile(file);
        },


    // emptyModal when backdrop is clicked
        modalBackdropClickCancel() {
            $("#loadMediaModal").on('hide.bs.modal', this.emptyModal);
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



    // add event for video input change
        vidValueChange() {

            const videoInput = $('[name="yt_video"]');

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

        dateDefaultVal() {
            let     date = new Date();

            const   offset = date.getTimezoneOffset(),
                    input = $('#publish-date');

                    date = new Date(date.getTime() - (offset*60*1000));
                    date = date.toISOString().split("T")[0];

                    // set date value attr
                    $(input).attr('value', date);
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

        //set media type
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

                let audioValue = $(e.target).val();

                    audioValue = audioValue.replace('share', 'player');
                    audioValue = audioValue.replace('pb-', '');

                    this.audioUrl = audioValue;
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
            const vidVal = $('[name="yt_video"]').val(),
                  regX = /(?<=https:\/\/youtu\.be\/).+$/;

                  if(!vidVal) {

                      this.videoValue = '';
                      this.vidSrc = '';

                      return;

                  } else {
                      this.vidId = vidVal.match(regX)[0];
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

                    window.location = `${location.origin}/admin/teachings#${vidId}`;

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

            let media = $(e.target);

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
                this.vidId = $(e.target).attr('data-media-id');
            }

            if(this.mediaType === 'audio') {
                // Set the audio Id =======/
                this.audioId = $(e.target).attr('data-media-id');
                this.audioUrl = $(e.target).attr('data-audio-url');
            }

        },

        setDescription(description) {
            this.description = description;
        },


        setTeachingTitle(title) {
            this.teachingTitle = title;
        },


        todaysDate() {
             const today = new Date().toDateString();
             $('#today').text(today);
        }


    }, // end of methods =========/

    mounted() {
        this.audioValueChange();
        this.dateDefaultVal();
        this.modalBackdropClickCancel();
        this.todaysDate();
        this.vidValueChange();
    }

}
</script>

<style>

</style>
