<template>
<div id="bible-api" class="form-group scripture">
    <div class="scripture__label-heading">
        <label for="book">Add Bible Scriptures:</label>
        <div v-if="loader" class="d-inline-flex mb-0 fadeInOut">
            <p class="text-secondary mb-0">Loading...</p>
            <div class="spinner-border spinner-border-sm text-secondary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <p class="text-secondary"><em>Book and chapters are required <span class="text-danger">*</span></em></p>

    <div class="scripture__input-container"></div>


    <div @click="rotateSvg()" id="add-scripture-btn" class="scripture__add-verse">
        <span data-feather="plus-square"></span>
    </div>
    <div>
        <button @click="generateScripture" id="scripture-gen" class="btn btn-light scripture__btn-gen">Generate Scripture
            <span data-feather="book-open"></span>
        </button>
        <div v-if="genLoader" class="spinner-border spinner-border-sm ml-1 text-dark" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <textarea name="scripture" id="scripture-input" hidden></textarea>
    <div class="scripture__text">
        <div id="scripture__insert" class="bg-light text-secondary p-4 scripture__insert"><span v-html="scripture"></span><p class="mb-0" v-if="!jsonLoad.length && !scripture">No scriptures generated...</p></div>
    </div>

</div>
</template>

<script>

import { gsap } from "gsap";
const feather = require('feather-icons');

