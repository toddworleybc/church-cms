<template>
  <div class="table-responsive admin-table">
    <table class="table table-hover admin-table__table">
            <thead class="admin-table__head">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Speaker</th>
                    <th scope="col">Status</th>
                    <th scope="col">Published</th>
                    <th scope="col">Created</th>
                    <th scope="col">Updated</th>
                </tr>
            </thead>
            <tbody>

            <tr scope="row" @click="editTeaching" :id="`teaching-${teaching.id}`"  v-for="teaching in teachings" :data-teaching-id="teaching.id" :key="teaching.id">
                <td>{{ teaching.id }}</td>
                <td>{{ teaching.title }}</td>
                <td>{{ teaching.speaker ? teaching.speaker : teaching.staff_id }}</td>
                <td>{{ teaching.status }}</td>
                <td>{{ teaching.publish_date }}</td>
                <td>{{ teaching.created_at }}</td>
                <td>{{ teaching.updated_at }}</td>
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
            created_at: "",
            publish_date: "",
            teachings: [],
            updated_at:"",
        }
    },

    props: [
        "teachingsData"
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
    }





}
</script>

<style>

</style>
