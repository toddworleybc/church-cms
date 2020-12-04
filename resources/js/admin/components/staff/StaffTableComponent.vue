<template>
  <div class="table-responsive admin-table">
    <table class="table table-hover admin-table__table">
            <thead class="admin-table__head">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Position</th>
                    <th scope="col">Profile Pic</th>
                    <th scope="col">Created</th>
                    <th scope="col">Updated</th>
                </tr>
            </thead>
            <tbody>
                <tr @click="editStaffMember" :data-staff-id="staffMember.id" scope="row" v-for="staffMember in staffMembers" :key="staffMember.id">
                    <td>{{ staffMember.id }}</td>
                    <td>{{ staffMember.name }}</td>
                    <td>{{ staffMember.position }}</td>
                    <td><img v-if="staffMember.image" :src="`${baseUrl}/${staffMember.image}`" width="50px"><svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></td>
                    <td>{{ staffMember.created_at }}</td>
                    <td>{{ staffMember.updated_at }}</td>
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
            baseUrl: location.origin,
            staffMembers: [],
        }
    },



    props: [ 'staffData' ],


    methods: {



        // convert table dates

        dateConvert() {

            $(this.staffMembers).each( (i, staffMember) => {

                    staffMember.created_at = moment(staffMember.created_at).fromNow();

                    staffMember.publish_date = moment(staffMember.publish_date).format("MMM Do, YYYY");

                    staffMember.updated_at = moment(staffMember.updated_at).fromNow();

            } );

        },



        // set edit url for each table row
        editStaffMember(e) {
            const id = $(e.target).parents("tr").attr('data-staff-id');
            window.location = `staff/${id}/edit `;
        },



    },

    mounted() {
        this.staffMembers = JSON.parse(this.staffData);
        this.dateConvert();
    }



}
</script>

<style>

</style>