export default {

    data() {
        return {
            deg: 0,
            verseId: 0,
            delay: false,
            description: '',
            baseUrl: location.origin + '/api/bible/',
            optionsUrl: location.origin + '/api/bible/options/',
            disableAddBtn: false,
            createdSelectInputs: "",
            loader: false,
            genLoader: false,
            jsonLoad: [],
            scripture: '',
            stopGen: false,
            teachingTitle: ""
        }
    }, //#-data



    props: [
        'scriptureHtml'
    ],


    methods: {

    // EVENTS =============
    // =====================


        addSelectDivEvents(verseId) {

        // Add click event to minus-square svg when DOM is created
            $(`#remove-verse-${verseId}`).on('click', e => {
                this.rotateSvg(true,e);});


        // Add selectInput events
            $(this.createdSelectInputs).on('change', e => {
                this.setSelectInput(e); });


        }, // ###--- EVENTS ------/


    // GENERATE SCRIPTURE =============
    // ==================================
 // Get all select input values and organize them in an object


        generateScripture(e, removeData = false) {
            e.preventDefault();

            // Stop generation if book or chapter are empty
             $('.scripture__input-container .custom-select').each( ( i, select ) => {

                 if($(select).attr('name') === 'book') {

                     if($(select).val() === 'none') {
                         $(select).addClass('is-invalid');
                         this.stopGen = true;
                     }
                 }

                 if( $(select).attr('name') === 'chapter' ) {
                     if($(select).val() === 'none') {
                         $(select).addClass('is-invalid');
                         this.stopGen = true;
                     }
                 }

            } );

            if(this.stopGen) return;

            const inputRows = $(".scripture__select");

        // remove data from this.jsonLoad
            if(removeData) {

                const removeId = $(e.target).attr('data-remove-id'),
                      itemIndex = this.jsonLoad.findIndex( row => { return row.id === removeId} );

                    if(itemIndex !== -1)
                        this.jsonLoad.splice( itemIndex, 1);

                return;
            }

        // add data to this.jsonLoad
            if(inputRows.length) {

                $(inputRows).each( (i,row) => {

                    let book    = $(row).children('[name="book"]').val(),
                        chapter = $(row).children('[name="chapter"]').val(),
                        startVs = $(row).children('[name="start_verse"]').val(),
                        endVs   = $(row).children('[name="end_verse"]').val(),
                        rowId   = $(row).attr('data-id'),
                        data = {};

                        if(book && chapter) {

                            data = {
                                id: rowId,
                                book: book,
                                chapter: chapter,
                                startVs: startVs !== 'none' ? startVs : null,
                                endVs: endVs !== 'none' ? endVs : null
                            }

                        }


                    // Prevent duplicats from entering jsonLoad

                        const duplicateExists = this.checkForDupsJson(data);

                        if(duplicateExists) return;

                    // create payload
                        this.jsonLoad.push(data);

                } ); //#- end row loop

            } //#- end if/


            this.sendPayload(this.jsonLoad);

        // Disable all selects to prevent new data from being enter
            $('.scripture__input-container .custom-select').each( ( i, select ) => {
                this.disableSelect(select);
            } );

            // Create title for post
            this.createTheTitle();

        },// ###--- GENERATE SCRIPTURE ---/






    // SELECT INPUT CONFIG ===========
    // ==============================


        addNoScripturesHtml(addNow = false) {

            const html = `<p class="mb-0">No scriptures generated...</p>`;

            if(addNow) {
                $("#scripture__insert").html(html);
                return;
            }

            if(!this.jsonLoad.length)
                $("#scripture__insert").html(html);


        },


         addVerse() {

        // Set unique #id for each minus button NOTE: will probably be added to the scripture__select div as well later
            this.verseId += 1;

        // scripture__select html verse-id-
            const html = `<div data-id="${this.verseId}" id="verse-id-${this.verseId}" class="scripture__select">

            <select class="custom-select" data-change="chapter-${this.verseId}" id="book-${this.verseId}" name="book" required>
                <option value="none" selected hidden>Book</option>
            </select>

            <select class="custom-select" data-change="start-verse-${this.verseId}" id="chapter-${this.verseId}" name="chapter" required>
                <option value="none" selected hidden>Chapters</option>
            </select>

            <select class="custom-select" data-change="end-verse-${this.verseId}" id="start-verse-${this.verseId}" name="start_verse">
                <option value="none" selected hidden>Verse</option>
            </select>

            <span>-To-</span>
            <select class="custom-select" id="end-verse-${this.verseId}" name="end_verse">
                <option value="none" selected hidden>Verse</option>
            </select>
            <div id="remove-verse-${this.verseId}" class="scripture__remove-verse">
                <span data-feather="minus-square" data-remove-id="${this.verseId}"></span>
            </div>
        </div>`;


        // Add html select to the DOM
            $(".scripture__input-container").append(html);
            feather.replace();  // remove icon

            this.createdSelectInputs = $(`#verse-id-${this.verseId} .custom-select`);


        // add events for scripture select after created
            this.addSelectDivEvents(this.verseId);


        //set books for select
            this.setBooksSelect(this.verseId);


        // disable every select
            this.disableAllSelects();


        }, // #-add verse




        createTextAreaValue() {

            const scriptureText = $("#scripture__insert").text(),
                    scriptureHtml = $("#scripture__insert").html(),
                    scriptureInput = $("#scripture-input");

                // compare text to make empty or copy scripture html
                    scriptureText === "No scriptures generated..." ?
                        $(scriptureInput).html('') :
                        $(scriptureInput).html(scriptureHtml.trim());
        },


        createTheDescription() {

            this.description = '';

            const scriptures = $(".scripture__insert p");
            let   text = '';


                $(scriptures).each( ( i, scripture ) => {
                    if(i < 2)
                        text += $(scripture).text() + " ";
                } );


            // remove verse number
                text = text.replace(/\d:/gm, '');
                text = text.substr(1, 120);


            // create description
               const  description = this.jsonLoad.length ? `${this.teachingTitle} bible teaching: ${text}...` : '';

                this.description = description;

                this.passDescriptionToParent();
        },

        editScriptureInsert() {

            setTimeout( () => {

                if(this.scriptureHtml) {

                    this.scripture = this.scriptureHtml;
                    $("#scripture-input").html(this.scriptureHtml);
                }

            }, 250 );

        },

        removeVerse(e) {


            // Fix bug where if the Rect or Line was clicked on svg it will make sure that it relates to the svg itself
                if(e.target.localName === "line" || e.target.localName === "rect") e.target = e.target.parentNode;

            // Id to remove SCRIPTURE ONLY, not select;
             const removeVsId = $(e.target).attr('data-remove-id');

             // remove scripture from json data
            this.generateScripture(e, true);

            // Add fade effect to remove scripture select
                $(e.target).parent().parent().addClass('scripture__fade-out').animate({
                    height: "0px",
                    padding: "0px",
                    margin: "0px"
                }, 600);


            //remove scripture
                $(`#scripture-${removeVsId}`).addClass('scripture__fade-out').animate({
                    height: "0px"
                }, 200);


            // make sure animation is over before removing select
                setTimeout(() => {
                    $(e.target).parent().parent().remove();
                    $(`#scripture-${removeVsId}`).remove();
                }, 700);

            // recreate the title
                this.createTheTitle();

            // add no scriptures html
                this.addNoScripturesHtml();


            // set delay to make sure html has been removed
                setTimeout(() => {
                    this.createTheDescription();

            // edit the textarea #scripture-input
                    this.createTextAreaValue();

                }, 1500);

        },





        rotateSvg(reverse = false, e) {
        // disable btn if AJAX request fails
        if(this.disableAddBtn) return;

        // Set delay on svg minus and plus buttons to prevent button mashing
        if(this.delay) return;
        this.delay = true;

        // Degree of rotation
            !reverse ?
                this.deg += 90 :
                this.deg -= 90;

        // Animation
           let anima = gsap.to('#add-scripture-btn', {
                rotate: this.deg + "deg",
                duration: 1
            });

        // Add or remove verse
            !reverse ?
            // Add the scripture__select verse
                this.addVerse() :
            // Remove scripture verse
                this.removeVerse(e);


        // set delay for btn clicking
                setTimeout(() => {
                    this.delay = false;
                }, 1000);
        },



        setSelectInput(e) {

        // Stop extra request on end_verse onChange
            if(e.target.name === 'end_verse') return;

            if(e.target.name === 'book' ) {
                $(e.target).removeClass('is-invalid');
                const chapter = $(e.target).next('[name="chapter"]');

                if($(chapter).val() !== 'none') {
                    this.stopGen = false;
                }
            }

            if(e.target.name === 'chapter') {
                $(e.target).removeClass('is-invalid');
                this.stopGen = false;
            }

            // Get the row that the select input was changed and set the select id that needs to have the html inserted
            const rowSelected = $(e.target).parent(),
                  selectChangeId = $(e.target).attr('data-change'),

                //Gets select to add options html too
                    selectToAddOptionsTo = $(rowSelected).children(`#${selectChangeId}`);


                // disable select divs after e.target is choosen. This will fix query builder url as well. Create options div with none, selected, etc....

                    const selectsToDisable = $(e.target).nextAll('.custom-select');

                    $(selectsToDisable).each( (i,select) => {
                        let getName = select.name.match(/[a-z]+$/)[0],
                            selectName = getName.charAt(0).toUpperCase() + getName.slice(1);

                            // Add "s" to the name Chapter
                            if(selectName === 'Chapter') selectName += "s";


                        $(select).html(`<option value="none">${selectName}</option>`);
                        this.disableSelect(select);
                    } );

                // =======================================

                // build url slug
                const slug = this.optionsSlugBuilder(rowSelected);

                // Insert optionsHtml into select
                this.getBibleHtmlOptions( slug, optionsHtml => {
                    $(selectToAddOptionsTo).html(optionsHtml);
                    this.enableSelect(selectToAddOptionsTo);
                } );
        },
        // ####--- END SELECT INPUT CONFIG ------------/


    // HELPER METHODS ==========/
    // ==========================/


        checkForDupsJson(data) {

            let dup = false;

           this.jsonLoad.forEach( row => {
              const storeId1 = row.id,
                    storeId2 = data.id;

                // remove unquie ids
                    row.id = null;
                    data.id = null;

                // Best way according to the "Internet" on how to compare objects...lame!
                if( JSON.stringify(row) === JSON.stringify(data) ) dup = true;

                // set ids back into objects from stored ids
                row.id = storeId1;
                data.id = storeId2

           } );

            return dup;

        },


        // Disable select option
        disableSelect(selectedInput) {
            $(selectedInput).prop('disabled', true);
        },


        // disable all selects aka RESET Selects
        disableAllSelects() {
            $(this.createdSelectInputs).each( ( i, selectInput ) => {
                this.disableSelect(selectInput);
            } );
        },

    // enable select option
        enableSelect(selectedInput) {
            $(selectedInput).prop('disabled', false);
        },


        errorMessage(error) {
            // error html
                    const html = `<div class="alert alert-danger">${error}<div>`,
                          scriptureContainer = $('.scripture__input-container');
                // Add error html
                    $(scriptureContainer).html(html);
                    this.disableAddBtn = true;
        },


        // @return html options for query
        getBibleHtmlOptions(slug, callback) {
            let url = `${this.optionsUrl}${slug}`;
            // callback data for function
            this.getData( url, data => { callback(data);} );
        },



        getData(url = this.baseUrl, callback) {
            this.loader = true;
            axios.get( url )
                .then( res => {
                  const data = res.data;
                  callback(data);
                } )
                .catch( (error) => {
                    this.errorMessage(error);
                } )
                .then( () => {
                    this.loader=false;
                } );
        },



        optionsSlugBuilder(rowSelected) {

            const allRowSelects = $(rowSelected).children('.custom-select');
            let slug = "";

            // create slug from select values
            $(allRowSelects).each( (i, select) => {
                  if($(select).val() !== 'none') {
                      slug += `${$(select).val()}/`;
                  }
            } );

            return slug;
        },



        sendPayload( jsonLoad ) {

            this.genLoader = true;
            const url = this.baseUrl + 'gen';

            axios.post(url, this.jsonLoad, {
                    headers: {'Content-Type': 'application/json'}
                 })
                .then( res => {
                    const html = res.data,
                          text = html.trim();

                // and html to generated script
                    $("#scripture__insert").html(html);

                // add scripture to textarea input hidden
                    $("#scripture-input").html(text);

                } )
                .catch( error => {
                    this.errorMessage(error);
                    this.genLoader = false;
                } )
                .then( () => {
                     this.genLoader=false;

                // create description for post
                    this.createTheDescription();

                if( !this.jsonLoad.length )
                    this.addNoScripturesHtml(true);

                } );

        },


        // Set the books select when created
        setBooksSelect(verseId) {
            this.getBibleHtmlOptions("", bookOptions => {
                const bookSelect = `#book-${verseId}`;
                $(bookSelect).append(bookOptions);
                this.enableSelect(bookSelect);
            } );
        },


        createTheTitle() {

            this.teachingTitle = "";

            this.jsonLoad.forEach( (verse, i) => {

            // Add "&" inbetween verses
                if(i > 0 ) this.teachingTitle += " & ";

            // Insert book and title into title
                this.teachingTitle += verse['book'] + " ";
                this.teachingTitle += verse['chapter'];


            // Add start verse if present
                if( verse['startVs'] ) {
                    this.teachingTitle += verse['startVs'] ? ":" + verse['startVs'] : "";
                }

            // Add end verse if present
                if( verse['endVs'] ) {
                    this.teachingTitle += verse['endVs'] ? "-" + verse['endVs'] : "";
                }

            } );

            this.passTitleToParent();

        },

        passTitleToParent() {
            this.$emit('teachingTitle', this.teachingTitle);
        },

        passDescriptionToParent() {
             this.$emit('description', this.description);
        },


    }, // #-methods


    mounted() {
        this.editScriptureInsert();
    }, // #-mounted






}
</script>

<style>

</style>
