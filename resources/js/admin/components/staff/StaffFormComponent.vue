<template>

    <div class="admin-form staff-create">
        <form id="staff-form" method="post" :action="action" accept-charset="UTF-8" enctype="multipart/form-data">

        <input type="hidden" name="_token" :value="csrf">


        <div class="admin-form__wrapper">
            <div class="admin-form__main">
                <div class="form-group">
                    <label for="name">Enter Name</label>
                    <input id="name" class="form-control" type="text" name="name">
                </div>
                <div class="form-group">
                    <label for="position">Enter Position</label>
                    <input id="position" class="form-control" type="text" name="position">
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
                    <textarea id="bio" rows="30" class="form-control" type="text" name="bio"></textarea>
                </div>
            </div>
            <!-- end of main  -->
            <div class="admin-form__sidebar">
                <div class="form-group admin-form__image">
                    <label for="image">Profile Pic</label>
                    <input @change="imagePreview" class="form-control-file admin-form__ft-img-input" name="image" type="file" id="image">
                    <div class="admin-form__image-preview">

                        <img v-if="!ftImg" class="img-fluid" :src="imgPath" alt="select-image">

                        <img v-else :src="ftImg" class="img-fluid d-block">
                        <button v-if="ftImg" @click.prevent="removeImg" id="remove-img" class="btn btn-light admin-form__remove-img-btn">&times; Remove Image</button>
                    </div>
                </div>
                <div class="admin-form__btns">
                    <button type="submit" class="btn btn-primary btns__icon"><span data-feather="user-plus"></span> Create Staff Member</button>
                </div>
            </div>
        </div>




        </form>
    </div>





</template>

<script>
export default {

    data() {
        return {
            ftImg: ''
        }
    },



    props: [ 'action', 'csrf', 'imgPath' ],

    methods: {


    // insert featured image onto screen before loading into the database
        imagePreview(e) {
            const file = e.target.files[0];
            this.readFile(file);
        },

        readFile(file) {

            const reader = new FileReader();

            $(reader).on('load', (e) => {
                this.ftImg = e.target.result;
            });

             reader.readAsDataURL(file);
        },

         removeImg() {
            $('#image').val('');
            this.ftImg = '';
        },



// install tinymce
        tinymceInit() {
            var editor_config = {
                path_absolute : "/",
                selector: '#bio',
                relative_urls: false,
                plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                file_picker_callback : function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no",
                    onMessage: (api, message) => {
                    callback(message.content);
                    }
                });
                }
            };

            tinymce.init(editor_config);
        }
    },

    mounted() {
        this.tinymceInit();
    }


} // end of export default

</script>
