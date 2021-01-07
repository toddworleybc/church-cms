<template>
    <div class="admin-table__filters">
        <div class="form-row">
            <div class="form-group mr-2">
                <label for="order-by">Filter Only:</label>
                <select @change="filterTable" id="filter" class="custom-select">
                    <option value="all">All Teachings</option>
                    <option value="Published">Published</option>
                    <option value="Draft">Draft</option>
                    <option value="teaching">Teachings</option>
                    <option value="topical">Topical Teachings</option>
                </select>
            </div>
            <div class="form-group mr-2">
                <label for="order-by">Order By:</label>
                <select @change="filterTable" id="order_by" class="custom-select">
                    <option value="publish_date">Publish Date</option>
                    <option value="title">Title</option>
                    <option value="created_at">Created Date</option>
                    <option value="updated_at">Modified Date</option>
                </select>
            </div>
            <div class="form-group">
                <label for="order-direction">Order Direction:</label>
                <select @change="filterTable" id="direction" class="custom-select">
                    <option value="desc">Last To First</option>
                    <option value="asc">First To Last</option>
                </select>
            </div>

        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            baseUrl: `${location.origin}/admin/teachings?`
        }
    },

    props: {
        direction: String,
        filter: String,
        orderBy: String
    },

    methods: {

        filterTable(e) {

            const filterSelectVal = $(e.target).val(),
                  filterSelectParam = $(e.target).attr('id'),

                  url = this.getUrlWithQuerys(filterSelectParam, filterSelectVal);


                window.location = encodeURI(url);


        },

        getUrlWithQuerys(filterSelectParam, filterSelectVal) {

            let url = `${this.baseUrl}`;


        // Attach filter query param
            if(filterSelectParam === "filter") {

                    url += `filter=${filterSelectVal}&`;

                } else {

                    if(this.filter) {
                        url += `filter=${this.filter}&`;
                    }
                }

            // Attach order by query param
                if(filterSelectParam === "order_by") {

                    url += `order_by=${filterSelectVal}&`;

                } else {

                    url += `order_by=${this.orderBy}&`;

                }

            // Attach direction query param
                if(filterSelectParam === "direction") {
                    url += `direction=${filterSelectVal}`;
                } else {
                    url += `direction=${this.direction}`;
                }


                return url;


        },

        setFilterOptions() {


            if(this.filter) {
                $(`option[value=${this.filter}]`).prop('selected', true);
            }

            if(this.orderBy) {
                $(`option[value=${this.orderBy}]`).prop('selected', true);
            }


            if(this.direction) {
                $(`option[value=${this.direction}]`).prop('selected', true);
            }

        }


    },

    mounted() {
        this.setFilterOptions();
    }
}
</script>

