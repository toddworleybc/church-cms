<template>
  <div class="table-responsive admin-table">
    <table class="table table-hover admin-table__table">
            <thead class="admin-table__head">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Image</th>
                    <th scope="col">Speaker</th>
                    <th scope="col">Published</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>

            <tr scope="row" @click="editTeaching" class="teaching-row" :id="`teaching-${teaching.id}`"  v-for="(teaching, i) in teachings" :data-teaching-id="teaching.id" :key="teaching.id">
                <td>{{ teaching.title.length > 25 ? teaching.title.substr(0, 25) + "..." : teaching.title }}</td>
                <td>
                    <img v-if="teaching.ft_image" :src="`${baseUrl}/${teaching.ft_image}`" alt="" width="50px">
                    <svg v-else width="50px" height="25px" viewBox="0 0 17 16" class="bi bi-image" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14.002 2h-12a1 1 0 0 0-1 1v9l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094L15.002 9.5V3a1 1 0 0 0-1-1zm-12-1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm4 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                    </svg>
                <td>{{ teaching.speaker ? teaching.speaker : staffNames[i] }}</td>

                <td>{{ teaching.publish_date }}</td>
                <td><span :class="teaching.status === 'Draft' ? 'alert alert-danger m-1 p-1 px-4' : 'alert alert-success m-1 p-1 px-4'" >{{ teaching.status }}</span></td>
            </tr>

            </tbody>
        </table>
    </div>
</template>

<script>

const moment = require('moment');

export default {

    data() {
        return {
            ftImg: "",
            baseUrl: location.origin,
            staffNames: [],
            teachings: [],
        }
    },

    props: [
        "teachingsData",
        "staffNamesData"
    ],


    methods: {

        // convert table dates

        dateConvert() {

            $(this.teachings).each( (i, teaching) => {

                teaching.created_at = moment(teaching.created_at).fromNow();

                teaching.publish_date = moment(teaching.publish_date).format("MMM Do, YYYY");

                teaching.updated_at = moment(teaching.updated_at).fromNow();

            } );

        },

    // set edit url for each table row
        editTeaching(e) {
            const id = $(e.target).parents("tr").attr('data-teaching-id');
            window.location = `teachings/${id}/edit `;
        },



    },



    mounted() {
        this.teachings = JSON.parse(this.teachingsData);
        this.dateConvert();
        this.staffNames = JSON.parse(this.staffNamesData);
    }


}
</script>

<style>

</style>
