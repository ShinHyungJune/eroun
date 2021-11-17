<template>
    <div class="subContent area-workerDetail">
        <div class="section-title type02">
            <div class="wrap">
                <h3 class="title">{{ event.title }}</h3>
                <div class="infos">
                    <p class="info">등록일 : {{ event.created_at }}</p>
                    <p class="info">조회수 : {{ event.count_view }}</p>
                </div>
            </div>
        </div>

        <div class="wrap">
            <div class="section type01">
                <div class="m-empty type01" v-if="!event.description" style="border:none;">
                    내용이 없습니다.
                </div>
                <div class="body" style="min-height:400px;" v-html="event.description"></div>
            </div>

        </div>
    </div>
</template>
<script>
import {Link} from "@inertiajs/inertia-vue";
export default {
    components: {Link},

    data() {
        return {
            event: this.$page.props.event.data,
        }
    },

    methods: {

    },
}
</script>
