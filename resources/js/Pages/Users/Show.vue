<template>
    <div class="subContent area-userDetail">
        <div class="section-title type02">
            <div class="wrap">
                <h3 class="title">"{{ user.name }}" 상세정보를 확인해보세요!</h3>
                <div class="infos">
                    <p class="info">등록일 : {{ user.created_at }}</p>
                    <p class="info">조회수 : {{ user.count_view }}</p>
                </div>
            </div>
        </div>

        <div class="wrap">
            <div class="section type01" style="min-height:400px;">
                <h3 class="section-title">업체 설명</h3>

                <div class="m-empty type01" v-if="!user.description" style="border:none;">
                    내용이 없습니다.
                </div>
                <div class="body" v-html="user.description"></div>
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
            user: this.$page.props.user.data,
        }
    },

    methods: {

    },
}
</script>
