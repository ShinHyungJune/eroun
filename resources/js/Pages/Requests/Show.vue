<template>
    <div class="subContent area-workerDetail">
        <div class="section-title type02">
            <div class="wrap">
                <h3 class="title">{{ request.title }}</h3>
                <div class="infos">
                    <p class="info">등록일 : {{ request.created_at }}</p>
                    <p class="info">지원자수 : {{ request.count }}</p>
                </div>
            </div>
        </div>

        <div class="wrap">
            <div class="m-empty type01" v-if="applications.data.length === 0">
                데이터가 없습니다.
            </div>

            <applications :items="applications.data" :request="request" />
        </div>
    </div>
</template>
<script>
import Applications from "../../Components/Applications";
import {Link} from "@inertiajs/inertia-vue";
export default {
    components: {Link, Applications},

    data() {
        return {
            request: this.$page.props.request.data,
            applications: this.$page.props.applications
        }
    },

    methods: {

    },
}
</script>
