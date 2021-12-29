<template>
    <div class="items type03">
        <div class="item-wrap" v-for="item in items" :key="item.id">
            <Link :href="`/requests/${item.id}`" class="item">
                <div class="content">
                    <h3 class="title">
                        <!--
                        <span :class="`state ${item.worker.state}`">{{ item.worker.state === "finished" ? "모집마감" : "모집중" }}</span>
                        -->
                        {{item.title}}
                        <button :class="`btn state01 ${item.state}`" v-if="item.state === 'finished'">지원마감</button>
                        <button :class="`btn state01 ${item.state}`" v-if="item.state === 'already'">지원완료</button>
                        <Link :href="`/applications/create?request_id=${item.id}`" :class="`btn state01 ${item.state}`" v-if="item.state === 'ongoing' && user.worker">지원하기</Link>
                    </h3>

                    <div class="highlights">
                        <div class="highlight">
                            <img src="/img/user.png" alt="">

                            {{ item.count }}명 지원
                        </div>

                        <div class="highlight">
                            <img src="/img/won.png" alt="">

                            {{ item.price }}원
                        </div>
                    </div>

                    <div class="infos">
                        <div class="info">
                            <p class="info-title">행사유형 : </p>
                            <p class="info-body">{{ item.category }}</p>
                        </div>

                        <div class="info">
                            <p class="info-title">선호스타일 : </p>
                            <p class="info-body">{{ item.style }}</p>
                        </div>

                        <div class="info">
                            <p class="info-title">필요날짜 : </p>
                            <p class="info-body">{{ item.required_at }}</p>
                        </div>
                    </div>

                    <div class="infos">
                        <div class="info">
                            <p class="info-title">장소 : </p>
                            <p class="info-body">{{ item.address }}</p>
                        </div>

                        <div class="info">
                            <p class="info-title">추가내용 : </p>
                            <p class="info-body">{{ item.comment }}</p>
                        </div>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>
<script>
    import {Link} from '@inertiajs/inertia-vue';

    export default {
        components: {Link},
        props: ["items"],
        data(){
            return {
                user: this.$page.props.user.data
            }
        }
    }
</script>
