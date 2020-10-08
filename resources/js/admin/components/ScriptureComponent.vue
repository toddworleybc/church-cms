<template>
<div id="bible-api" class="form-group scripture">

    <label for="book">Enter Teaching Scripture</label>
    <div class="scripture__input-container"></div>

        <div @click="rotateSvg()" id="add-scripture-btn" class="scripture__add-verse">
            <span data-feather="plus-square"></span>
        </div>

    <div class="scripture__text">
        <h3>Acts 26, 1-4</h3>
        <p>1 Then Agrippa said to Paul, "You are permitted to speak for yourself." So Paul stretched out his
            hand and answered for
            himself: <p></p> <p>2 "I think myself happy, King Agrippa, because today I shall answer for myself
            before you concerning all the
            things of which I am accused by the Jews,</p>
        <p>3 especially because you are expert in all customs and questions which have to
            do with the Jews. Therefore I beg you to hear me patiently.</p>
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
            delay: false
        }
    },


    methods: {
        rotateSvg(reverse = false, e) {

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




        // set delay
                setTimeout(() => {
                    this.delay = false;
                }, 1000);


        },

        addVerse() {

        // Set unique #id for each minus button NOTE: will probably be added to the scripture__select div as well later
            this.verseId += 1;
            const removeVerseId = `remove-verse-${this.verseId}`;

        // scripture__select html
            const html = `<div class="scripture__select">

            <select class="custom-select" id="book" name="book">
                <option value="none" selected="selected">Book</option>
                <option value="mathew">Mathew</option>
                <option value="mark">Mark</option>
                <option value="luke">Luke</option>
            </select>

            <select class="custom-select" name="chapter">
                <option value="none" selected="selected">Chapter</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <select class="custom-select" name="verse">
                <option value="none" selected="selected">Verse</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <span>-To-</span>
            <select class="custom-select" name="verse">
                <option value="none" selected="selected">Verse</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <div id="${removeVerseId}" class="scripture__remove-verse">
                <span data-feather="minus-square"></span>
            </div>
        </div>`;


        // Add html select to the DOM
            $(".scripture__input-container").append(html);
            feather.replace();

        // Add click event to minus-square svg when DOM is created
            $(`#${removeVerseId}`).on('click', e => {
                this.rotateSvg(true,e);
            });

        }, // add verse


        removeVerse(e) {

            // Fix bug where if the Rect or Line was clicked on svg it will make sure that it relates to the svg itself
                if(e.target.localName === "line" || e.target.localName === "rect") e.target = e.target.parentNode;

            // Add fade effect to remove scripture select
                $(e.target).parent().parent().addClass('scripture__fade-out').animate({
                    height: "0px",
                    padding: "0px",
                    margin: "0px"
                }, 600);
            // make sure animation is over before removing select
                setTimeout(() => {
                    $(e.target).parent().parent().remove();
                }, 700);
        }
    }

}
</script>

<style>

</style>
