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

            </tbody>
        </table>
    </div>
</template>

<script>
export default {


    props: [ 'staff' ],


    methods: {



    },

    mounted() {
        console.log(this.staff);
    }



}
</script>

<style>

</style>
